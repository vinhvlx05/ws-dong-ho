@include('frontend/template/header_frontend')

<style>
    .product-image-main {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .product-info {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .price-tag {
        font-size: 32px;
        color: #e74c3c;
        font-weight: bold;
    }
    
    .btn-add-to-cart {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        padding: 15px 40px;
        font-size: 18px;
        font-weight: bold;
    }
    
    .btn-add-to-cart:hover {
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
    }
    
    .product-features {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
    }
    
    .feature-item {
        padding: 10px 0;
        border-bottom: 1px solid #dee2e6;
    }
    
    .feature-item:last-child {
        border-bottom: none;
    }
    
    .related-product-card {
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .related-product-card:hover {
        transform: translateY(-5px);
    }
    
    .related-product-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="/san-pham">Sản phẩm</a></li>
        <li class="breadcrumb-item active">{{ $product->product_name }}</li>
    </ol>
</nav>

<div class="row mb-5">
    <div class="col-md-6 mb-4">
        <img src="{{ asset($product->product_img) }}" class="product-image-main" alt="{{ $product->product_name }}">
    </div>
    
    <div class="col-md-6">
        <div class="product-info">
            <span class="badge bg-primary mb-3">{{ $product->category_name }}</span>
            <h2 class="mb-3">{{ $product->product_name }}</h2>
            
            <div class="mb-3">
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <span class="ms-2 text-muted">(5.0)</span>
            </div>
            
            <div class="price-tag mb-4">
                {{ number_format($product->product_price, 0, ',', '.') }}₫
            </div>
            
            <div class="mb-4">
                <h5>Mô Tả Sản Phẩm:</h5>
                <p style="white-space: pre-line;">{{ $product->product_description }}</p>
            </div>
            
            <div class="product-features mb-4">
                <div class="feature-item">
                    <i class="fas fa-shield-alt text-success me-2"></i>
                    <strong>Bảo hành chính hãng 12 tháng</strong>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shipping-fast text-primary me-2"></i>
                    <strong>Miễn phí vận chuyển toàn quốc</strong>
                </div>
                <div class="feature-item">
                    <i class="fas fa-undo text-warning me-2"></i>
                    <strong>Đổi trả trong vòng 7 ngày</strong>
                </div>
                <div class="feature-item">
                    <i class="fas fa-certificate text-info me-2"></i>
                    <strong>100% sản phẩm chính hãng</strong>
                </div>
            </div>
            
            <div class="d-flex gap-3">
                <a href="/them-vao-gio-hang/{{ $product->product_id }}" class="btn btn-primary btn-add-to-cart flex-grow-1">
                    <i class="fas fa-cart-plus"></i> Thêm Vào Giỏ Hàng
                </a>
                <button class="btn btn-outline-danger btn-lg">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            
            <div class="mt-4 text-center">
                <small class="text-muted">
                    <i class="fas fa-phone"></i> Gọi ngay: 1900-xxxx để được tư vấn
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if(count($relatedProducts) > 0)
<div class="mt-5">
    <h3 class="mb-4"><i class="fas fa-box-open"></i> Sản Phẩm Liên Quan</h3>
    <div class="row">
        @foreach($relatedProducts as $relatedProduct)
        <div class="col-md-3 mb-4">
            <div class="card related-product-card">
                <img src="{{ asset($relatedProduct->product_img) }}" class="related-product-img" alt="{{ $relatedProduct->product_name }}">
                <div class="card-body">
                    <h6 class="card-title">{{ $relatedProduct->product_name }}</h6>
                    <p class="text-danger fw-bold">{{ number_format($relatedProduct->product_price, 0, ',', '.') }}₫</p>
                    <a href="/chi-tiet-san-pham/{{ $relatedProduct->product_id }}" class="btn btn-sm btn-outline-primary w-100">
                        Xem Chi Tiết
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@include('frontend/template/footer_frontend')