<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FrontendController extends Controller
{

    //cập nhật thông tin tài khoản
    public function updateProfile(Request $request)
    {
        if (!session()->has('customer')) {
            return redirect('/dang-nhap');
        }
        
        $customer = session()->get('customer')[0];
    
        DB::table('user')
            ->where('user_id', $customer['id'])
            ->update([
                'user_fullname' => $request->fullname,
                'user_address' => $request->address
            ]);
        
        // Cập nhật lại session
        session(['customer' => [
            [
                'id' => $customer['id'],
                'username' => $customer['username'],
                'fullname' => $request->fullname,
                'address' => $request->address
            ]
        ]]);
        
        return redirect('/tai-khoan')->with('success', 'Cập nhật thông tin thành công!');
    }

    // Trang chủ
    public function home()
    {
        $products = DB::table('product')
            ->join('category', 'product.product_category', '=', 'category.category_id')
            ->select('product.*', 'category.category_name')
            ->limit(8)
            ->get();
        
        return view('frontend.home', compact('products'));
    }
    
    // Danh sách sản phẩm
    public function productList(Request $request)
    {
        $query = DB::table('product')
            ->join('category', 'product.product_category', '=', 'category.category_id')
            ->select('product.*', 'category.category_name');
        
        if ($request->category) {
            $query->where('product.product_category', $request->category);
        }
        
        if ($request->search) {
            $query->where('product.product_name', 'like', '%' . $request->search . '%');
        }
        
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('product.product_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('product.product_price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('product.product_name', 'asc');
                break;
            default:
                $query->orderBy('product.product_id', 'desc');
        }
        
        $products = $query->get();
        $categories = DB::table('category')->get();
        
        return view('frontend.product_list_frontend', compact('products', 'categories'));
    }
    
    // Chi tiết sản phẩm
    public function productDetail($id)
    {
        $product = DB::table('product')
            ->join('category', 'product.product_category', '=', 'category.category_id')
            ->select('product.*', 'category.category_name')
            ->where('product.product_id', $id)
            ->first();
        
        if (!$product) {
            return redirect('/san-pham')->with('error', 'Sản phẩm không tồn tại!');
        }
        
        $relatedProducts = DB::table('product')
            ->join('category', 'product.product_category', '=', 'category.category_id')
            ->select('product.*', 'category.category_name')
            ->where('product.product_category', $product->product_category)
            ->where('product.product_id', '!=', $id)
            ->limit(4)
            ->get();
        
        return view('frontend.product_detail', compact('product', 'relatedProducts'));
    }
    
    // Trang đăng nhập
    public function login()
    {
        return view('frontend.login_frontend');
    }
    
    //  XỬ LÝ ĐĂNG NHẬP - ĐÃ CẬP NHẬT HASH
    public function processLogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        
        // Tìm user theo username
        $user = DB::table('user')
            ->where('user_username', $username)
            ->first();
        
        //  Kiểm tra user tồn tại VÀ mật khẩu đúng bằng Hash::check
        if ($user && Hash::check($password, $user->user_password)) {
            // Kiểm tra role
            if ($user->user_role == 1) {
                // Admin - chuyển đến backend
                session(['user' => [
                    ['username' => $user->user_username, 'role' => $user->user_role]
                ]]);
                return redirect('/admin/danh-sach-san-pham')->with('success', 'Đăng nhập thành công!');
            } else {
                // User - đăng nhập frontend
                session(['customer' => [
                    [
                        'id' => $user->user_id,
                        'username' => $user->user_username,
                        'fullname' => $user->user_fullname,
                        'address' => $user->user_address
                    ]
                ]]);
                return redirect('/')->with('success', 'Đăng nhập thành công!');
            }
        } else {
            return redirect('/dang-nhap')->with('error', 'Tài khoản hoặc mật khẩu không đúng!');
        }
    }
    
    // Trang đăng ký
    public function register()
    {
        return view('frontend.register_frontend');
    }
    
    //  XỬ LÝ ĐĂNG KÝ - ĐÃ CẬP NHẬT HASH
    public function processRegister(Request $request)
    {
        // Validation
        if ($request->password != $request->confirm_password) {
            return redirect('/dang-ky')->with('error', 'Mật khẩu xác nhận không khớp!');
        }
        
        // Kiểm tra độ dài mật khẩu
        if (strlen($request->password) < 6) {
            return redirect('/dang-ky')->with('error', 'Mật khẩu phải có ít nhất 6 ký tự!');
        }
        
        // Kiểm tra tài khoản đã tồn tại
        $existingUser = DB::table('user')
            ->where('user_username', $request->username)
            ->first();
        
        if ($existingUser) {
            return redirect('/dang-ky')->with('error', 'Tài khoản đã tồn tại!');
        }
        
        //  Tạo tài khoản mới với mật khẩu đã hash
        DB::table('user')->insert([
            'user_username' => $request->username,
            'user_password' => Hash::make($request->password), // ✅ HASH PASSWORD
            'user_fullname' => $request->fullname,
            'user_address' => $request->address,
            'user_role' => 0 // User thường
        ]);
        
        return redirect('/dang-nhap')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
    
    // Đăng xuất
    public function logout()
    {
        session()->forget('customer');
        session()->forget('user');
        return redirect('/')->with('success', 'Đăng xuất thành công!');
    }
    
    // Thêm vào giỏ hàng
    public function addToCart($id)
    {
        $product = DB::table('product')
            ->join('category', 'product.product_category', '=', 'category.category_id')
            ->select('product.*', 'category.category_name')
            ->where('product.product_id', $id)
            ->first();
        
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại!');
        }
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->product_id,
                "name" => $product->product_name,
                "price" => $product->product_price,
                "image" => $product->product_img,
                "category" => $product->category_name,
                "quantity" => 1
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }
    
    // Giỏ hàng
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart', compact('cart'));
    }
    
    // Cập nhật giỏ hàng
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            if ($request->quantity <= 0) {
                // Xóa sản phẩm nếu số lượng = 0
                unset($cart[$id]);
                session()->put('cart', $cart);
                return redirect('/gio-hang')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
            } else {
                $cart[$id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
                return redirect('/gio-hang')->with('success', 'Đã cập nhật số lượng!');
            }
        }
        
        return redirect('/gio-hang');
    }
    
    // Xóa khỏi giỏ hàng
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect('/gio-hang')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
    
    // Xóa toàn bộ giỏ hàng
    public function clearCart()
    {
        session()->forget('cart');
        return redirect('/gio-hang')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
    
    // Trang thanh toán
    public function checkout()
    {
        if (!session()->has('customer')) {
            return redirect('/dang-nhap')->with('error', 'Vui lòng đăng nhập để thanh toán!');
        }
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect('/gio-hang')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        
        $customer = session()->get('customer')[0];
        return view('frontend.checkout', compact('cart', 'customer'));
    }
    
    // Xử lý thanh toán
    public function processCheckout(Request $request)
    {
        if (!session()->has('customer')) {
            return redirect('/dang-nhap');
        }
        
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect('/gio-hang');
        }
        
        $customer = session()->get('customer')[0];
        
        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Tạo đơn hàng
        $orderId = DB::table('orders')->insertGetId([
            'order_user_id' => $customer['id'],
            'order_total' => $total,
            'order_status' => 'pending',
            'order_fullname' => $request->fullname,
            'order_address' => $request->address,
            'order_phone' => $request->phone,
            'order_created_at' => now()
        ]);
        
        // Thêm chi tiết đơn hàng
        foreach ($cart as $item) {
            DB::table('order_details')->insert([
                'detail_order_id' => $orderId,
                'detail_product_id' => $item['id'],
                'detail_product_name' => $item['name'],
                'detail_product_price' => $item['price'],
                'detail_quantity' => $item['quantity']
            ]);
        }
        
        // Xóa giỏ hàng
        session()->forget('cart');
        
        return redirect('/don-hang-thanh-cong/' . $orderId);
    }
    
    // Đơn hàng thành công
    public function orderSuccess($orderId)
    {
        if (!session()->has('customer')) {
            return redirect('/dang-nhap');
        }
        
        $order = DB::table('orders')->where('order_id', $orderId)->first();
        
        if (!$order) {
            return redirect('/');
        }
        
        return view('frontend.order_success', [
            'orderId' => $orderId,
            'total' => $order->order_total
        ]);
    }
    
    // Trang liên hệ
    public function contact()
    {
        return view('frontend.contact');
    }
    
    // Tài khoản người dùng
    public function account()
    {
        if (!session()->has('customer')) {
            return redirect('/dang-nhap')->with('error', 'Vui lòng đăng nhập!');
        }
        
        $customer = session()->get('customer')[0];
        $user = DB::table('user')->where('user_id', $customer['id'])->first();
        
        // Thống kê đơn hàng
        $totalOrders = DB::table('orders')
            ->where('order_user_id', $customer['id'])
            ->count();
        
        $pendingOrders = DB::table('orders')
            ->where('order_user_id', $customer['id'])
            ->where('order_status', 'pending')
            ->count();
        
        $completedOrders = DB::table('orders')
            ->where('order_user_id', $customer['id'])
            ->where('order_status', 'completed')
            ->count();
        
        $totalSpent = DB::table('orders')
            ->where('order_user_id', $customer['id'])
            ->where('order_status', '!=', 'cancelled')
            ->sum('order_total');
        
        // Danh sách đơn hàng
        $orders = DB::table('orders')
            ->where('order_user_id', $customer['id'])
            ->orderBy('order_id', 'desc')
            ->limit(10)
            ->get();
        
        return view('frontend.account', compact(
            'user',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalSpent',
            'orders'
        ));
    }
    
    // Danh sách đơn hàng
    public function orders()
    {   
        if (!session()->has('customer')) {
            return redirect('/dang-nhap');
        }
        
        $customer = session()->get('customer')[0];
        $orders = DB::table('orders')
            ->where('order_user_id', $customer['id'])
            ->orderBy('order_id', 'desc')
            ->get();
        
        return view('frontend.orders', compact('orders'));
    }
    
    //  THÊM CHỨC NĂNG ĐỔI MẬT KHẨU (BONUS)
    public function changePassword(Request $request)
    {
        if (!session()->has('customer')) {
            return redirect('/dang-nhap');
        }
        
        $customer = session()->get('customer')[0];
        $user = DB::table('user')->where('user_id', $customer['id'])->first();
        
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
        
        // Cập nhật mật khẩu mới
        DB::table('user')
            ->where('user_id', $customer['id'])
            ->update([
                'user_password' => Hash::make($request->new_password)
            ]);
        
        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }
}