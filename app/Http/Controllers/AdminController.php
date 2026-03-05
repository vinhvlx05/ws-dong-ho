<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ==================== ĐĂNG NHẬP / ĐĂNG XUẤT ====================
    
    public function login()
    {
        // Nếu đã đăng nhập, chuyển về dashboard
        if (session()->has('user')) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }
    
    public function processLogin(Request $request)
    {
        $username = $request->username;
        $password = $request->pswd; // Form dùng name="pswd"
        
        // Tìm user
        $user = DB::table('user')
            ->where('user_username', $username)
            ->first();
        
        // Kiểm tra user tồn tại và mật khẩu đúng
        if ($user && Hash::check($password, $user->user_password)) {
            // ✅ Kiểm tra role = 1 là admin
            if ($user->user_role == 1) {
                // Lưu session
                session(['user' => [
                    [
                        'user_id' => $user->user_id,
                        'username' => $user->user_username,
                        'role' => $user->user_role,
                        'fullname' => $user->user_fullname
                    ]
                ]]);
                
                return redirect('/admin/dashboard')->with('success', 'Đăng nhập thành công!');
            } else {
                // ✅ Role = 0 là user thường, không cho vào admin
                return redirect('/admin/dang-nhap')->with('error', 'Bạn không có quyền truy cập Admin!');
            }
        }
        
        return redirect('/admin/dang-nhap')->with('error', 'Tài khoản hoặc mật khẩu không đúng!');
    }
    
    public function logout()
    {
        session()->forget('user');
        return redirect('/admin/dang-nhap')->with('success', 'Đã đăng xuất!');
    }
    
    // ==================== DASHBOARD ====================
    
    public function dashboard()
    {
        // Thống kê tổng quan
        $totalProducts = DB::table('product')->count();
        $totalOrders = DB::table('orders')->count();
        
        // ✅ Đếm user thường (role = 0)
        $totalUsers = DB::table('user')->where('user_role', 0)->count();
        
        $totalRevenue = DB::table('orders')
            ->where('order_status', '!=', 'cancelled')
            ->sum('order_total');
        
        // Đơn hàng gần đây
        $recentOrders = DB::table('orders')
            ->join('user', 'orders.order_user_id', '=', 'user.user_id')
            ->select('orders.*', 'user.user_fullname')
            ->orderBy('order_id', 'desc')
            ->limit(5)
            ->get();
        
        // Đơn hàng chờ xử lý
        $pendingOrders = DB::table('orders')
            ->where('order_status', 'pending')
            ->count();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders', 
            'totalUsers',
            'totalRevenue',
            'recentOrders',
            'pendingOrders'
        ));
    }
    
    // ==================== THỐNG KÊ ====================
    
    public function statistics()
    {
        // Doanh thu theo tháng trong năm hiện tại
        $revenueByMonth = DB::table('orders')
            ->selectRaw('MONTH(order_created_at) as month, SUM(order_total) as total')
            ->whereYear('order_created_at', date('Y'))
            ->where('order_status', '!=', 'cancelled')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');
        
        // Đảm bảo có đủ 12 tháng
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[$i] = isset($revenueByMonth[$i]) ? $revenueByMonth[$i]->total : 0;
        }
        
        // Sản phẩm bán chạy nhất
        $topProducts = DB::table('order_details')
            ->join('product', 'order_details.detail_product_id', '=', 'product.product_id')
            ->selectRaw('product.product_name, product.product_img, SUM(order_details.detail_quantity) as total_sold, SUM(order_details.detail_quantity * order_details.detail_product_price) as revenue')
            ->groupBy('product.product_id', 'product.product_name', 'product.product_img')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();
        
        // Đơn hàng theo trạng thái
        $ordersByStatus = DB::table('orders')
            ->selectRaw('order_status, COUNT(*) as count')
            ->groupBy('order_status')
            ->get()
            ->keyBy('order_status');
        
        $statusData = [
            'pending' => isset($ordersByStatus['pending']) ? $ordersByStatus['pending']->count : 0,
            'processing' => isset($ordersByStatus['processing']) ? $ordersByStatus['processing']->count : 0,
            'shipping' => isset($ordersByStatus['shipping']) ? $ordersByStatus['shipping']->count : 0,
            'completed' => isset($ordersByStatus['completed']) ? $ordersByStatus['completed']->count : 0,
            'cancelled' => isset($ordersByStatus['cancelled']) ? $ordersByStatus['cancelled']->count : 0,
        ];
        
        // Sản phẩm theo danh mục
        $productsByCategory = DB::table('product')
            ->join('category', 'product.product_category', '=', 'category.category_id')
            ->selectRaw('category.category_name, COUNT(*) as count')
            ->groupBy('category.category_id', 'category.category_name')
            ->get();
        
        // Khách hàng mua nhiều nhất
        $topCustomers = DB::table('orders')
            ->join('user', 'orders.order_user_id', '=', 'user.user_id')
            ->selectRaw('user.user_fullname, user.user_username, COUNT(orders.order_id) as order_count, SUM(orders.order_total) as total_spent')
            ->where('orders.order_status', '!=', 'cancelled')
            ->groupBy('user.user_id', 'user.user_fullname', 'user.user_username')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();
        
        return view('admin.statistics', compact(
            'monthlyRevenue',
            'topProducts',
            'statusData',
            'productsByCategory',
            'topCustomers'
        ));
    }
    
    // ==================== SẢN PHẨM ====================
    
    public function productList()
    {
        $products = DB::table('product')
            ->join('category', 'product.product_category', '=', 'category.category_id')
            ->select('product.*', 'category.category_name')
            ->orderBy('product.product_id', 'desc')
            ->get();
        
        return view('admin.product_list', compact('products'));
    }
    
    public function productInsertForm()
    {
        $categories = DB::table('category')->get();
        return view('admin.product_insert_form', compact('categories'));
    }
    
    public function storeProduct(Request $request)
    {
        // Upload ảnh
        $imagePath = '';
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img'), $imageName);
            $imagePath = 'img/' . $imageName;
        }
        
        // Thêm sản phẩm
        DB::table('product')->insert([
            'product_name' => $request->name,
            'product_price' => $request->price,
            'product_img' => $imagePath,
            'product_description' => $request->description,
            'product_category' => $request->category
        ]);
        
        return redirect('/admin/danh-sach-san-pham')->with('success', 'Thêm sản phẩm thành công!');
    }
    
    public function productInfoForm($id)
    {
        $products = DB::table('product')->where('product_id', $id)->get();
        $categories = DB::table('category')->get();
        
        if ($products->isEmpty()) {
            return redirect('/admin/danh-sach-san-pham')->with('error', 'Sản phẩm không tồn tại!');
        }
        
        return view('admin.product_info_form', compact('products', 'categories'));
    }
    
    public function updateProduct(Request $request)
    {
        $imagePath = $request->img_old;
        
        // Nếu có ảnh mới
        if ($request->hasFile('img')) {
            // Xóa ảnh cũ
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
            
            // Upload ảnh mới
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img'), $imageName);
            $imagePath = 'img/' . $imageName;
        }
        
        // Cập nhật sản phẩm
        DB::table('product')
            ->where('product_id', $request->id)
            ->update([
                'product_name' => $request->name,
                'product_price' => $request->price,
                'product_img' => $imagePath,
                'product_description' => $request->description,
                'product_category' => $request->category
            ]);
        
        return redirect('/admin/danh-sach-san-pham')->with('success', 'Cập nhật sản phẩm thành công!');
    }
    
    public function deleteProduct($id)
    {
        // Lấy thông tin sản phẩm để xóa ảnh
        $product = DB::table('product')->where('product_id', $id)->first();
        
        if ($product && file_exists(public_path($product->product_img))) {
            unlink(public_path($product->product_img));
        }
        
        // Xóa sản phẩm
        DB::table('product')->where('product_id', $id)->delete();
        
        return redirect('/admin/danh-sach-san-pham')->with('success', 'Xóa sản phẩm thành công!');
    }
    
    // ==================== DANH MỤC ====================
    
    public function categoryList()
    {
        $categories = DB::table('category')->get();
        return view('admin.category_list', compact('categories'));
    }
    
    public function categoryInsertForm()
    {
        return view('admin.category_insert_form');
    }
    
    public function storeCategory(Request $request)
    {
        DB::table('category')->insert([
            'category_name' => $request->name
        ]);
        
        return redirect('/admin/danh-sach-danh-muc')->with('success', 'Thêm danh mục thành công!');
    }
    
    public function categoryInfoForm($id)
    {
        $categories = DB::table('category')->where('category_id', $id)->get();
        
        if ($categories->isEmpty()) {
            return redirect('/admin/danh-sach-danh-muc')->with('error', 'Danh mục không tồn tại!');
        }
        
        return view('admin.category_info_form', compact('categories'));
    }
    
    public function updateCategory(Request $request)
    {
        DB::table('category')
            ->where('category_id', $request->id)
            ->update([
                'category_name' => $request->name
            ]);
        
        return redirect('/admin/danh-sach-danh-muc')->with('success', 'Cập nhật danh mục thành công!');
    }
    
    public function deleteCategory($id)
    {
        // Kiểm tra xem danh mục có sản phẩm không
        $productCount = DB::table('product')->where('product_category', $id)->count();
        
        if ($productCount > 0) {
            return redirect('/admin/danh-sach-danh-muc')->with('error', 'Không thể xóa danh mục đang có sản phẩm!');
        }
        
        DB::table('category')->where('category_id', $id)->delete();
        
        return redirect('/admin/danh-sach-danh-muc')->with('success', 'Xóa danh mục thành công!');
    }
    
    // ==================== NGƯỜI DÙNG ====================
    
    public function userList()
    {
        $users = DB::table('user')->get();
        return view('admin.user_list', compact('users'));
    }
    
    public function userInsertForm()
    {
        return view('admin.user_insert_form');
    }
    
    public function storeUser(Request $request)
    {
        // Kiểm tra username đã tồn tại
        $existingUser = DB::table('user')
            ->where('user_username', $request->username)
            ->first();
        
        if ($existingUser) {
            return redirect('/admin/them-nguoi-dung')->with('error', 'Tài khoản đã tồn tại!');
        }
        
        // Thêm user mới với password đã hash
        DB::table('user')->insert([
            'user_username' => $request->username,
            'user_password' => Hash::make($request->password),
            'user_fullname' => $request->fullname,
            'user_address' => $request->address,
            'user_role' => $request->role
        ]);
        
        return redirect('/admin/danh-sach-nguoi-dung')->with('success', 'Thêm người dùng thành công!');
    }
    
    public function userInfoForm($id)
    {
        $users = DB::table('user')->where('user_id', $id)->get();
        
        if ($users->isEmpty()) {
            return redirect('/admin/danh-sach-nguoi-dung')->with('error', 'Người dùng không tồn tại!');
        }
        
        return view('admin.user_info_form', compact('users'));
    }
    
    public function updateUser(Request $request)
    {
        DB::table('user')
            ->where('user_id', $request->id)
            ->update([
                'user_username' => $request->username,
                'user_fullname' => $request->fullname,
                'user_address' => $request->address,
                'user_role' => $request->role
            ]);
        
        return redirect('/admin/danh-sach-nguoi-dung')->with('success', 'Cập nhật người dùng thành công!');
    }
    
    public function deleteUser($id)
    {
        // Không cho phép xóa chính mình
        if (session()->has('user')) {
            $currentUser = session()->get('user')[0];
            if ($currentUser['user_id'] == $id) {
                return redirect('/admin/danh-sach-nguoi-dung')->with('error', 'Không thể xóa tài khoản đang đăng nhập!');
            }
        }
        
        DB::table('user')->where('user_id', $id)->delete();
        
        return redirect('/admin/danh-sach-nguoi-dung')->with('success', 'Xóa người dùng thành công!');
    }
    
    // ==================== ĐƠN HÀNG ====================
    
    public function orderList()
    {
        $orders = DB::table('orders')
            ->join('user', 'orders.order_user_id', '=', 'user.user_id')
            ->select('orders.*', 'user.user_fullname', 'user.user_username')
            ->orderBy('order_id', 'desc')
            ->get();
        
        return view('admin.order_list', compact('orders'));
    }
    
    public function orderDetail($id)
    {
        $order = DB::table('orders')
            ->join('user', 'orders.order_user_id', '=', 'user.user_id')
            ->select('orders.*', 'user.user_fullname', 'user.user_username')
            ->where('order_id', $id)
            ->first();
        
        if (!$order) {
            return redirect('/admin/danh-sach-don-hang')->with('error', 'Đơn hàng không tồn tại!');
        }
        
        $orderDetails = DB::table('order_details')
            ->where('detail_order_id', $id)
            ->get();
        
        return view('admin.order_detail', compact('order', 'orderDetails'));
    }
    
    public function updateOrderStatus(Request $request, $id)
    {
        DB::table('orders')
            ->where('order_id', $id)
            ->update([
                'order_status' => $request->status
            ]);
        
        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    
    public function deleteOrder($id)
    {
        // Xóa chi tiết đơn hàng trước
        DB::table('order_details')->where('detail_order_id', $id)->delete();
        
        // Xóa đơn hàng
        DB::table('orders')->where('order_id', $id)->delete();
        
        return redirect('/admin/danh-sach-don-hang')->with('success', 'Xóa đơn hàng thành công!');
    }

    // Trang profile admin
    public function profile()
    {
        if (!session()->has('user')) {
            return redirect('/admin/dang-nhap');
        }
        
        $currentUser = session()->get('user')[0];
        $user = DB::table('user')->where('user_id', $currentUser['user_id'])->first();
        
        // Thống kê
        $totalProducts = DB::table('product')->count();
        $totalOrders = DB::table('orders')->count();
        $totalUsers = DB::table('user')->where('user_role', 0)->count();
        $totalRevenue = DB::table('orders')
            ->where('order_status', '!=', 'cancelled')
            ->sum('order_total');
        
        return view('admin.profile', compact(
            'user',
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalRevenue'
        ));
    }

    // Cập nhật profile admin
    public function updateProfile(Request $request)
    {
        if (!session()->has('user')) {
            return redirect('/admin/dang-nhap');
        }
        
        $currentUser = session()->get('user')[0];
        
        DB::table('user')
            ->where('user_id', $currentUser['user_id'])
            ->update([
                'user_fullname' => $request->fullname,
                'user_address' => $request->address
            ]);
        
        // Cập nhật session
        session(['user' => [
            [
                'user_id' => $currentUser['user_id'],
                'username' => $currentUser['username'],
                'role' => $currentUser['role'],
                'fullname' => $request->fullname
            ]
        ]]);
        
        return redirect('/admin/profile')->with('success', 'Cập nhật thông tin thành công!');
    }

    // Đổi mật khẩu admin
    public function changePassword(Request $request)
    {
        if (!session()->has('user')) {
            return redirect('/admin/dang-nhap');
        }
        
        $currentUser = session()->get('user')[0];
        $user = DB::table('user')->where('user_id', $currentUser['user_id'])->first();
        
        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, $user->user_password)) {
            return redirect()->back()->with('error', 'Mật khẩu cũ không đúng!');
        }
        
        // Kiểm tra mật khẩu mới
        if ($request->new_password != $request->confirm_password) {
            return redirect()->back()->with('error', 'Mật khẩu xác nhận không khớp!');
        }
        
        if (strlen($request->new_password) < 6) {
            return redirect()->back()->with('error', 'Mật khẩu mới phải có ít nhất 6 ký tự!');
        }
        
        // Cập nhật mật khẩu
        DB::table('user')
            ->where('user_id', $currentUser['user_id'])
            ->update([
                'user_password' => Hash::make($request->new_password)
            ]);
        
        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }
}