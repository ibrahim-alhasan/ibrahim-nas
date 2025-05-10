<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متجر العطور والساعات الفاخرة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #e74c3c;
        }
        
        .navbar {
            background: var(--primary-color) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
            background-size: cover;
            background-position: center;
            padding: 150px 0;
            margin-bottom: 3rem;
            color: white;
        }
        
        .card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .product-card {
            border-radius: 15px;
            overflow: hidden;
        }
        
        .product-card img {
            transition: transform 0.3s ease;
        }
        
        .product-card:hover img {
            transform: scale(1.05);
        }

        .alert.fade-out {
            opacity: 0;
        }

        /* Enhanced navbar styles */
        .navbar-collapse {
            transition: all 0.3s ease;
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        .navbar-toggler-icon {
            width: 1.5em;
            height: 1.5em;
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: var(--primary-color);
                padding: 1rem;
                border-radius: 0.5rem;
                margin-top: 0.5rem;
            }

            .nav-item {
                padding: 0.5rem 0;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-clock me-2"></i>
                <i class="fas fa-spray-can me-2"></i>
                متجر العطور والساعات
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li style="margin:10px" class="nav-item">
                        <a class="nav-link" href="index.php">الرئيسية</a>
                    </li>
                    <?php if (isLoggedIn()): ?>
                        <li style="margin:10px"  class="nav-item">
                            <a class="nav-link" href="products.php">إدارة المنتجات</a>
                        </li>
                        <?php if (isAdmin()): ?>
                            <li style="margin:10px" class="nav-item">
                                <a class="nav-link" href="users.php">إدارة المستخدمين</a>
                            </li>
                        <?php endif; ?>
                        <li style="margin:10px" class="nav-item">
                            <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                        </li>
                    <?php else: ?>
                        <li style="margin:10px" class="nav-item">
                            <a class="nav-link" href="login.php">تسجيل الدخول</a>
                        </li>
                        <li style="margin:10px" class="nav-item">
                            <a class="nav-link" href="register.php">إنشاء حساب</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-' . $_SESSION['message_type'] . ' alert-dismissible fade show" role="alert" id="systemAlert">' 
                    ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $_SESSION['message'] 
                    . '<button type="button" class="btn-close" onclick="dismissAlert()" aria-label="Close"></button></div>';
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
        ?>
    </div>

    <script>
        function dismissAlert() {
            const alert = document.getElementById('systemAlert');
            if (alert) {
                alert.classList.add('fade-out');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }

        // Auto-dismiss after 5 seconds
        const alert = document.getElementById('systemAlert');
        if (alert) {
            setTimeout(dismissAlert, 5000);
        }

        // Initialize Bootstrap components
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>