<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Luxury Watch Management</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            padding: 0;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand {
            color: white;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-brand i {
            font-size: 32px;
            color: #ffd700;
        }
        
        .sidebar-brand span {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .sidebar-brand small {
            font-size: 11px;
            font-weight: 400;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-section {
            margin-bottom: 30px;
        }
        
        .menu-section-title {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px;
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            gap: 12px;
        }
        
        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: #ffd700;
        }
        
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.15);
            color: white;
            border-left-color: #ffd700;
            font-weight: 500;
        }
        
        .sidebar-menu a i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }
        
        .sidebar-menu .badge {
            margin-left: auto;
            background: #ff4757;
            font-size: 10px;
            padding: 3px 8px;
        }
        
        /* Top Bar */
        .top-bar {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            height: 70px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 999;
        }
        
        .top-bar-left h4 {
            margin: 0;
            color: #2c3e50;
            font-size: 20px;
            font-weight: 600;
        }
        
        .top-bar-left p {
            margin: 0;
            color: #7f8c8d;
            font-size: 13px;
        }
        
        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .top-bar-icon {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f6fa;
            border-radius: 10px;
            color: #2c3e50;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .top-bar-icon:hover {
            background: #e8eaf0;
        }
        
        .top-bar-icon .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff4757;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px;
            background: #f5f6fa;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .user-menu:hover {
            background: #e8eaf0;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .user-info h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .user-info p {
            margin: 0;
            font-size: 12px;
            color: #7f8c8d;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 30px;
            flex: 1;
        }
        
        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .top-bar {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Custom Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="/admin" class="sidebar-brand">
                <i class="fas fa-clock"></i>
                <span>
                    LUXURY WATCH
                    <small>Admin Panel</small>
                </span>
            </a>
        </div>
        
        <div class="sidebar-menu">
            <!-- Dashboard Section -->
            <div class="menu-section">
                <div class="menu-section-title">Dashboard</div>
                <a href="/admin/dashboard" class="active">
                    <i class="fas fa-home"></i>
                    <span>Trang Chủ</span>
                </a>
                <a href="/admin/thong-ke">
                    <i class="fas fa-chart-line"></i>
                    <span>Thống Kê</span>
                </a>
            </div>
            
            <!-- Quản Lý Section -->
            <div class="menu-section">
                <div class="menu-section-title">Quản Lý</div>
                <a href="/admin/danh-sach-san-pham">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Sản Phẩm</span>
                </a>
                <a href="/admin/danh-sach-danh-muc">
                    <i class="fas fa-list"></i>
                    <span>Danh Mục</span>
                </a>
                <a href="/admin/danh-sach-don-hang">
                    <i class="fas fa-box"></i>
                    <span>Đơn Hàng</span>
                </a>
                <a href="/admin/danh-sach-nguoi-dung">
                    <i class="fas fa-users"></i>
                    <span>Người Dùng</span>
                </a>
            </div>
            
            <!-- Cài Đặt Section -->
            <div class="menu-section">
                <div class="menu-section-title">Hệ Thống</div>
                <a href="/admin/cai-dat">
                    <i class="fas fa-cog"></i>
                    <span>Cài Đặt</span>
                </a>
                <a href="/" target="_blank">
                    <i class="fas fa-eye"></i>
                    <span>Xem Website</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-left">
            <h4>Quản Trị Hệ Thống</h4>
            <p><?php echo date('l, d F Y'); ?></p>
        </div>
        
        <div class="top-bar-right">
            
            <!-- User Menu -->
            <div class="dropdown">
                <div class="user-menu" data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        <?php
                        if(session()->has('user')) {
                            $user = session()->get('user');
                            echo strtoupper(substr($user[0]['username'], 0, 1));
                        } else {
                            echo 'A';
                        }
                        ?>
                    </div>
                    <div class="user-info">
                        <h6>
                            <?php
                            if(session()->has('user')) {
                                $user = session()->get('user');
                                echo $user[0]['username'];
                            } else {
                                echo 'Admin';
                            }
                            ?>
                        </h6>
                        <p>Administrator</p>
                    </div>
                    <i class="fas fa-chevron-down" style="color: #7f8c8d; font-size: 12px;"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/admin/profile"><i class="fas fa-user me-2"></i> Hồ Sơ</a></li>
                    <li><a class="dropdown-item" href="/admin/cai-dat"><i class="fas fa-cog me-2"></i> Cài Đặt</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/admin/thoat"><i class="fas fa-sign-out-alt me-2"></i> Đăng Xuất</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">