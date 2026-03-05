@include('frontend/template/header_frontend')

<style>
    .filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
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
    }
</style>

<h2 class="mb-4"><i class="fas fa-shopping-bag"></i> Danh Sách Sản Phẩm</h2>

<!-- Filter Section -->
<div class="filter-section">
    <form action="/san-pham" method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Danh Mục</label>
            <select name="category" class="form-select">
                <option value="">Tất cả danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}" 
                        {{ request('category') == $category->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Sắp Xếp</label>
            <select name="sort" class="form-select">
                <option value="">Mặc định</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tìm Kiếm</label>
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm sản phẩm..." 
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Products Grid -->
<div class="row">
    @if(count($products) > 0)
        @foreach ($products as $product)
        <div class="col-md-3">
            <div class="card product-card">
                <img src="{{ asset($product->product_img) }}" class="product-image" alt="{{ $product->product_name }}">
                <div class="card-body">
                    <span class="category-badge">{{ $product->category_name }}</span>
                    <h5 class="card-title mt-2">{{ $product->product_name }}</h5>
                    <p class="product-price">{{ number_format($product->product_price, 0, ',', '.') }}₫</p>
                    <p class="text-muted" style="font-size: 14px; height: 40px; overflow: hidden;">
                        {{ Str::limit($product->product_description, 60) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="/chi-tiet-san-pham/{{ $product->product_id }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> Chi tiết
                        </a>
                        <a href="/them-vao-gio-hang/{{ $product->product_id }}" class="btn btn-add-cart btn-sm">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Không tìm thấy sản phẩm nào!
            </div>
        </div>
    @endif
</div>

@include('frontend/template/footer_frontend')