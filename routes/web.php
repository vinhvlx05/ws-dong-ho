<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/thong-ke', [AdminController::class, 'statistics']);
    
    // Đăng nhập Admin
    Route::get('/dang-nhap', [AdminController::class, 'login']);
    Route::post('/xu-ly-dang-nhap', [AdminController::class, 'processLogin']);
    Route::get('/thoat', [AdminController::class, 'logout']);

    // ==================== SẢN PHẨM ====================
    Route::get('/danh-sach-san-pham', [AdminController::class, 'productList']);
    Route::get('/them-san-pham', [AdminController::class, 'productInsertForm']);
    Route::post('/xu-ly-them-san-pham', [AdminController::class, 'storeProduct']);
    Route::get('/thong-tin-san-pham/{id}', [AdminController::class, 'productInfoForm']);
    Route::post('/xu-ly-cap-nhat-san-pham', [AdminController::class, 'updateProduct']);
    Route::get('/xoa-san-pham/{id}', [AdminController::class, 'deleteProduct']);
    
    // ==================== DANH MỤC ====================
    Route::get('/danh-sach-danh-muc', [AdminController::class, 'categoryList']);
    Route::get('/them-danh-muc', [AdminController::class, 'categoryInsertForm']);
    Route::post('/xu-ly-them-danh-muc', [AdminController::class, 'storeCategory']);
    Route::get('/thong-tin-danh-muc/{id}', [AdminController::class, 'categoryInfoForm']);
    Route::post('/xu-ly-cap-nhat-danh-muc', [AdminController::class, 'updateCategory']);
    Route::get('/xoa-danh-muc/{id}', [AdminController::class, 'deleteCategory']);

    // ==================== NGƯỜI DÙNG ====================
    Route::get('/danh-sach-nguoi-dung', [AdminController::class, 'userList']);
    Route::get('/them-nguoi-dung', [AdminController::class, 'userInsertForm']);
    Route::post('/xu-ly-them-nguoi-dung', [AdminController::class, 'storeUser']);
    Route::get('/thong-tin-nguoi-dung/{id}', [AdminController::class, 'userInfoForm']);
    Route::post('/xu-ly-cap-nhat-nguoi-dung', [AdminController::class, 'updateUser']);
    Route::get('/xoa-nguoi-dung/{id}', [AdminController::class, 'deleteUser']);

    // ==================== ĐƠN HÀNG ====================
    Route::get('/danh-sach-don-hang', [AdminController::class, 'orderList']);
    Route::get('/chi-tiet-don-hang/{id}', [AdminController::class, 'orderDetail']);
    Route::post('/cap-nhat-trang-thai-don-hang/{id}', [AdminController::class, 'updateOrderStatus']);
    Route::get('/xoa-don-hang/{id}', [AdminController::class, 'deleteOrder']);
    
    // ==================== CÀI ĐẶT & PROFILE ====================
    Route::get('/cai-dat', [AdminController::class, 'settings']);
    Route::get('/profile', [AdminController::class, 'profile']);
    Route::post('/cap-nhat-profile', [AdminController::class, 'updateProfile']);
    Route::post('/doi-mat-khau-admin', [AdminController::class, 'changePassword']);
    
    
});

// ======================= FRONTEND ROUTES =======================

//trang chu
Route::get('/', [FrontendController::class, 'home']);

//sanpham
Route::get('/san-pham', [FrontendController::class, 'productList']);
Route::get('/chi-tiet-san-pham/{id}', [FrontendController::class, 'productDetail']);

// Đăng nhập/Đăng ký
Route::get('/dang-nhap', [FrontendController::class, 'login']);
Route::post('/xu-ly-dang-nhap', [FrontendController::class, 'processLogin']);
Route::get('/dang-ky', [FrontendController::class, 'register']);
Route::post('/xu-ly-dang-ky', [FrontendController::class, 'processRegister']);
Route::get('/dang-xuat', [FrontendController::class, 'logout']);

// Giỏ hàng
Route::get('/them-vao-gio-hang/{id}', [FrontendController::class, 'addToCart']);
Route::get('/gio-hang', [FrontendController::class, 'cart']);
Route::post('/cap-nhat-gio-hang/{id}', [FrontendController::class, 'updateCart']);
Route::get('/xoa-khoi-gio-hang/{id}', [FrontendController::class, 'removeFromCart']);
Route::get('/xoa-gio-hang', [FrontendController::class, 'clearCart']);

// Thanh toán
Route::get('/thanh-toan', [FrontendController::class, 'checkout']);
Route::post('/xu-ly-thanh-toan', [FrontendController::class, 'processCheckout']);
Route::get('/don-hang-thanh-cong/{id}', [FrontendController::class, 'orderSuccess']);

// Liên hệ
Route::get('/lien-he', [FrontendController::class, 'contact']);

// Tài khoản & Profile
Route::get('/tai-khoan', [FrontendController::class, 'account']);
Route::post('/cap-nhat-thong-tin', [FrontendController::class, 'updateProfile']);
Route::get('/don-hang', [FrontendController::class, 'orders']);
Route::post('/doi-mat-khau', [FrontendController::class, 'changePassword']);

Route::get('home', function () {
    return view('home',['title' => 'HCE', 'body' => 'Body']);
});

Route::prefix('greeting')->group(function () {

	// work for: /greeting/vn
    Route::get('vn', function () {
        return "Xin chào!";
    });

    // work for: /greeting/en
    Route::get('en', function () {
        return "Hello!";
    });

    // work for: /greeting/cn
    Route::get('cn', function () {
        return "你好!";
    });
});
Route::get('user/{id}/comment/{commentId}', function ($id, $commentId) {
    return "User id: $id and comment id: $commentId";
});
Route::get('laydulieu', function () {
    $data = DB::table('user')->get();
    print_r($data);
});


