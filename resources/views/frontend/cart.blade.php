@include('frontend/template/header_frontend')

<style>
    .cart-table {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .cart-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
    }
    
    .quantity-input {
        width: 80px;
        text-align: center;
    }
    
    .cart-summary {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .btn-checkout {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
    }
    
    .btn-checkout:hover {
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
    }
</style>

<h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Giỏ Hàng Của Bạn</h2>

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

@if(isset($cart) && count($cart) > 0)
<div class="row">
    <div class="col-md-8">
        <table class="table cart-table bg-white">
            <thead class="table-primary">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($item['image']) }}" class="cart-img me-3" alt="{{ $item['name'] }}">
                                <div>
                                    <h6 class="mb-0">{{ $item['name'] }}</h6>
                                    <small class="text-muted">{{ $item['category'] }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <strong>{{ number_format($item['price'], 0, ',', '.') }}₫</strong>
                        </td>
                        <td class="align-middle">
                            <form action="/cap-nhat-gio-hang/{{ $item['id'] }}" method="POST" class="d-inline">
                                @csrf
                                <div class="input-group input-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty(this)">-</button>
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" class="form-control quantity-input" onchange="this.form.submit()">
                                    <button type="button" class="btn btn-outline-secondary" onclick="increaseQty(this)">+</button>
                                </div>
                            </form>
                        </td>
                        <td class="align-middle">
                            <strong class="text-danger">{{ number_format($subtotal, 0, ',', '.') }}₫</strong>
                        </td>
                        <td class="align-middle">
                            <a href="/xoa-khoi-gio-hang/{{ $item['id'] }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-3">
            <a href="/san-pham" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Tiếp tục mua hàng
            </a>
            <a href="/xoa-gio-hang" class="btn btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                <i class="fas fa-trash"></i> Xóa giỏ hàng
            </a>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="cart-summary">
            <h4 class="mb-4">Tóm Tắt Đơn Hàng</h4>
            
            <div class="d-flex justify-content-between mb-2">
                <span>Tạm tính:</span>
                <strong>{{ number_format($total, 0, ',', '.') }}₫</strong>
            </div>
            
            <div class="d-flex justify-content-between mb-2">
                <span>Phí vận chuyển:</span>
                <strong class="text-success">Miễn phí</strong>
            </div>
            
            <hr>
            
            <div class="d-flex justify-content-between mb-4">
                <h5>Tổng cộng:</h5>
                <h5 class="text-danger">{{ number_format($total, 0, ',', '.') }}₫</h5>
            </div>
            
            @if(session()->has('customer'))
                <a href="/thanh-toan" class="btn btn-primary btn-checkout w-100">
                    <i class="fas fa-credit-card"></i> Tiến Hành Thanh Toán
                </a>
            @else
                <a href="/dang-nhap" class="btn btn-warning w-100 mb-2">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập để thanh toán
                </a>
                <small class="text-muted d-block text-center">
                    Bạn cần đăng nhập để tiếp tục thanh toán
                </small>
            @endif
            
            <div class="mt-4 text-center">
                <small class="text-muted">
                    <i class="fas fa-shield-alt"></i> Giao dịch an toàn và bảo mật
                </small>
            </div>
        </div>
    </div>
</div>
@else
<div class="text-center py-5">
    <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
    <h3>Giỏ hàng của bạn đang trống</h3>
    <p class="text-muted">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm!</p>
    <a href="/san-pham" class="btn btn-primary btn-lg mt-3">
        <i class="fas fa-shopping-bag"></i> Mua Sắm Ngay
    </a>
</div>
@endif

<script>
function decreaseQty(btn) {
    const input = btn.parentElement.querySelector('input');
    if(input.value > 0) {
        input.value = parseInt(input.value) - 1;
        input.form.submit();
    }
}

function increaseQty(btn) {
    const input = btn.parentElement.querySelector('input');
    input.value = parseInt(input.value) + 1;
    input.form.submit();
}
</script>

@include('frontend/template/footer_frontend')