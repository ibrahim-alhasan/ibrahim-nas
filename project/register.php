<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (isLoggedIn()) {
    redirectTo('index.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($username)) {
        $errors[] = "اسم المستخدم مطلوب";
    }
    
    if (!validateEmail($email)) {
        $errors[] = "البريد الإلكتروني غير صالح";
    }
    
    if (!validatePassword($password)) {
        $errors[] = "كلمة المرور يجب أن تكون 6 أحرف على الأقل";
    }
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "البريد الإلكتروني مستخدم بالفعل";
    }
    
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$username, $email, $hashedPassword])) {
            $_SESSION['message'] = "تم إنشاء الحساب بنجاح";
            $_SESSION['message_type'] = "success";
            redirectTo('index.php');
        } else {
            $errors[] = "حدث خطأ أثناء إنشاء الحساب";
        }
    }
}

require_once 'includes/header.php';
?>

<div class="auth-page">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">إنشاء حساب جديد</h2>
                        
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" class="needs-validation" novalidate>
                            <div class="mb-4">
                                <label for="username" class="form-label">اسم المستخدم</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>
                                إنشاء حساب
                            </button>
                            <p class="text-center mb-0">
                                لديك حساب بالفعل؟ 
                                <a href="login.php" class="text-decoration-none">تسجيل الدخول</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-block">
                <img style="height:500px" src="https://images.pexels.com/photos/965989/pexels-photo-965989.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" 
                     alt="Luxury Perfumes" class="img-fluid rounded-3 shadow-lg">
            </div>
        </div>
    </div>
</div>

<style>
.auth-page {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    margin-top: -24px;
}
.card {
    border-radius: 15px;
}
.input-group-text {
    background-color: #f8f9fa;
    border-left: none;
}
.form-control {
    border-right: none;
}
.form-control:focus {
    border-color: #dee2e6;
    box-shadow: none;
}
</style>

