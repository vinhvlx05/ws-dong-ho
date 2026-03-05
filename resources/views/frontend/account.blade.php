@include('frontend/template/header_frontend')

<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
        margin-bottom: 40px;
        border-radius: 15px;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 700;
        color: #667eea;
        margin: 0 auto 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    
    .profile-name {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .profile-username {
        opacity: 0.9;
        font-size: 18px;
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
    
    .info-group {
        margin-bottom: 20px;
    }
    
    .info-label {
        color: #7f8c8d;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }
    
    .info-value {
        color: #2c3e50;
        font-size: 16px;
        font-weight: 600;
        padding: 12px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        display: block;
    }
    
    .edit-button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .edit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-box {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        text-align: center;
        transition: transform 0.3s;
    }
    
    .stat-box:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 15px;
    }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #7f8c8d;
        font-size: 14px;
    }
    
    .tab-nav {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 2px solid #f1f3f5;
    }
    
    .tab-button {
        padding: 12px 25px;
        background: none;
        border: none;
        color: #7f8c8d;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
    }
    
    .tab-button:hover {
        color: #667eea;
    }
    
    .tab-button.active {
        color: #667eea;
        border-bottom-color: #667eea;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
</style>

<!-- Profile Header -->
<div class="profile-header">
    <div class="container text-center">
        <div class="profile-avatar">
            {{ strtoupper(substr($user->user_fullname, 0, 1)) }}
        </div>
        <h2 class="profile-name">{{ $user->user_fullname }}</h2>
        <p class="profile-username">{{ $user->user_username }}</p>
    </div>
</div>

<div class="container">
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-value">{{ $totalOrders }}</div>
            <div class="stat-label">Tổng đơn hàng</div>
        </div>
        
        <div class="stat-box">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $pendingOrders }}</div>
            <div class="stat-label">Đang xử lý</div>
        </div>
        
        <div class="stat-box">
            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $completedOrders }}</div>
            <div class="stat-label">Hoàn thành</div>
        </div>
        
        <div class="stat-box">
            <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-value">{{ number_format($totalSpent / 1000000, 1) }}M</div>
            <div class="stat-label">Tổng chi tiêu</div>
        </div>
    </div>
    
    <!-- Tabs -->
    <div class="tab-nav">
        <button class="tab-button active" onclick="switchTab('info')">
            <i class="fas fa-user"></i> Thông tin cá nhân
        </button>
        <button class="tab-button" onclick="switchTab('password')">
            <i class="fas fa-lock"></i> Đổi mật khẩu
        </button>
        <button class="tab-button" onclick="switchTab('orders')">
            <i class="fas fa-box"></i> Đơn hàng của tôi
        </button>
    </div>
    
    <!-- Tab Content: Thông tin cá nhân -->
    <div id="tab-info" class="tab-content active">
        <div class="row">
            <div class="col-md-8">
                <div class="profile-card">
                    <h4><i class="fas fa-user-circle"></i> Thông Tin Cá Nhân</h4>
                    
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
                    
                    <form action="/cap-nhat-thong-tin" method="POST">
                        @csrf
                        
                        <div class="info-group">
                            <label class="info-label">Tài khoản</label>
                            <input type="text" class="form-control" value="{{ $user->user_username }}" readonly style="background: #e9ecef;">
                        </div>
                        
                        <div class="info-group">
                            <label class="info-label">Họ và tên</label>
                            <input type="text" name="fullname" class="form-control" value="{{ $user->user_fullname }}" required>
                        </div>
                        
                        <div class="info-group">
                            <label class="info-label">Địa chỉ</label>
                            <textarea name="address" class="form-control" rows="3" required>{{ $user->user_address }}</textarea>
                        </div>
                        
                        <button type="submit" class="edit-button">
                            <i class="fas fa-save"></i> Cập Nhật Thông Tin
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="profile-card">
                    <h4><i class="fas fa-info-circle"></i> Thông Tin Tài Khoản</h4>
                    
                    <div class="info-group">
                        <label class="info-label">Vai trò</label>
                        <span class="info-value">
                            @if($user->user_role == 0)
                                <i class="fas fa-user"></i> Khách hàng
                            @else
                                <i class="fas fa-user-shield"></i> Quản trị viên
                            @endif
                        </span>
                    </div>
                    
                    <div class="info-group">
                        <label class="info-label">Ngày tham gia</label>
                        <span class="info-value">
                            <i class="fas fa-calendar"></i> {{ date('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab Content: Đổi mật khẩu -->
    <div id="tab-password" class="tab-content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="profile-card">
                    <h4><i class="fas fa-key"></i> Đổi Mật Khẩu</h4>
                    
                    <form action="/doi-mat-khau" method="POST">
                        @csrf
                        
                        <div class="info-group">
                            <label class="info-label">Mật khẩu hiện tại</label>
                            <input type="password" name="old_password" class="form-control" required>
                        </div>
                        
                        <div class="info-group">
                            <label class="info-label">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        
                        <div class="info-group">
                            <label class="info-label">Xác nhận mật khẩu mới</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="edit-button">
                            <i class="fas fa-lock"></i> Đổi Mật Khẩu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab Content: Đơn hàng -->
    <div id="tab-orders" class="tab-content">
        <div class="profile-card">
            <h4><i class="fas fa-shopping-bag"></i> Lịch Sử Đơn Hàng</h4>
            
            @if(count($orders) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong>#{{ str_pad($order->order_id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>{{ date('d/m/Y', strtotime($order->order_created_at)) }}</td>
                            <td><strong>{{ number_format($order->order_total, 0, ',', '.') }}₫</strong></td>
                            <td>
                                @if($order->order_status == 'pending')
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                @elseif($order->order_status == 'processing')
                                    <span class="badge bg-info">Đang xử lý</span>
                                @elseif($order->order_status == 'shipping')
                                    <span class="badge bg-primary">Đang giao</span>
                                @elseif($order->order_status == 'completed')
                                    <span class="badge bg-success">Hoàn thành</span>
                                @else
                                    <span class="badge bg-danger">Đã hủy</span>
                                @endif
                            </td>
                            <td>
                                <a href="/chi-tiet-don-hang/{{ $order->order_id }}" class="btn btn-sm btn-outline-primary">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Bạn chưa có đơn hàng nào</h5>
                <a href="/san-pham" class="btn btn-primary mt-3">
                    <i class="fas fa-shopping-bag"></i> Mua Sắm Ngay
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById('tab-' + tabName).classList.add('active');
    
    // Add active to clicked button
    event.target.classList.add('active');
}
</script>

@include('frontend/template/footer_frontend')