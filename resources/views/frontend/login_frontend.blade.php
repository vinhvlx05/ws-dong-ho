@include('frontend/template/header_frontend')

<style>
    .login-container {
        max-width: 450px;
        margin: 50px auto;
    }
    
    .login-card {
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        border-radius: 15px;
        overflow: hidden;
    }
    
    .login-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        text-align: center;
    }
    
    .login-body {
        padding: 40px;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
    }
    
    .btn-login:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
</style>

<div class="login-container">
    <div class="card login-card">
        <div class="login-header">
            <i class="fas fa-user-circle fa-3x mb-3"></i>
            <h3>Đăng Nhập</h3>
            <p class="mb-0">Chào mừng bạn quay trở lại!</p>
        </div>
        <div class="login-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <form action="/xu-ly-dang-nhap" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user"></i> Tài khoản</label>
                    <input type="text" class="form-control" name="username" placeholder="Nhập tài khoản" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock"></i> Mật khẩu</label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-login w-100">
                    <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                </button>
            </form>
            
            <hr class="my-4">
            
            <div class="text-center">
                <p class="mb-0">Chưa có tài khoản? 
                    <a href="/dang-ky" class="text-decoration-none fw-bold">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>

@include('frontend/template/footer_frontend')