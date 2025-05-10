<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

$stmt = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-3 mb-4">أرقى العطور والساعات الفاخرة</h1>
        <p class="lead mb-4">اكتشف تشكيلتنا المميزة من أفخم العطور والساعات العالمية</p>
        <a href="#pro" class="btn btn-outline-light btn-lg">تسوق الآن</a>
    </div>
</div>

<div class="container py-5" id="products">
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="category-card p-4 text-center bg-white shadow-sm rounded">
                <img src="https://images.pexels.com/photos/965989/pexels-photo-965989.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" 
                     alt="Perfumes" class="img-fluid rounded mb-3" style="height: 300px; object-fit: cover;">
                <h3>العطور الفاخرة</h3>
                <p class="text-muted">أجود أنواع العطور العالمية</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="category-card p-4 text-center bg-white shadow-sm rounded">
                <img src="https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" 
                     alt="Watches" class="img-fluid rounded mb-3" style="height: 300px; object-fit: cover;">
                <h3>الساعات الفاخرة</h3>
                <p class="text-muted">تشكيلة مميزة من أرقى الساعات</p>
            </div>
        </div>
    </div>

    <h2 id="pro" class="text-center mb-5">منتجاتنا المميزة</h2>
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="card product-card h-100">
                    <?php if (!empty($product['image'])): ?>
                        <div class="position-relative" style="height: 300px; overflow: hidden;">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                 class="card-img-top h-100 w-100" 
                                 style="object-fit: cover;"
                                 alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mb-3"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                        <p class="card-text text-muted mb-3"><?php echo mb_substr(htmlspecialchars($product['description']), 0, 100) . '...'; ?></p>
                        <p class="card-text h5 text-primary mb-4"><?php echo htmlspecialchars($product['price']); ?> دولار</p>
                        <a href="product.php?id=<?php echo $product['id']; ?>" 
                           class="btn btn-outline-primary w-100">عرض التفاصيل</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <i class="fas fa-shipping-fast fa-3x mb-3"></i>
                <h4>توصيل سريع</h4>
                <p>خدمة توصيل لجميع مناطق المملكة</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="fas fa-certificate fa-3x mb-3"></i>
                <h4>ضمان الجودة</h4>
                <p>جميع منتجاتنا أصلية ومضمونة</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="fas fa-headset fa-3x mb-3"></i>
                <h4>دعم متواصل</h4>
                <p>فريق خدمة العملاء متواجد على مدار الساعة</p>
            </div>
        </div>
    </div>
</div>

