<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirectTo('index.php');
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$_GET['id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    $_SESSION['message'] = "المنتج غير موجود";
    $_SESSION['message_type'] = "danger";
    redirectTo('index.php');
}

require_once 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg">
                <div class="row g-0">
    
                        <div class="col-md-6">
                            <div class="position-relative h-100">
                                <img src= "<?php echo htmlspecialchars($product['image']); ?>"
                            alt="Perfumes" class="img-fluid h-100 w-100" style="object-fit: cover;">
                            
                            </div>
                        </div>
                    
                    <div class="col-md-6">
                        <div class="card-body p-5">
                            <h1 class="display-6 fw-bold mb-4"><?php echo htmlspecialchars($product['product_name']); ?></h1>
                            
                            <div class="mb-4">
                                <span class="h2 text-primary"><?php echo htmlspecialchars($product['price']); ?> دولار</span>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="text-muted mb-3">الوصف:</h5>
                                <p class="lead"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                            </div>
                            
                            <div class="d-grid gap-2">
                                
                                <a href="index.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-right me-2"></i>
                                    العودة للرئيسية
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

