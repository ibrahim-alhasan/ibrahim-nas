<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    $_SESSION['message'] = "غير مصرح لك بالوصول لهذه الصفحة";
    $_SESSION['message_type'] = "danger";
    redirectTo('index.php');
}

$errors = [];
$success = '';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if ($_GET['delete'] != $_SESSION['user_id']) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
        if ($stmt->execute([$_GET['delete']])) {
            $_SESSION['message'] = "تم حذف المستخدم بنجاح";
            $_SESSION['message_type'] = "success";
            redirectTo('users.php');
        }
    } else {
        $_SESSION['message'] = "لا يمكنك حذف حسابك";
        $_SESSION['message_type'] = "danger";
        redirectTo('users.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = sanitizeInput($_POST['role']);
    $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : null;
    
    if (empty($username)) {
        $errors[] = "اسم المستخدم مطلوب";
    }
    
    if (!validateEmail($email)) {
        $errors[] = "البريد الإلكتروني غير صالح";
    }
    
    if (!$id && !validatePassword($password)) {
        $errors[] = "كلمة المرور يجب أن تكون 6 أحرف على الأقل";
    }
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$email, $id ?? 0]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "البريد الإلكتروني مستخدم بالفعل";
    }
    
    if (empty($errors)) {
        if ($id) { // Update
            $sql = "UPDATE users SET username = ?, email = ?, role = ?";
            $params = [$username, $email, $role];
            
            if (!empty($password)) {
                $sql .= ", password = ?";
                $params[] = password_hash($password, PASSWORD_DEFAULT);
            }
            
            $sql .= " WHERE id = ?";
            $params[] = $id;
            
            $stmt = $conn->prepare($sql);
            if ($stmt->execute($params)) {
                $_SESSION['message'] = "تم تحديث المستخدم بنجاح";
                $_SESSION['message_type'] = "success";
                redirectTo('users.php');
            }
        } else { // Insert
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword, $role])) {
                $_SESSION['message'] = "تم إضافة المستخدم بنجاح";
                $_SESSION['message_type'] = "success";
                redirectTo('users.php');
            }
        }
    }
}

$edit_user = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_user = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stmt = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div style="background-color:#2c3e50" class="card-header  text-white">
                <h3 class="card-title mb-0"><?php echo $edit_user ? 'تعديل المستخدم' : 'إضافة مستخدم جديد'; ?></h3>
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
                
                <form method="POST" class="needs-validation" novalidate>
                    <?php if ($edit_user): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_user['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">اسم المستخدم</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo $edit_user ? htmlspecialchars($edit_user['username']) : ''; ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo $edit_user ? htmlspecialchars($edit_user['email']) : ''; ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <?php echo $edit_user ? 'كلمة المرور (اتركها فارغة إذا لم ترد تغييرها)' : 'كلمة المرور'; ?>
                            </label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   <?php echo !$edit_user ? 'required' : ''; ?>>
                        </div>
                        
                        <div  class="col-md-6 mb-3">
                            <label for="role" class="form-label">نوع المستخدم</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="user" <?php echo ($edit_user && $edit_user['role'] === 'user') ? 'selected' : ''; ?>>مستخدم عادي</option>
                                <option value="admin" <?php echo ($edit_user && $edit_user['role'] === 'admin') ? 'selected' : ''; ?>>مدير</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            <?php echo $edit_user ? 'تحديث المستخدم' : 'إضافة المستخدم'; ?>
                        </button>
                        
                        <?php if ($edit_user): ?>
                            <a href="users.php" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                إلغاء
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div  style="    background-color:#2c3e50 ;
                       " class="card-header text-white">
                <h3 class="card-title mb-0">قائمة المستخدمين</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الإلكتروني</th>
                                <th>نوع المستخدم</th>
                                <th>تاريخ التسجيل</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'success'; ?>">
                                            <?php echo $user['role'] === 'admin' ? 'مدير' : 'مستخدم'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <a href="users.php?edit=<?php echo $user['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                            تعديل
                                        </a>
                                        <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                                            <a href="users.php?delete=<?php echo $user['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                                <i class="fas fa-trash"></i>
                                                حذف
                                            </a>
                                        <?php endif; ?>
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

