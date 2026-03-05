@include('frontend/template/header_frontend')

<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        border-radius: 10px;
        margin-bottom: 50px;
    }
    
    .product-card {
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    
    .product-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }
    
    .product-price {
        color: #e74c3c;
        font-size: 22px;
        font-weight: bold;
    }
    
    .btn-add-cart {
        background: #f39c12;
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 5px;
        transition: background 0.3s;
    }
    
    .btn-add-cart:hover {
        background: #e67e22;
        color: white;
    }
    
    .category-badge {
        background: #3498db;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
        margin-bottom: 10px;
    }
</style>

<!-- Hero Section -->
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Bộ Sưu Tập Đồng Hồ Cao Cấp</h1>
        <p class="lead mb-4">Khám phá những mẫu đồng hồ sang trọng và đẳng cấp</p>
        <a href="/san-pham" class="btn btn-light btn-lg"><i class="fas fa-shopping-bag"></i> Xem Sản Phẩm</a>
    </div>
</div>

<!-- Features -->
<div class="row mb-5">
    <div class="col-md-3 text-center">
        <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
        <h5>Giao Hàng Nhanh</h5>
        <p>Miễn phí vận chuyển</p>
    </div>
    <div class="col-md-3 text-center">
        <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
        <h5>Bảo Hành Chính Hãng</h5>
        <p>Bảo hành 12 tháng</p>
    </div>
    <div class="col-md-3 text-center">
        <i class="fas fa-undo fa-3x text-warning mb-3"></i>
        <h5>Đổi Trả 7 Ngày</h5>
        <p>Hoàn tiền 100%</p>
    </div>
    <div class="col-md-3 text-center">
        <i class="fas fa-headset fa-3x text-info mb-3"></i>
        <h5>Hỗ Trợ 24/7</h5>
        <p>Tư vấn nhiệt tình</p>
    </div>
</div>

<!-- Products -->
<h2 class="text-center mb-4">Sản Phẩm Nổi Bật</h2>
<div class="row">
    @foreach ($products as $product)
    <div class="col-md-3">
        <div class="card product-card">
            <img src="{{ asset($product->product_img) }}" class="product-image" alt="{{ $product->product_name }}">
            <div class="card-body">
                <span class="category-badge">{{ $product->category_name }}</span>
                <h5 class="card-title">{{ $product->product_name }}</h5>
                <p class="product-price">{{ number_format($product->product_price, 0, ',', '.') }}₫</p>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="/chi-tiet-san-pham/{{ $product->product_id }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i> Chi tiết
                    </a>
                    <a href="/them-vao-gio-hang/{{ $product->product_id }}" class="btn btn-add-cart btn-sm">
                        <i class="fas fa-cart-plus"></i> Thêm
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if(count($products) > 0)
<div class="text-center mt-4 mb-5">
    <a href="/san-pham" class="btn btn-primary btn-lg">Xem Tất Cả Sản Phẩm <i class="fas fa-arrow-right"></i></a>
</div>
@endif

@include('frontend/template/footer_frontend')