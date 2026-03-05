@include('admin/template/header')

<style>
    .page-header {
        background: white;
        padding: 25px 30px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .page-header h3 {
        margin: 0;
        color: #2c3e50;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .page-header h3 i {
        color: #667eea;
    }
    
    .order-table-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
    
    .status-processing {
        background: #cfe2ff;
        color: #084298;
    }
    
    .status-shipping {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .status-completed {
        background: #d4edda;
        color: #155724;
    }
    
    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }
    
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .filter-tab {
        padding: 8px 20px;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        background: white;
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .filter-tab:hover {
        border-color: #667eea;
        color: #667eea;
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <h3>
        <i class="fas fa-box"></i>
        Quản Lý Đơn Hàng
    </h3>
    <div>
        <span class="badge bg-primary">Tổng: {{ count($orders) }} đơn</span>
    </div>
</div>

<!-- Order Table Card -->
<div class="order-table-card">
    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="/admin/danh-sach-don-hang" class="filter-tab active">
            <i class="fas fa-list"></i> Tất cả
        </a>
        <a href="?status=pending" class="filter-tab">
            <i class="fas fa-clock"></i> Chờ xử lý
        </a>
        <a href="?status=processing" class="filter-tab">
            <i class="fas fa-spinner"></i> Đang xử lý
        </a>
        <a href="?status=shipping" class="filter-tab">
            <i class="fas fa-shipping-fast"></i> Đang giao
        </a>
        <a href="?status=completed" class="filter-tab">
            <i class="fas fa-check-circle"></i> Hoàn thành
        </a>
        <a href="?status=cancelled" class="filter-tab">
            <i class="fas fa-times-circle"></i> Đã hủy
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(count($orders) > 0)
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>SĐT</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>#{{ str_pad($order->order_id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>
                        <div>
                            <strong>{{ $order->order_fullname }}</strong><br>
                            <small class="text-muted">{{ $order->user_username }}</small>
                        </div>
                    </td>
                    <td><strong>{{ number_format($order->order_total, 0, ',', '.') }}₫</strong></td>
                    <td>
                        @if($order->order_status == 'pending')
                            <span class="status-badge status-pending">Chờ xử lý</span>
                        @elseif($order->order_status == 'processing')
                            <span class="status-badge status-processing">Đang xử lý</span>
                        @elseif($order->order_status == 'shipping')
                            <span class="status-badge status-shipping">Đang giao</span>
                        @elseif($order->order_status == 'completed')
                            <span class="status-badge status-completed">Hoàn thành</span>
                        @else
                            <span class="status-badge status-cancelled">Đã hủy</span>
                        @endif
                    </td>
                    <td>{{ date('d/m/Y H:i', strtotime($order->order_created_at)) }}</td>
                    <td>{{ $order->order_phone }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/chi-tiet-don-hang/{{ $order->order_id }}" class="btn btn-sm btn-outline-primary" title="Chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/xoa-don-hang/{{ $order->order_id }}" class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
        <h5 class="text-muted">Chưa có đơn hàng nào</h5>
    </div>
    @endif
</div>

@include('admin/template/footer')