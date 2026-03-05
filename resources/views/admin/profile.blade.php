@include('admin/template/header')

<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .profile-header-content {
        display: flex;
        align-items: center;
        gap: 30px;
    }
    
    .admin-avatar {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        font-weight: 700;
        color: #667eea;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    
    .profile-info h2 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .profile-role {
        display: inline-block;
        padding: 6px 15px;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-size: 14px;
        margin-top: 10px;
    }
    
    .profile-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    
    .profile-card h4 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f3f5;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .profile-card h4 i {
        color: #667eea;
    }
    
    .info-row {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #f1f3f5;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        width: 200px;
        color: #7f8c8d;
        font-weight: 500;
    }
    
    .info-value {
        flex: 1;
        color: #2c3e50;
        font-weight: 600;
    }
    
    .activity-item {
        display: flex;
        gap: 15px;
        padding: 15px;
        border-bottom: 1px solid #f1f3f5;
        transition: background 0.3s;
    }
    
    .activity-item:hover {
        background: #f8f9fa;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .activity-time {
        font-size: 13px;
        color: #7f8c8d;
    }
</style>

<!-- Profile Header -->
<div class="profile-header">
    <div class="profile-header-content">
        <div class="admin-avatar">
            {{ strtoupper(substr($user->user_username, 0, 1)) }}
        </div>
        <div class="profile-info">
            <h2>{{ $user->user_fullname }}</h2>
            <p class="mb-0">{{ $user->user_username }}</p>
            <span class="profile-role">
                <i class="fas fa-shield-alt"></i> Quản Trị Viên
            </span>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Thông tin cá nhân -->
    <div class="col-md-8">
        <div class="profile-card">
            <h4><i class="fas fa-user-circle"></i> Thông Tin Cá Nhân</h4>
            
            <form action="/admin/cap-nhat-profile" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Tài khoản</label>
                    <input type="text" class="form-control" value="{{ $user->user_username }}" readonly style="background: #e9ecef;">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="fullname" class="form-control" value="{{ $user->user_fullname }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control" rows="3" required>{{ $user->user_address }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập Nhật Thông Tin
                </button>
            </form>
        </div>
        
        <!-- Đổi mật khẩu -->
        <div class="profile-card">
            <h4><i class="fas fa-key"></i> Đổi Mật Khẩu</h4>
            
            <form action="/admin/doi-mat-khau-admin" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" name="old_password" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-lock"></i> Đổi Mật Khẩu
                </button>
            </form>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Thông tin tài khoản -->
        <div class="profile-card">
            <h4><i class="fas fa-info-circle"></i> Thông Tin Tài Khoản</h4>
            
            <div class="info-row">
                <div class="info-label">User ID:</div>
                <div class="info-value">#{{ $user->user_id }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Vai trò:</div>
                <div class="info-value">
                    <span class="badge bg-danger">Administrator</span>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Trạng thái:</div>
                <div class="info-value">
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle"></i> Hoạt động
                    </span>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Ngày tham gia:</div>
                <div class="info-value">{{ date('d/m/Y') }}</div>
            </div>
        </div>
        
        <!-- Hoạt động gần đây -->
        <div class="profile-card">
            <h4><i class="fas fa-history"></i> Hoạt Động Gần Đây</h4>
            
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Đăng nhập hệ thống</div>
                    <div class="activity-time">{{ date('d/m/Y H:i') }}</div>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Cập nhật sản phẩm</div>
                    <div class="activity-time">{{ date('d/m/Y', strtotime('-1 day')) }}</div>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-box"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Xử lý đơn hàng</div>
                    <div class="activity-time">{{ date('d/m/Y', strtotime('-2 days')) }}</div>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Thêm người dùng mới</div>
                    <div class="activity-time">{{ date('d/m/Y', strtotime('-3 days')) }}</div>
                </div>
            </div>
        </div>
        
        <!-- Thống kê nhanh -->
        <div class="profile-card">
            <h4><i class="fas fa-chart-bar"></i> Thống Kê Nhanh</h4>
            
            <div class="info-row">
                <div class="info-label">Sản phẩm:</div>
                <div class="info-value">{{ $totalProducts }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Đơn hàng:</div>
                <div class="info-value">{{ $totalOrders }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Người dùng:</div>
                <div class="info-value">{{ $totalUsers }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Doanh thu:</div>
                <div class="info-value text-success">{{ number_format($totalRevenue, 0, ',', '.') }}₫</div>
            </div>
        </div>
    </div>
</div>

@include('admin/template/footer')