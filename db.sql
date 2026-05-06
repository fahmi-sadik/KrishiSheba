-- Database schema for Krishisheba

CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `nid` VARCHAR(20),
    `profile_image` VARCHAR(255),
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('farmer', 'buyer', 'expert', 'admin') DEFAULT 'buyer',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `farmer_id` INT NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `stock_quantity` INT NOT NULL DEFAULT 0,
    `image_url` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`farmer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

CREATE TABLE `supplies` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `stock_quantity` INT NOT NULL DEFAULT 0,
    `image_url` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `advice_requests` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `farmer_id` INT NOT NULL,
    `expert_id` INT,
    `question` TEXT NOT NULL,
    `answer` TEXT,
    `status` ENUM('pending', 'answered') DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`farmer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`expert_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);
