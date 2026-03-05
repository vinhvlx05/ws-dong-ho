@include('frontend/template/header_frontend')

<style>
    .register-container {
        max-width: 550px;
        margin: 50px auto;
    }
    
    .register-card {
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        border-radius: 15px;
        overflow: hidden;
    }
    
    .register-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        padding: 30px;
        text-align: center;
    }
    
    .register-body {
        padding: 40px;
    }
    
    .btn-register {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
    }
    
    .btn-register:hover {
        background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);
    }
</style>

<div class="register-container">
    <div class="card register-card">
        <div class="register-header">
            <i class="fas fa-user-plus fa-3x mb-3"></i>
            <h3>Đăng Ký Tài Khoản</h3>
            <p class="mb-0">Tạo tài khoản mới để mua sắm</p>
        </div>
        <div class="register-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <form action="/xu-ly-dang-ky" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user"></i> Tài khoản</label>
                    <input type="text" class="form-control" name="username" placeholder="Nhập tài khoản" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock"></i> Mật khẩu</label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock"></i> Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-id-card"></i> Họ và tên</label>
                    <input type="text" class="form-control" name="fullname" placeholder="Nhập họ và tên" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                    <input type="text" class="form-control" name="address" placeholder="Nhập địa chỉ" required>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">
                        Tôi đồng ý với các điều khoản và điều kiện
                    </label>
                </div>
                
                <button type="submit" class="btn btn-success btn-register w-100">
                    <i class="fas fa-user-plus"></i> Đăng Ký
                </button>
            </form>
            
            <hr class="my-4">
            
            <div class="text-center">
                <p class="mb-0">Đã có tài khoản? 
                    <a href="/dang-nhap" class="text-decoration-none fw-bold">Đăng nhập ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>

@include('frontend/template/footer_frontend')