@include('frontend/template/header_frontend')

<style>
    .checkout-section {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .order-summary {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        position: sticky;
        top: 100px;
    }
    
    .product-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #dee2e6;
    }
</style>

<h2 class="mb-4"><i class="fas fa-credit-card"></i> Thanh Toán</h2>

<form action="/xu-ly-thanh-toan" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-7">
            <div class="checkout-section">
                <h4 class="mb-4"><i class="fas fa-user"></i> Thông Tin Giao Hàng</h4>
                
                <div class="mb-3">
                    <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="fullname" value="{{ $customer['fullname'] }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="phone" placeholder="Nhập số điện thoại" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="address" rows="3" required>{{ $customer['address'] }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ghi chú đơn hàng</label>
                    <textarea class="form-control" name="note" rows="3" placeholder="Ghi chú về đơn hàng (tùy chọn)"></textarea>
                </div>
            </div>
            
            <div class="checkout-section">
                <h4 class="mb-4"><i class="fas fa-credit-card"></i> Phương Thức Thanh Toán</h4>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                    <label class="form-check-label" for="cod">
                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                        <p class="text-muted mb-0 small">Thanh toán bằng tiền mặt khi nhận hàng</p>
                    </label>
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank">
                    <label class="form-check-label" for="bank">
                        <strong>Chuyển khoản ngân hàng</strong>
                        <p class="text-muted mb-0 small">Chuyển khoản qua tài khoản ngân hàng</p>
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo">
                    <label class="form-check-label" for="momo">
                        <strong>Ví MoMo</strong>
                        <p class="text-muted mb-0 small">Thanh toán qua ví điện tử MoMo</p>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="order-summary">
                <h4 class="mb-4"><i class="fas fa-file-invoice"></i> Đơn Hàng</h4>
                
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <div class="product-item">
                        <div>
                            <strong>{{ $item['name'] }}</strong>
                            <br>
                            <small class="text-muted">{{ number_format($item['price'], 0, ',', '.') }}₫ x {{ $item['quantity'] }}</small>
                        </div>
                        <div class="text-end">
                            <strong>{{ number_format($subtotal, 0, ',', '.') }}₫</strong>
                        </div>
                    </div>
                @endforeach
                
                <div class="product-item">
                    <span>Tạm tính:</span>
                    <strong>{{ number_format($total, 0, ',', '.') }}₫</strong>
                </div>
                
                <div class="product-item">
                    <span>Phí vận chuyển:</span>
                    <strong class="text-success">Miễn phí</strong>
                </div>
                
                <div class="product-item border-0 pt-3">
                    <h5>Tổng cộng:</h5>
                    <h5 class="text-danger">{{ number_format($total, 0, ',', '.') }}₫</h5>
                </div>
                
                <button type="submit" class="btn btn-danger w-100 mt-4" style="padding: 15px; font-size: 18px;">
                    <i class="fas fa-check-circle"></i> Đặt Hàng
                </button>
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="fas fa-lock"></i> Thông tin của bạn được bảo mật
                    </small>
                </div>
            </div>
        </div>
    </div>
</form>

@include('frontend/template/footer_frontend')