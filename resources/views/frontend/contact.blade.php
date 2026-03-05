@include('frontend/template/header_frontend')

<style>
    .contact-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 10px;
        height: 100%;
    }
    
    .contact-item {
        margin-bottom: 30px;
    }
    
    .contact-item i {
        font-size: 30px;
        margin-bottom: 15px;
    }
    
    .contact-form {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .map-container {
        height: 400px;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 50px;
    }
</style>

<h2 class="mb-4"><i class="fas fa-envelope"></i> Liên Hệ Với Chúng Tôi</h2>

<div class="row">
    <div class="col-md-4">
        <div class="contact-info">
            <h3 class="mb-4">Thông Tin Liên Hệ</h3>
            
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <h5>Địa Chỉ</h5>
                <p>123 Nguyễn Tiểu La, Phường Vườn Hồng,<br>TP. Hồ Chí Minh</p>
            </div>
            
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <h5>Điện Thoại</h5>
                <p>Hotline: 1900-xxxx<br>Di động: 0901-xxx-xxx</p>
            </div>
            
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <h5>Email</h5>
                <p>info@shopwatch.vn<br>support@shopwatch.vn</p>
            </div>
            
            <div class="contact-item">
                <i class="fas fa-clock"></i>
                <h5>Giờ Làm Việc</h5>
                <p>Thứ 2 - Thứ 7: 8:00 - 20:00<br>Chủ Nhật: 9:00 - 18:00</p>
            </div>
            
            <div class="social-links mt-4">
                <h5>Theo Dõi Chúng Tôi</h5>
                <a href="#" class="text-white me-3" style="font-size: 24px;"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white me-3" style="font-size: 24px;"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white me-3" style="font-size: 24px;"><i class="fab fa-youtube"></i></a>
                <a href="#" class="text-white" style="font-size: 24px;"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="contact-form">
            <h3 class="mb-4">Gửi Tin Nhắn Cho Chúng Tôi</h3>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <form action="/xu-ly-lien-he" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="phone" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="subject" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="message" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-paper-plane"></i> Gửi Tin Nhắn
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Google Map -->
<div class="map-container">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.6305119670935!2d106.66525731533322!3d10.762622392329975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ed2392c44df%3A0xd2ecb62e0d050fe9!2sVinh%20Vien%2C%20Ward%202%2C%20District%2010%2C%20Ho%20Chi%20Minh%20City!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s" 
        width="100%" 
        height="100%" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy">
    </iframe>
</div>

@include('frontend/template/footer_frontend')