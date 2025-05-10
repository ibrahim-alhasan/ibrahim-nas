<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (isLoggedIn()) {
    redirectTo('index.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    
    if (!validateEmail($email)) {
        $errors[] = "البريد الإلكتروني غير صالح";
    }
    
    if (empty($password)) {
        $errors[] = "كلمة المرور مطلوبة";
    }
    
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                $_SESSION['message'] = "مرحباً بك " . $user['username'];
                $_SESSION['message_type'] = "success";
                redirectTo('index.php');
            } else {
                $errors[] = "كلمة المرور غير صحيحة";
            }
        } else {
            $errors[] = "البريد الإلكتروني غير موجود";
        }
    }
}

require_once 'includes/header.php';
?>

<div class="auth-page">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-md-6 d-none d-md-block">
                <img style="height:430px" src="https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" 
                     alt="Luxury Watches" class="img-fluid rounded-3 shadow-lg" >
            </div>
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">تسجيل الدخول</h2>
                        
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
                                <i class="fas fa-sign-in-alt me-2"></i>
                                تسجيل الدخول
                            </button>
                            <p class="text-center mb-0">
                                ليس لديك حساب؟ 
                                <a href="register.php" class="text-decoration-none">إنشاء حساب جديد</a>
                            </p>
                        </form>
                    </div>
                </div>
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

