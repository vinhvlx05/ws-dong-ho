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
    
    .btn-add-new {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-add-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .filter-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }
    
    .product-card-admin {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    
    .product-card-admin:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .product-image-wrapper {
        position: relative;
        height: 250px;
        overflow: hidden;
        background: #f8f9fa;
    }
    
    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .product-card-admin:hover .product-image-wrapper img {
        transform: scale(1.1);
    }
    
    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: white;
        color: #667eea;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .product-actions {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .product-card-admin:hover .product-actions {
        opacity: 1;
    }
    
    .product-action-btn {
        width: 35px;
        height: 35px;
        background: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .product-action-btn:hover {
        transform: scale(1.1);
    }
    
    .product-action-btn.edit {
        color: #3498db;
    }
    
    .product-action-btn.delete {
        color: #e74c3c;
    }
    
    .product-card-body {
        padding: 20px;
    }
    
    .product-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-price {
        font-size: 20px;
        font-weight: 700;
        color: #e74c3c;
        margin-bottom: 15px;
    }
    
    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #f1f3f5;
    }
    
    .product-category {
        background: #f8f9fa;
        color: #7f8c8d;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
    }
    
    .product-id {
        color: #95a5a6;
        font-size: 12px;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <h3>
        <i class="fas fa-shopping-bag"></i>
        Quản Lý Sản Phẩm
    </h3>
    <a href="them-san-pham" class="btn-add-new">
        <i class="fas fa-plus-circle"></i>
        Thêm Sản Phẩm Mới
    </a>
</div>

<!-- Filter Card -->
<div class="filter-card">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label"><i class="fas fa-search"></i> Tìm kiếm</label>
            <input type="text" name="search" class="form-control" placeholder="Tìm tên sản phẩm...">
        </div>
        <div class="col-md-3">
            <label class="form-label"><i class="fas fa-filter"></i> Danh mục</label>
            <select name="category" class="form-select">
                <option value="">Tất cả danh mục</option>
                <!-- Add categories here -->
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label"><i class="fas fa-sort"></i> Sắp xếp</label>
            <select name="sort" class="form-select">
                <option value="">Mặc định</option>
                <option value="price_asc">Giá tăng dần</option>
                <option value="price_desc">Giá giảm dần</option>
                <option value="name">Tên A-Z</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search"></i> Lọc
            </button>
        </div>
    </form>
</div>

<!-- Products Grid -->
<div class="product-grid">
    @foreach ($products as $product)
    <div class="product-card-admin">
        <div class="product-image-wrapper">
            <img src="{{ asset($product->product_img) }}" alt="{{ $product->product_name }}">
            <span class="product-badge">{{ $product->category_name }}</span>
            <div class="product-actions">
                <a href="thong-tin-san-pham/{{ $product->product_id }}" class="product-action-btn edit">
                    <i class="fas fa-edit"></i>
                </a>
                <button onclick="deleteProduct({{ $product->product_id }})" class="product-action-btn delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="product-card-body">
            <h5 class="product-title">{{ $product->product_name }}</h5>
            <div class="product-price">{{ number_format($product->product_price, 0, ',', '.') }}₫</div>
            <div class="product-meta">
                <span class="product-category">{{ $product->category_name }}</span>
                <span class="product-id">ID: {{ $product->product_id }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if(count($products) == 0)
<div class="text-center py-5">
    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
    <h5 class="text-muted">Chưa có sản phẩm nào</h5>
    <p class="text-muted">Nhấn nút "Thêm Sản Phẩm Mới" để bắt đầu</p>
</div>
@endif

<script>
function deleteProduct(id) {
    if(confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        window.location.href = 'xoa-san-pham/' + id;
    }
}
</script>

@include('admin/template/footer')