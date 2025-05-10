<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    redirectTo('login.php');
}

$errors = [];
$success = '';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$_GET['delete']])) {
        
        $_SESSION['message'] = "تم حذف المنتج بنجاح";
        $_SESSION['message_type'] = "success";
        redirectTo('products.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = sanitizeInput($_POST['product_name']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $description = sanitizeInput($_POST['description']);
    $image_url = sanitizeInput($_POST["image_url"]);
    $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : null;
    
    if (empty($product_name)) {
        $errors[] = "اسم المنتج مطلوب";
    }
    
    if ($price === false || $price <= 0) {
        $errors[] = "السعر غير صالح";
    }
    
    
    
    if (empty($errors)) {
        if ($id) { // Update
            $sql = "UPDATE products SET product_name = ?, price = ?, description = ?, image = ?";
            $params = [$product_name, $price, $description , $image_url];
            
            
            $sql .= " WHERE id = ?";
            $params[] = $id;
            
            $stmt = $conn->prepare($sql);
            if ($stmt->execute($params)) {
                $_SESSION['message'] = "تم تحديث المنتج بنجاح";
                $_SESSION['message_type'] = "success";
                redirectTo('products.php');
            }
        } else { // Insert
            $sql = "INSERT INTO products (product_name, price, description , image) VALUES (?, ?, ?,?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$product_name, $price, $description , $image_url])) {
                $_SESSION['message'] = "تم إضافة المنتج بنجاح";
                $_SESSION['message_type'] = "success";
                redirectTo('products.php');
            }
        }
    }
}

$edit_product = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get all products
$stmt = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $edit_product ? 'تعديل المنتج' : 'إضافة منتج جديد'; ?></h3>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <?php if ($edit_product): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="product_name" class="form-label">اسم المنتج</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" 
                               value="<?php echo $edit_product ? htmlspecialchars($edit_product['product_name']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="price" class="form-label">السعر</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" 
                               value="<?php echo $edit_product ? htmlspecialchars($edit_product['price']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php 
                            echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; 
                        ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">اضف رابط الصورة</label>
                        <input type="text" class="form-control" id="image_url" name="image_url" 
                               value="<?php echo $edit_product ? htmlspecialchars($edit_product['image']) : ''; ?>" required>
                    
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary">
                        <?php echo $edit_product ? 'تحديث المنتج' : 'إضافة المنتج'; ?>
                    </button>
                    
                    <?php if ($edit_product): ?>
                        <a href="products.php" class="btn btn-secondary">إلغاء</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">قائمة المنتجات</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>اسم المنتج</th>
                                <th>السعر</th>
                                <th>الوصف</th>
                                <th>رابط الصورة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['price']); ?> دولار</td>
                                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                                    <td><?php echo htmlspecialchars($product['image']); ?></td>
                                    <td>
                                        <a href="products.php?edit=<?php echo $product['id']; ?>" 
                                           class="btn btn-sm btn-primary">تعديل</a>
                                        <a  href="products.php?delete=<?php echo $product['id']; ?>" 
                                           class="btn btn-sm btn-danger mt-1" 
                                           onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟');"> حــذف</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

