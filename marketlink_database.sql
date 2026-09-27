-- ==============================================================================
-- MarketLink (eGreen Basket) - Database Schema & Initial Data
-- Category: End-to-End Web Solutions
-- Database Engine: MySQL / MariaDB (Compatible with phpMyAdmin & SQLite)
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------------------------
-- Table structure for `users`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'customer', -- 'admin', 'farmer', 'customer'
  `status` varchar(20) NOT NULL DEFAULT 'active', -- 'active', 'pending', 'suspended'
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `markets`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `markets`;
CREATE TABLE `markets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL DEFAULT 'Karachi',
  `operating_days` varchar(255) NOT NULL, -- e.g. "Saturday, Sunday"
  `opening_time` varchar(50) NOT NULL DEFAULT '08:00 AM',
  `closing_time` varchar(50) NOT NULL DEFAULT '02:00 PM',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `map_provider` varchar(30) NOT NULL DEFAULT 'OpenStreetMap',
  `image` varchar(500) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `farmer_profiles`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `farmer_profiles`;
CREATE TABLE `farmer_profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `market_id` bigint(20) unsigned DEFAULT NULL,
  `stall_name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `operating_days` varchar(255) DEFAULT 'Saturday, Sunday',
  `pickup_time_start` varchar(20) NOT NULL DEFAULT '08:00',
  `pickup_time_end` varchar(20) NOT NULL DEFAULT '14:00',
  `order_cutoff_hours` int(11) NOT NULL DEFAULT 3,
  `stall_number` varchar(50) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending', -- 'pending', 'approved', 'suspended'
  `banner_image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `farmer_profiles_user_id_foreign` (`user_id`),
  KEY `farmer_profiles_market_id_foreign` (`market_id`),
  CONSTRAINT `farmer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `farmer_profiles_market_id_foreign` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `categories`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) NOT NULL DEFAULT 'bi-basket',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `products`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `farmer_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(50) NOT NULL DEFAULT 'kg',
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `is_sold_out` tinyint(1) NOT NULL DEFAULT 0,
  `is_weekly_template` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_farmer_id_foreign` (`farmer_id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `orders`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `farmer_id` bigint(20) unsigned NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time_slot` varchar(100) NOT NULL,
  `order_status` varchar(30) NOT NULL DEFAULT 'placed', -- 'placed', 'accepted', 'ready_for_pickup', 'completed', 'cancelled'
  `payment_status` varchar(30) NOT NULL DEFAULT 'pay_at_pickup_pending',
  `customer_notes` text DEFAULT NULL,
  `farmer_notes` text DEFAULT NULL,
  `cancelled_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_farmer_id_foreign` (`farmer_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `order_items`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `unit` varchar(50) NOT NULL DEFAULT 'kg',
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `reviews`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `farmer_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text NOT NULL,
  `farmer_reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_customer_id_foreign` (`customer_id`),
  KEY `reviews_farmer_id_foreign` (`farmer_id`),
  CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `favorites`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(20) NOT NULL,
  `target_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `favorites_user_id_type_target_id_unique` (`user_id`,`type`,`target_id`),
  CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `announcements`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target_role` varchar(20) NOT NULL DEFAULT 'all',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `faqs`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'General',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `notifications`
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Seed Default Initial Data (Admin, Farmers, Customers, Markets, Categories, Products)
-- ------------------------------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `password`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'admin@marketlink.com', '+92 300 1234567', 'Main Shahrah-e-Faisal, Karachi', 'admin', 'active', '$2y$12$eOa/R3u6mN0XvT4k2Fm0O.b6U7tX2rT5jW6s4y8v1m2n3o4p5q6r7', NOW(), NOW()),
(2, 'Tariq Jameel (Green Valley Farms)', 'greenfarms@marketlink.com', '+92 321 4455667', 'Green Valley Agro Farm, Malir, Karachi', 'farmer', 'active', '$2y$12$eOa/R3u6mN0XvT4k2Fm0O.b6U7tX2rT5jW6s4y8v1m2n3o4p5q6r7', NOW(), NOW()),
(3, 'Fatima Zahra (Sunshine Orchards)', 'orchards@marketlink.com', '+92 333 8899112', 'Sunshine Fruit Orchards, Lahore', 'farmer', 'active', '$2y$12$eOa/R3u6mN0XvT4k2Fm0O.b6U7tX2rT5jW6s4y8v1m2n3o4p5q6r7', NOW(), NOW()),
(4, 'Bilal Ashraf (Highland Dairy)', 'artisan@marketlink.com', '+92 312 9988776', 'Highland Grazing Pastures, Islamabad', 'farmer', 'active', '$2y$12$eOa/R3u6mN0XvT4k2Fm0O.b6U7tX2rT5jW6s4y8v1m2n3o4p5q6r7', NOW(), NOW()),
(5, 'Ali Khan', 'ali.khan@gmail.com', '+92 333 1122334', 'House 45-B, DHA Phase 6, Karachi', 'customer', 'active', '$2y$12$eOa/R3u6mN0XvT4k2Fm0O.b6U7tX2rT5jW6s4y8v1m2n3o4p5q6r7', NOW(), NOW());

INSERT INTO `markets` (`id`, `name`, `description`, `address`, `city`, `operating_days`, `opening_time`, `closing_time`, `latitude`, `longitude`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Clifton Beachside Farmers Market', 'Vibrant coastal weekend market featuring fresh organic greens and artisan produce.', 'Near Marine Drive, Clifton Block 4, Karachi', 'Karachi', 'Saturday, Sunday', '08:00 AM', '02:00 PM', 24.8138, 67.0300, 'active', NOW(), NOW()),
(2, 'Gulberg Eco Organic Fair', 'Premier destination for farm fresh harvest, honey, and dairy.', 'Main Boulevard, Gulberg III, Lahore', 'Lahore', 'Friday, Saturday', '09:00 AM', '03:00 PM', 31.5204, 74.3587, 'active', NOW(), NOW()),
(3, 'F-7 Markaz Community Harvest Bazaar', 'Mountain honey, citrus, and microgreens bazaar in Islamabad.', 'Jinnah Super Market Civic Center, Sector F-7, Islamabad', 'Islamabad', 'Sunday', '08:30 AM', '01:30 PM', 33.7215, 73.0560, 'active', NOW(), NOW());

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Vegetables', 'fresh-vegetables', 'Crisp, naturally grown seasonal vegetables.', 'bi-flower2', 1, NOW(), NOW()),
(2, 'Seasonal Fruits', 'seasonal-fruits', 'Sun-ripened orchard fresh fruits.', 'bi-apple', 1, NOW(), NOW()),
(3, 'Dairy & Farm Eggs', 'dairy-farm-eggs', 'Grass-fed milk, artisan butter, and desi eggs.', 'bi-egg-fried', 1, NOW(), NOW()),
(4, 'Artisan Bakery & Grains', 'artisan-bakery-grains', 'Sourdough loaves and stone ground grains.', 'bi-cake2', 1, NOW(), NOW()),
(5, 'Herbs & Microgreens', 'herbs-microgreens', 'Aromatic fresh herbs and microgreens.', 'bi-tree', 1, NOW(), NOW()),
(6, 'Honey & Preserves', 'honey-preserves', 'Raw wild Sidr honey and homemade jams.', 'bi-droplet-half', 1, NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
