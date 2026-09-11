CREATE DATABASE IF NOT EXISTS `iraab_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `iraab_db`;

-- Bảng tài khoản quản trị
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tạo tài khoản admin mặc định (Mật khẩu: Admin@123)
INSERT INTO `users` (`username`, `password`) VALUES
('admin', '$2y$10$agKYxw15idbwjuF79hweaOO2y78k8NaN6nW/S4i4.hBL7aDt80eC.'); 

-- Bảng lưu trữ Tin tức & Sự kiện hàng ngày
CREATE TABLE IF NOT EXISTS `news` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `summary` TEXT NOT NULL,
    `content` LONGTEXT NOT NULL,
    `image` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);