</div> <!-- Close main-content -->
    
    <!-- Footer -->
    <footer style="
        margin-left: 260px;
        background: white;
        padding: 20px 30px;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    ">
        <div style="color: #7f8c8d; font-size: 14px;">
            <i class="fas fa-copyright"></i> 2025 
            <strong style="color: #2c3e50;">Luxury Watch</strong> 
            - Quản Trị Hệ Thống
        </div>
        
        <div style="display: flex; gap: 20px; align-items: center;">
            <a href="/admin/help" style="
                color: #7f8c8d;
                text-decoration: none;
                font-size: 14px;
                transition: color 0.3s;
            " onmouseover="this.style.color='#2c3e50'" onmouseout="this.style.color='#7f8c8d'">
                <i class="fas fa-question-circle"></i> Trợ Giúp
            </a>
            
            <a href="/admin/privacy" style="
                color: #7f8c8d;
                text-decoration: none;
                font-size: 14px;
                transition: color 0.3s;
            " onmouseover="this.style.color='#2c3e50'" onmouseout="this.style.color='#7f8c8d'">
                <i class="fas fa-shield-alt"></i> Bảo Mật
            </a>
            
            <div style="
                padding: 8px 15px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 500;
            ">
                <i class="fas fa-code"></i> Version 1.0.0
            </div>
        </div>
    </footer>
    
    <!-- Mobile Menu Toggle -->
    <button id="mobile-menu-toggle" style="
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        cursor: pointer;
        z-index: 1001;
        font-size: 24px;
    ">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        
        // Show mobile toggle on small screens
        if (window.innerWidth <= 768) {
            mobileToggle.style.display = 'flex';
            mobileToggle.style.alignItems = 'center';
            mobileToggle.style.justifyContent = 'center';
        }
        
        // Toggle sidebar
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                    mobileToggle.querySelector('i').classList.remove('fa-times');
                    mobileToggle.querySelector('i').classList.add('fa-bars');
                }
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768) {
                mobileToggle.style.display = 'flex';
                mobileToggle.style.alignItems = 'center';
                mobileToggle.style.justifyContent = 'center';
            } else {
                mobileToggle.style.display = 'none';
                sidebar.classList.remove('active');
            }
        });
        
        // Active menu highlight
        const currentPath = window.location.pathname;
        const menuLinks = document.querySelectorAll('.sidebar-menu a');
        
        menuLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                menuLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            }
        });
        
        // Auto-hide notifications
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-success')) {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    }, 3000);
                }
            });
        }, 100);
        
        // Confirm delete actions
        document.querySelectorAll('a[href*="xoa"]').forEach(link => {
            if (!link.hasAttribute('onclick')) {
                link.addEventListener('click', function(e) {
                    if (!confirm('Bạn có chắc chắn muốn xóa?')) {
                        e.preventDefault();
                    }
                });
            }
        });
        
        // Loading animation for forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
                }
            });
        });
    </script>
</body>
</html>