@include('admin/template/header')

<style>
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .welcome-card h2 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .welcome-card p {
        font-size: 16px;
        opacity: 0.9;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--color);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
        background: var(--color);
        color: white;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #7f8c8d;
        font-size: 14px;
        font-weight: 500;
    }
    
    .recent-table {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .recent-table h5 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    .table-custom {
        margin: 0;
    }
    
    .table-custom thead {
        background: #f8f9fa;
    }
    
    .table-custom th {
        border: none;
        color: #7f8c8d;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 15px;
    }
    
    .table-custom td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }
    
    .status-badge {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-completed {
        background: #d4edda;
        color: #155724;
    }
    
    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }
</style>

<!-- Welcome Card -->
<div class="welcome-card">
    <h2>
        <i class="fas fa-hand-wave"></i> 
        Xin chào, 
        <?php
        if(session()->has('user')) {
            $user = session()->get('user');
            echo $user[0]['username'];
        } else {
            echo 'Admin';
        }
        ?>!
    </h2>
    <p>Chào mừng bạn quay trở lại hệ thống quản trị Luxury Watch</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card" style="--color: #667eea;">
        <div class="stat-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="stat-value">{{ $totalProducts }}</div>
        <div class="stat-label">Tổng Sản Phẩm</div>
    </div>
    
    <div class="stat-card" style="--color: #f093fb;">
        <div class="stat-icon">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-label">Đơn Hàng</div>
    </div>
    
    <div class="stat-card" style="--color: #4facfe;">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-label">Khách Hàng</div>
    </div>
    
    <div class="stat-card" style="--color: #43e97b;">
        <div class="stat-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-value">{{ number_format($totalRevenue / 1000000, 1) }}M</div>
        <div class="stat-label">Doanh Thu</div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="recent-table">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fas fa-clock me-2"></i>Đơn Hàng Gần Đây</h5>
        <a href="/admin/danh-sach-don-hang" class="btn btn-sm btn-primary">
            Xem Tất Cả <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    
    @if(count($recentOrders) > 0)
    <table class="table table-custom">
        <thead>
            <tr>
                <th>Mã Đơn</th>
                <th>Khách Hàng</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Thời Gian</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td><strong>#{{ str_pad($order->order_id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                <td>{{ $order->user_fullname }}</td>
                <td><strong>{{ number_format($order->order_total, 0, ',', '.') }}₫</strong></td>
                <td>
                    @if($order->order_status == 'pending')
                        <span class="status-badge status-pending">Chờ xử lý</span>
                    @elseif($order->order_status == 'completed')
                        <span class="status-badge status-completed">Hoàn thành</span>
                    @else
                        <span class="status-badge status-cancelled">Đã hủy</span>
                    @endif
                </td>
                <td>{{ date('d/m/Y H:i', strtotime($order->order_created_at)) }}</td>
                <td>
                    <a href="/admin/chi-tiet-don-hang/{{ $order->order_id }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
        <h5 class="text-muted">Chưa có đơn hàng nào</h5>
    </div>
    @endif
</div>

@include('admin/template/footer')