-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10 مايو 2025 الساعة 20:40
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- بنية الجدول `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `description`, `image`, `created_at`, `updated_at`) VALUES
(5, 'Dior Sauvage', 50.00, 'عطر رجالي قوي ومنعش، يجمع بين نوتات البرغموت والفلفل الأسود مع قاعدة من الأمبروكسان. يتميز بطابعه الجريء والمفعم بالحيوية، مناسب للأوقات اليومية والمناسبات الخاصة.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRAQvC-MU6ys3JUGvgQ3EOn54le_3EyY3qm0A&amp;s', '2025-05-03 07:36:20', '2025-05-05 18:25:49'),
(6, 'Chanel Coco Mademoiselle', 25.00, 'عطر نسائي أنيق وراقي، يمزج بين نوتات البرتقال والباتشولي والمسك الأبيض. يعكس الأنوثة العصرية والثقة بالنفس، مثالي للمرأة الكلاسيكية التي تعشق اللمسة العصرية.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDLb2oRPqZv8bdMvaFjA5uwldYS7HOCYXAcg&amp;s', '2025-05-03 07:36:40', '2025-05-05 18:26:07'),
(7, 'Tom Ford Black Orchid', 75.00, 'عطر فاخر للجنسين، غني وغامض، يجمع بين نوتات الأوركيد السوداء، الشوكولاتة الداكنة، والبهارات. مثالي للأمسيات والمناسبات الخاصة لمن يبحث عن التميز والتفرد', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuZPt1ZmIBtlVSRSMU_xAk4MP81Vx2rdqoqQ&amp;s', '2025-05-03 07:37:11', '2025-05-05 18:26:31'),
(8, 'رولكس دايتونا', 100.00, 'مصنوعة بعناية من الفولاذ أو الذهب وتتميز بكرونوغراف دقيق.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbzk79-4TfPnOzq74lNN1yyQ0RJNUWiiC5UA&amp;amp;s', '2025-05-03 07:39:11', '2025-05-06 11:04:15'),
(9, 'أوميغا سبيدماستر', 150.00, 'تصميم كلاسيكي مع وظائف دقيقة، وتجمع بين المتانة والأناقة.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSaTczOAEWNSSIawMsDUFISTsW5GwasLdvbKFAWePloqte9tpsct5MQRp0zcCn7zAsBg8U&amp;amp;usqp=CAU', '2025-05-03 07:39:37', '2025-05-06 11:03:55'),
(10, 'باتيك فيليب', 200.00, 'واحدة من أرقى الساعات الفاخرة في العالم.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9SBqaM6c6ZRd5gq7VNskUUF7lIHuNc_b-5Q&amp;amp;s', '2025-05-03 07:40:09', '2025-05-06 11:03:28');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'ahmed alhasan', 'aaaaaaaa@gmail.com', '$2y$10$5RREooaBJvf5uQCr0r704.ny5GxXwHGI.KOOkYEiGb2bkILXevWQC', 'admin', '2025-05-02 17:50:23'),
(2, 'ibrahim alhasan', 'bbbbbbbb@gmail.com', '$2y$10$XXeyf4De5VUtmOm2fxIyD.mgQ1KBwu7OrZR3RT6u5n6wwOvP9rJxq', 'admin', '2025-05-02 17:52:35'),
(3, 'محمد الحسن', 'mmmmmmmm@gmail.com', '$2y$10$pG3iSM35aLSvgyTAwXzVPOXbtRGW67UsmcxVk0RZkZMz87il6QIiO', 'user', '2025-05-02 18:49:41'),
(4, 'اسماعيل الحسن', 'ssssssss@gmail.com', '$2y$10$ehoLq8q32TUk.bBC2hfWfOXP1ZTjwrKqUiQ.ExaCH8D6oKNpgtgWC', 'user', '2025-05-02 18:59:33'),
(6, 'نصر حساني', 'nnnnnnnn@gmail.com', '$2y$10$wrBRgY.ESjveFScaSB2W5.nZribfYfFw6K3vRp.kFf17nzTSsQWyO', 'user', '2025-05-05 07:20:18'),
(7, 'عادل ملحم', 'tttttttt@gmail.com', '$2y$10$vfyegygxJnsLbP7sFNx2SeNtDS3zOfc/9/LU.DQHVZKpvhNJDmHY2', 'user', '2025-05-05 07:32:25'),
(9, 'ahmed', 'oooppp@gmail.com', '$2y$10$kOP62Id0tjVtinSwbutwMeLdqQpaeV1RTF1nrRGkWJfOMjmA4uGJe', 'user', '2025-05-06 11:02:24'),
(10, 'ibrahim', 'asasasas@gmail.com', '$2y$10$ekFIgIA9gXemEmnEu.kzTe3lY0ek.gh/A57OJY0uOCRS0qgaaWMdq', 'user', '2025-05-06 11:05:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
