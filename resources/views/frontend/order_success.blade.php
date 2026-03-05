@include('frontend/template/header_frontend')

<style>
    .success-container {
        text-align: center;
        padding: 80px 20px;
    }
    
    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        animation: scaleIn 0.5s ease-in-out;
    }
    
    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }
    
    .success-icon i {
        font-size: 50px;
        color: white;
    }
    
    .order-info-card {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
    }
</style>

<div class="success-container">
    <div class="success-icon">
        <i class="fas fa-check"></i>
    </div>
    
    <h1 class="mb-3 text-success">Đặt Hàng Thành Công!</h1>
    <p class="lead text-muted mb-5">Cảm ơn bạn đã đặt hàng tại Luxury Watch</p>
    
    <div class="order-info-card">
        <h4 class="mb-4">Thông Tin Đơn Hàng</h4>
        
        <div class="row text-start mb-3">
            <div class="col-6">
                <strong>Mã đơn hàng:</strong>
            </div>
            <div class="col-6">
                #{{ $orderId }}
            </div>
        </div>
        
        <div class="row text-start mb-3">
            <div class="col-6">
                <strong>Trạng thái:</strong>
            </div>
            <div class="col-6">
                <span class="badge bg-warning">Chờ xử lý</span>
            </div>
        </div>
        
        <div class="row text-start mb-3">
            <div class="col-6">
                <strong>Tổng tiền:</strong>
            </div>
            <div class="col-6">
                <span class="text-danger fw-bold">{{ number_format($total, 0, ',', '.') }}₫</span>
            </div>
        </div>
        
        <hr class="my-4">
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            Chúng tôi đã gửi email xác nhận đơn hàng đến địa chỉ email của bạn.
            Đơn hàng sẽ được xử lý trong vòng 24h.
        </div>
        
        <div class="d-flex gap-3 mt-4">
            <a href="/" class="btn btn-outline-primary flex-grow-1">
                <i class="fas fa-home"></i> Về Trang Chủ
            </a>
            <a href="/don-hang" class="btn btn-primary flex-grow-1">
                <i class="fas fa-box"></i> Xem Đơn Hàng
            </a>
        </div>
    </div>
    
    <div class="mt-5">
        <p class="text-muted">
            <i class="fas fa-headset"></i> Cần hỗ trợ? Liên hệ: 
            <a href="tel:1900xxxx" class="text-decoration-none fw-bold">1900-xxxx</a>
        </p>
    </div>
</div>

@include('frontend/template/footer_frontend')