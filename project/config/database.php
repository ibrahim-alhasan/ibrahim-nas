<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ecommerce');

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";charset=utf8", DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $conn->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->exec("USE " . DB_NAME);
    
    // Create users table
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('user', 'admin') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    // Create products table
    $conn->exec("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_name VARCHAR(100) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        description TEXT,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    
    $conn->exec("INSERT INTO `products` (`id`, `product_name`, `price`, `description`, `image`, `created_at`, `updated_at`) VALUES
(5, 'Dior Sauvage', 50.00, 'عطر رجالي قوي ومنعش، يجمع بين نوتات البرغموت والفلفل الأسود مع قاعدة من الأمبروكسان. يتميز بطابعه الجريء والمفعم بالحيوية، مناسب للأوقات اليومية والمناسبات الخاصة.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRAQvC-MU6ys3JUGvgQ3EOn54le_3EyY3qm0A&amp;s', '2025-05-03 07:36:20', '2025-05-05 18:25:49'),
(6, 'Chanel Coco Mademoiselle', 25.00, 'عطر نسائي أنيق وراقي، يمزج بين نوتات البرتقال والباتشولي والمسك الأبيض. يعكس الأنوثة العصرية والثقة بالنفس، مثالي للمرأة الكلاسيكية التي تعشق اللمسة العصرية.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDLb2oRPqZv8bdMvaFjA5uwldYS7HOCYXAcg&amp;s', '2025-05-03 07:36:40', '2025-05-05 18:26:07'),
(7, 'Tom Ford Black Orchid', 75.00, 'عطر فاخر للجنسين، غني وغامض، يجمع بين نوتات الأوركيد السوداء، الشوكولاتة الداكنة، والبهارات. مثالي للأمسيات والمناسبات الخاصة لمن يبحث عن التميز والتفرد', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuZPt1ZmIBtlVSRSMU_xAk4MP81Vx2rdqoqQ&amp;s', '2025-05-03 07:37:11', '2025-05-05 18:26:31'),
(8, 'رولكس دايتونا', 100.00, 'مصنوعة بعناية من الفولاذ أو الذهب وتتميز بكرونوغراف دقيق.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbzk79-4TfPnOzq74lNN1yyQ0RJNUWiiC5UA&amp;amp;s', '2025-05-03 07:39:11', '2025-05-06 11:04:15'),
(9, 'أوميغا سبيدماستر', 150.00, 'تصميم كلاسيكي مع وظائف دقيقة، وتجمع بين المتانة والأناقة.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSaTczOAEWNSSIawMsDUFISTsW5GwasLdvbKFAWePloqte9tpsct5MQRp0zcCn7zAsBg8U&amp;amp;usqp=CAU', '2025-05-03 07:39:37', '2025-05-06 11:03:55'),
(10, 'باتيك فيليب', 200.00, 'واحدة من أرقى الساعات الفاخرة في العالم.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9SBqaM6c6ZRd5gq7VNskUUF7lIHuNc_b-5Q&amp;amp;s', '2025-05-03 07:40:09', '2025-05-06 11:03:28');
");

} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
