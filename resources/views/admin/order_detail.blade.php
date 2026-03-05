@include('admin/template/header')

<style>
    .order-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
    }
    
    .order-header h3 {
        margin: 0 0 10px 0;
        font-weight: 700;
    }
    
    .info-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    
    .info-card h5 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .info-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #f1f3f5;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        width: 150px;
        color: #7f8c8d;
        font-weight: 500;
    }
    
    .info-value {
        flex: 1;
        color: #2c3e50;
        font-weight: 600;
    }
    
    .status-select {
        padding: 8px 15px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        font-weight: 500;
    }
</style>

<!-- Order Header -->
<div class="order-header">
    <h3>
        <i class="fas fa-file-invoice"></i>
        Đơn Hàng #{{ str_pad($order->order_id, 4, '0', STR_PAD_LEFT) }}
    </h3>
    <p class="mb-0">Ngày đặt: {{ date('d/m/Y H:i', strtotime($order->order_created_at)) }}</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Thông tin khách hàng -->
    <div class="col-md-4">
        <div class="info-card">
            <h5><i class="fas fa-user"></i> Thông Tin Khách Hàng</h5>
            <div class="info-row">
                <div class="info-label">Họ tên:</div>
                <div class="info-value">{{ $order->order_fullname }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Username:</div>
                <div class="info-value">{{ $order->user_username }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Số điện thoại:</div>
                <div class="info-value">{{ $order->order_phone }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Địa chỉ:</div>
                <div class="info-value">{{ $order->order_address }}</div>
            </div>
        </div>
        
        <!-- Cập nhật trạng thái -->
        <div class="info-card">
            <h5><i class="fas fa-sync"></i> Cập Nhật Trạng Thái</h5>
            <form action="/admin/cap-nhat-trang-thai-don-hang/{{ $order->order_id }}" method="POST">
                @csrf
                <select name="status" class="form-select status-select mb-3" required>
                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                        Chờ xử lý
                    </option>
                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>
                        Đang xử lý
                    </option>
                    <option value="shipping" {{ $order->order_status == 'shipping' ? 'selected' : '' }}>
                        Đang giao hàng
                    </option>
                    <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>
                        Hoàn thành
                    </option>
                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>
                        Đã hủy
                    </option>
                </select>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-check"></i> Cập Nhật
                </button>
            </form>
        </div>
    </div>
    
    <!-- Chi tiết đơn hàng -->
    <div class="col-md-8">
        <div class="info-card">
            <h5><i class="fas fa-shopping-cart"></i> Chi Tiết Sản Phẩm</h5>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderDetails as $detail)
                    <tr>
                        <td>
                            <strong>{{ $detail->detail_product_name }}</strong>
                        </td>
                        <td>{{ number_format($detail->detail_product_price, 0, ',', '.') }}₫</td>
                        <td>x{{ $detail->detail_quantity }}</td>
                        <td>
                            <strong>{{ number_format($detail->detail_product_price * $detail->detail_quantity, 0, ',', '.') }}₫</strong>
                        </td>
                    </tr>
                    @endforeach
                    
                    <tr>
                        <td colspan="3" class="text-end"><strong>Tạm tính:</strong></td>
                        <td><strong>{{ number_format($order->order_total, 0, ',', '.') }}₫</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                        <td><strong class="text-success">Miễn phí</strong></td>
                    </tr>
                    <tr class="table-primary">
                        <td colspan="3" class="text-end"><h5 class="mb-0">Tổng cộng:</h5></td>
                        <td><h5 class="mb-0 text-danger">{{ number_format($order->order_total, 0, ',', '.') }}₫</h5></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="text-center mt-4">
    <a href="/admin/danh-sach-don-hang" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
    <button onclick="window.print()" class="btn btn-outline-primary">
        <i class="fas fa-print"></i> In đơn hàng
    </button>
    <a href="/admin/xoa-don-hang/{{ $order->order_id }}" class="btn btn-outline-danger"
       onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
        <i class="fas fa-trash"></i> Xóa đơn hàng
    </a>
</div>

@include('admin/template/footer')