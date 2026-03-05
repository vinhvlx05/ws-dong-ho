<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Đồng Hồ - Luxury Watches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --gold-color: #f39c12;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .top-bar {
            background: var(--primary-color);
            color: white;
            padding: 8px 0;
            font-size: 14px;
        }
        
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-size: 28px;
            font-weight: bold;
            color: var(--primary-color) !important;
        }
        
        .navbar-brand i {
            color: var(--gold-color);
        }
        
        .nav-link {
            color: var(--primary-color) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--secondary-color) !important;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--secondary-color);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 11px;
        }
        
        .cart-icon-wrapper {
            position: relative;
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <i class="fas fa-phone"></i> Hotline: 1900-xxxx
                    <span class="ms-3"><i class="fas fa-envelope"></i> info@shopwatch.vn</span>
                </div>
                <div class="col-md-6 text-end">
                    <?php if(session()->has('customer')): ?>
                        <span>Xin chào, <?php echo session()->get('customer')[0]['fullname']; ?></span>
                    <?php else: ?>
                        <span>Chào mừng bạn đến với Shop Đồng Hồ</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-clock"></i> LUXURY WATCH
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home"></i> Trang Chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/san-pham"><i class="fas fa-shopping-bag"></i> Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/lien-he"><i class="fas fa-envelope"></i> Liên Hệ</a>
                    </li>
                    
                    <?php if(session()->has('customer')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> Tài Khoản
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/tai-khoan">Thông tin</a></li>
                                <li><a class="dropdown-item" href="/don-hang">Đơn hàng</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/dang-xuat">Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/dang-nhap"><i class="fas fa-sign-in-alt"></i> Đăng Nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/dang-ky"><i class="fas fa-user-plus"></i> Đăng Ký</a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/gio-hang">
                            <div class="cart-icon-wrapper">
                                <i class="fas fa-shopping-cart fa-lg"></i>
                                <?php 
                                $cartCount = 0;
                                if(session()->has('cart')) {
                                    $cartCount = count(session()->get('cart'));
                                }
                                if($cartCount > 0):
                                ?>
                                    <span class="cart-badge"><?php echo $cartCount; ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">