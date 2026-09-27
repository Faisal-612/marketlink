-- ========================================================
-- MarketLink Database Dump for InfinityFree / MySQL Hosting
-- Generated from Active Database with Exact Column Types
-- ========================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_26_000001_create_markets_table', 1),
(5, '2026_09_26_000002_create_farmer_profiles_table', 1),
(6, '2026_09_26_000003_create_categories_table', 1),
(7, '2026_09_26_000004_create_products_table', 1),
(8, '2026_09_26_000005_create_orders_table', 1),
(9, '2026_09_26_000006_create_order_items_table', 1),
(10, '2026_09_26_000007_create_reviews_table', 1),
(11, '2026_09_26_000008_create_favorites_table', 1),
(12, '2026_09_26_000009_create_announcements_table', 1),
(13, '2026_09_26_000010_create_faqs_table', 1),
(14, '2026_09_26_000011_create_notifications_table', 1);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'admin@marketlink.com', '+92 300 1234567', 'Main Shahrah-e-Faisal, Karachi', 'admin', 'active', NULL, NULL, '$2y$12$lxNTzmvWZnzPlxDMwJepV.phByic4jilzNQe.mqcMkwNm3IkK2Pce', '0RhFePaWsgio7qGGRP8PRihv00NlgZoxv0k3IeaymYiHWK4LgqglcoFm6QXv', '2026-09-26 08:00:39', '2026-09-26 08:00:39'),
(2, 'Tariq Jameel (Green Valley Farms)', 'greenfarms@marketlink.com', '+92 321 4455667', 'Green Valley Agro Farm, Malir Countryside, Karachi', 'farmer', 'active', NULL, NULL, '$2y$12$zB35CgL4Y1WyGIBr8huiEORx04voxI9ssklgkxcYjP7qVir6zN33i', '98hI3Mo3NfnG9eeNQZwITw67UfAHRnm52ABgK8hxmU6TSaV55MdDlOPF3JJX', '2026-09-26 08:00:40', '2026-09-26 08:00:40'),
(3, 'Fatima Zahra (Sunshine Orchards)', 'orchards@marketlink.com', '+92 333 8899112', 'Sunshine Fruit Orchards, Sheikhupura Road, Lahore', 'farmer', 'suspended', NULL, NULL, '$2y$12$S4CBHiZyicj9inuFPMU5S.Hegx0H13YGhvEc9hrh9swO5loctQ/ru', NULL, '2026-09-26 08:00:41', '2026-09-26 08:47:24'),
(4, 'Bilal Ashraf (Highland Dairy)', 'artisan@marketlink.com', '+92 312 9988776', 'Highland Grazing Pastures, Chak Shehzad, Islamabad', 'farmer', 'suspended', NULL, NULL, '$2y$12$sg5Dq8h9tMjOv0cQtSZzb.z5MbSRpgjmIuN.OtQAft7qBNyvqjWqu', NULL, '2026-09-26 08:00:41', '2026-09-26 08:47:26'),
(5, 'Kamran Mirza (Pothohar Hydroponics)', 'hydroponics@marketlink.com', '+92 345 5566778', 'Pothohar Modern Greenhouse, Rawalpindi', 'farmer', 'pending', NULL, NULL, '$2y$12$jUPjv1DDJRcCcvb2IeCT6OKkwNNESQe74tBiO9fcuOycx5m/0KMOu', NULL, '2026-09-26 08:00:42', '2026-09-26 08:00:42'),
(6, 'Ali Khan', 'ali.khan@gmail.com', '+92 333 1122334', 'House 45-B, DHA Phase 6, Karachi', 'customer', 'active', NULL, NULL, '$2y$12$imhVOo4V/nzfhwJ6w.k5h.VgdJ3XGHcvSqLgrp8CaHfCOruYks20m', '9NqCItaelcNzd1eCtvY1puUQe6vfxBJ6QFTbUFLSRdz9scVOLQzIfJzI8xAk', '2026-09-26 08:00:43', '2026-09-26 08:00:43'),
(7, 'Sara Ahmed', 'sara.ahmed@gmail.com', '+92 322 9988112', 'Flat 12-C, Askari 10, Lahore', 'customer', 'active', NULL, NULL, '$2y$12$mNDEU3j3ZjGiQ3K14EEyOutI7qk.IvGim8tUBYBApwsdaQgN2xs0m', NULL, '2026-09-26 08:00:43', '2026-09-26 08:00:43'),
(8, 'Zainab Raza', 'zainab.raza@gmail.com', '+92 315 7766554', 'Sector F-8/2, Street 19, Islamabad', 'customer', 'active', NULL, NULL, '$2y$12$RkLZzpklWxzy/VVwjvC/X.wG2vxZwg2Mcojv1A1bFAvi9xh3dXQEK', NULL, '2026-09-26 08:00:44', '2026-09-26 08:00:44');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('wcdRPzKXpmxGrWBwJs6zq88lLutAwUm78B7XmlEz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.19041.6456', 'eyJfdG9rZW4iOiJoanVFT1NaRTdlUzVleTExVDE4OHlseEJ2cFdnNGVQa0dhY1FMcWRaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790417976),
('LYVZ4MMz5mUqtQvE8JZZGionsPRQhdqaVoBhDow2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', 'eyJfdG9rZW4iOiJXSERSUmQwdjRZY0pDQU1sbkFrQlVHRTJmQWFJeER5YkNkWUMyQk5qIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1790421628);

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` text NOT NULL,
  `attempts` int NOT NULL,
  `reserved_at` int DEFAULT NULL,
  `available_at` int NOT NULL,
  `created_at` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` text NOT NULL,
  `options` text DEFAULT NULL,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` text NOT NULL,
  `exception` text NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `markets`;
CREATE TABLE `markets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL DEFAULT 'Karachi',
  `operating_days` varchar(255) NOT NULL,
  `opening_time` varchar(255) NOT NULL DEFAULT '08:00 AM',
  `closing_time` varchar(255) NOT NULL DEFAULT '02:00 PM',
  `latitude` decimal(10,2) DEFAULT NULL,
  `longitude` decimal(10,2) DEFAULT NULL,
  `map_provider` varchar(255) NOT NULL DEFAULT 'OpenStreetMap',
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `markets` (`id`, `name`, `description`, `address`, `city`, `operating_days`, `opening_time`, `closing_time`, `latitude`, `longitude`, `map_provider`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Clifton Beachside Farmers Market', 'Vibrant coastal weekend market featuring fresh organic greens, seasonal fruits, artisan bakery goods and wild honey directly from Sindh growers.', 'Near Marine Drive, Clifton Block 4, Karachi', 'Karachi', 'Saturday, Sunday', '08:00 AM', '02:00 PM', 24.8138, 67.03, 'OpenStreetMap', 'images/markets/market_101.jpg', 'active', '2026-09-26 08:00:39', '2026-09-26 08:00:39'),
(2, 'Gulberg Eco Organic Fair', 'Premier Punjab community harvest fair bringing together certified organic family farms, desi dairy, and raw honey producers.', 'Main Boulevard, Gulberg III, Lahore', 'Lahore', 'Friday, Saturday', '09:00 AM', '03:00 PM', 31.5204, 74.3587, 'OpenStreetMap', 'images/markets/market_102.jpg', 'active', '2026-09-26 08:00:39', '2026-09-26 08:00:39'),
(3, 'F-7 Markaz Community Harvest Bazaar', 'Scenic Sunday open-air bazaar showcasing Margalla valley organic produce, mountain dry fruits, fresh herbs, and farm eggs.', 'Jinnah Super Market Civic Center, Sector F-7, Islamabad', 'Islamabad', 'Sunday', '08:30 AM', '01:30 PM', 33.7215, 73.056, 'OpenStreetMap', 'images/markets/market_103.jpg', 'active', '2026-09-26 08:00:39', '2026-09-26 08:00:39'),
(4, 'DHA Phase 5 Eco Bazaar', 'Boutique open-air weekend marketplace offering hydroponic greens, cold-pressed oils, and farm fresh vegetables.', 'Commercial Avenue, Phase 5 DHA, Karachi', 'Karachi', 'Saturday, Sunday', '07:30 AM', '01:00 PM', 24.7865, 67.062, 'OpenStreetMap', 'images/markets/market_104.jpg', 'active', '2026-09-26 08:00:39', '2026-09-26 08:00:39');

DROP TABLE IF EXISTS `farmer_profiles`;
CREATE TABLE `farmer_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `market_id` int DEFAULT NULL,
  `stall_name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `operating_days` varchar(255) DEFAULT NULL,
  `pickup_time_start` varchar(255) NOT NULL DEFAULT '08:00',
  `pickup_time_end` varchar(255) NOT NULL DEFAULT '14:00',
  `order_cutoff_hours` int NOT NULL DEFAULT '3',
  `stall_number` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,2) DEFAULT NULL,
  `longitude` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `banner_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `farmer_profiles` (`id`, `user_id`, `market_id`, `stall_name`, `bio`, `operating_days`, `pickup_time_start`, `pickup_time_end`, `order_cutoff_hours`, `stall_number`, `latitude`, `longitude`, `status`, `banner_image`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Green Valley Organics', 'Family-owned sustainable agro-farm in Malir. We specialize in pesticide-free heirloom vegetables, hydroponic lettuces, and organic root crops.', 'Saturday, Sunday', '08:00', '13:30', 3, 'Stall #A-12', 24.8142, 67.0305, 'approved', 'images/site/banner_101.png', '2026-09-26 08:00:40', '2026-09-26 08:00:40'),
(2, 3, 2, 'Sunshine Orchards & Pure Honey', 'Specializing in sweet Pakistani citrus, handpicked orchard apples, guava, and cold-extracted raw Beri (Sidr) honey straight from our hives.', 'Friday, Saturday', '09:00', '14:30', 4, 'Stall #B-04', 31.521, 74.3592, 'suspended', 'images/site/banner_102.png', '2026-09-26 08:00:41', '2026-09-26 08:47:24'),
(3, 4, 3, 'Highland Artisan Dairy & Bakery', 'Pure A2 grass-fed dairy products, cultured desi ghee, organic country eggs, and cold-pressed mustard and walnut oils.', 'Sunday', '08:30', '13:00', 2, 'Stall #C-08', 33.722, 73.0565, 'suspended', 'images/site/banner_101.png', '2026-09-26 08:00:41', '2026-09-26 08:47:26'),
(4, 5, 4, 'Pothohar Hydroponic Greens', 'Modern soil-less hydroponic farming providing clean European lettuces, cherry tomatoes, and culinary herbs.', 'Saturday, Sunday', '08:00', '12:30', 3, 'Stall #D-02', 24.787, 67.0625, 'pending', 'images/site/banner_102.png', '2026-09-26 08:00:42', '2026-09-26 08:00:42');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'bi-basket',
  `is_active` int NOT NULL DEFAULT '1',
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Vegetables', 'fresh-vegetables', 'Crisp, naturally grown seasonal vegetables harvested directly from farm fields.', 'fi fi-sr-carrot', 1, '2026-09-26 08:00:39', '2026-09-26 08:00:39'),
(2, 'Seasonal Fruits', 'seasonal-fruits', 'Sun-ripened orchard fresh fruits with exceptional natural sweetness.', 'fi fi-sr-apple', 1, '2026-09-26 08:00:39', '2026-09-26 08:00:39'),
(3, 'Dairy & Farm Eggs', 'dairy-farm-eggs', 'Grass-fed whole milk, cultured desi butter, and free-range country eggs.', 'fi fi-sr-egg', 1, '2026-09-26 08:00:39', '2026-09-26 08:00:39'),
(4, 'Artisan Grains & Bakery', 'artisan-bakery-grains', 'Stone ground whole grains, cold-pressed oils, and traditional staples.', 'fi fi-sr-bread-slice', 1, '2026-09-26 08:00:39', '2026-09-26 08:00:39'),
(5, 'Herbs & Microgreens', 'herbs-microgreens', 'Aromatic culinary herbs, hydroponic greens, and crisp salad leaves.', 'fi fi-sr-leaf', 1, '2026-09-26 08:00:39', '2026-09-26 08:00:39');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `farmer_id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(255) NOT NULL DEFAULT 'kg',
  `stock_quantity` int NOT NULL DEFAULT '0',
  `is_available` int NOT NULL DEFAULT '1',
  `is_sold_out` int NOT NULL DEFAULT '0',
  `is_weekly_template` int NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_available`, `is_sold_out`, `is_weekly_template`, `image`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Purple Heirloom Organic Tomatoes (500g)', 'purple-heirloom-organic-tomatoes-500g', 'Naturally vine-ripened, juicy and sweet heirloom purple tomatoes harvested early morning without synthetic fertilizers.', 220, 'kg', 45, 1, 0, 1, 'images/products/item_102.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(2, 2, 1, 'Yellow Pear Cherry Tomatoes (250g)', 'yellow-pear-cherry-tomatoes-250g', 'Gourmet sweet yellow cherry tomatoes with low acidity, perfect for snacking and colorful salads.', 190, 'box', 35, 1, 0, 1, 'images/products/item_103.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(3, 2, 1, 'Crisp Organic Bok Choy (500g)', 'crisp-organic-bok-choy-500g', 'Succulent Asian bok choy with crunchy stems and tender leaves, grown 100% chemical-free.', 200, 'bunch', 35, 1, 0, 1, 'images/products/item_104.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(4, 2, 5, 'Fresh Gourmet Salad Mix & Greens (500g)', 'fresh-gourmet-salad-mix-greens-500g', 'Tender artisanal mix of garden lettuces and crisp micro greens, washed and ready for serving.', 260, 'pack', 40, 1, 0, 1, 'images/products/item_105.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(5, 2, 1, 'Fresh Farm Garlic (500g)', 'fresh-farm-garlic-500g', 'Aromatic organic garlic bulbs packed with intense flavor and natural essential oils.', 320, 'pack', 50, 1, 0, 1, 'images/products/item_106.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(6, 3, 2, 'Sundarkhani Sweet Mountain Grapes (500g)', 'sundarkhani-sweet-mountain-grapes-500g', 'Seedless, elongated and exceptionally crisp mountain grapes handpicked at prime sweetness.', 350, 'kg', 40, 1, 0, 1, 'images/products/item_107.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(7, 3, 2, 'Red Blood & Shakri Oranges (Dozen)', 'red-blood-shakri-oranges-dozen', 'Packed with natural Vitamin C, high juice yield and rich ruby interior from Punjab orchards.', 280, 'dozen', 50, 1, 0, 1, 'images/products/item_108.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(8, 3, 2, 'Fresh Organic Figs / Anjeer (500g)', 'fresh-organic-figs-anjeer-500g', 'Luscious, honey-sweet fresh figs harvested from organic mountain groves in prime maturity.', 450, 'box', 25, 1, 0, 1, 'images/products/item_109.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(9, 3, 2, 'Handpicked Fresh Strawberries (250g)', 'handpicked-fresh-strawberries-250g', 'Sun-ripened, fragrant red strawberries picked fresh from organic strawberry patches.', 290, 'box', 30, 1, 0, 1, 'images/products/item_110.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(11, 4, 3, 'Free Range Farm Eggs (Dozen)', 'free-range-farm-eggs-dozen', 'Pasture-raised, nutrient-dense free range brown eggs with rich golden yolks from happy hens.', 340, 'dozen', 60, 1, 0, 1, 'images/products/item_101.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(12, 4, 4, '100% Pure Cold-Pressed Mustard (Sarson) Oil (200ml)', 'pure-cold-pressed-mustard-sarson-oil-200ml', 'Traditional cold-pressed unrefined Sarson oil with authentic pungency and health benefits.', 420, 'bottle', 25, 1, 0, 1, 'images/products/item_112.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(13, 4, 4, 'Cold-Pressed Pure Walnut Oil (120ml)', 'cold-pressed-pure-walnut-oil-120ml', 'Raw, single-origin mountain walnut oil rich in Omega-3 fatty acids for culinary dressings and wellness.', 780, 'bottle', 18, 1, 0, 1, 'images/products/item_113.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(14, 4, 4, 'Pure Apricot Kernel Oil (120ml)', 'pure-apricot-kernel-oil-120ml', 'Traditional Himalayan cold-pressed apricot kernel oil, deeply nourishing and naturally scented.', 720, 'bottle', 20, 1, 0, 1, 'images/products/item_114.jpg', '2026-09-26 08:00:44', '2026-09-26 08:00:44');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL,
  `customer_id` int NOT NULL,
  `farmer_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time_slot` varchar(255) NOT NULL,
  `order_status` varchar(255) NOT NULL DEFAULT 'placed',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pay_at_pickup_pending',
  `customer_notes` text DEFAULT NULL,
  `farmer_notes` text DEFAULT NULL,
  `cancelled_reason` text DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `farmer_id`, `total_amount`, `pickup_date`, `pickup_time_slot`, `order_status`, `payment_status`, `customer_notes`, `farmer_notes`, `cancelled_reason`, `created_at`, `updated_at`) VALUES
(1, 'ML-AHBJVJGC', 6, 2, 650, '2026-09-24 00:00:00', '09:00 AM - 10:00 AM', 'completed', 'paid_at_pickup', 'Please pick ripe red tomatoes suitable for quick salad prep.', 'Handpicked fresh tomatoes packed in reusable kraft paper basket.', NULL, '2026-09-23 08:00:44', '2026-09-26 08:00:44'),
(2, 'ML-4UFG1GXB', 7, 3, 1280, '2026-09-27 00:00:00', '10:30 AM - 11:30 AM', 'confirmed', 'pay_at_pickup', 'Will bring own tote bags for pickup.', NULL, NULL, '2026-09-26 00:00:44', '2026-09-26 08:00:44'),
(3, 'ML-YUZGWT8O', 8, 4, 760, '2026-09-28 00:00:00', '09:30 AM - 10:30 AM', 'pending', 'pay_at_pickup', 'First time order, looking forward!', NULL, NULL, '2026-09-26 06:00:44', '2026-09-26 08:00:44');

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `unit` varchar(255) NOT NULL DEFAULT 'kg',
  `quantity` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `unit`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Purple Heirloom Organic Tomatoes (500g)', 220, 'kg', 2, 440, '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(2, 1, 3, 'Crisp Organic Bok Choy (500g)', 200, 'bunch', 1, 190, '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(3, 1, 4, 'Fresh Gourmet Salad Mix & Greens (500g)', 260, 'pack', 1, 80, '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(4, 2, 6, 'Sundarkhani Sweet Mountain Grapes (500g)', 350, 'kg', 1, 350, '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(5, 2, 7, 'Red Blood & Shakri Oranges (Dozen)', 280, 'dozen', 1, 280, '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(6, 2, NULL, 'Artisan Cherry Preserve & Wild Jam (200ml)', 650, 'jar', 1, 650, '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(7, 3, 11, 'Free Range Farm Eggs (Dozen)', 340, 'dozen', 1, 340, '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(8, 3, 12, '100% Pure Cold-Pressed Mustard (Sarson) Oil (200ml)', 420, 'bottle', 1, 420, '2026-09-26 08:00:44', '2026-09-26 08:00:44');

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `farmer_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `comment` text NOT NULL,
  `farmer_reply` text DEFAULT NULL,
  `replied_at` timestamp DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reviews` (`id`, `customer_id`, `farmer_id`, `product_id`, `order_id`, `rating`, `comment`, `farmer_reply`, `replied_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 2, NULL, NULL, 5, 'The heirloom purple tomatoes were outstanding! Extremely fresh and fragrant, picked just right before the Clifton weekend market. 10/10.', 'Thank you Ali bhai! We harvest all heirloom varieties at dawn before opening the stall.', NULL, 'published', '2026-09-26 08:00:44', '2026-09-26 08:00:44'),
(2, 7, 3, NULL, NULL, 5, 'The Sundarkhani grapes were crispy and sweet. Seamless pickup at Gulberg market stall without waiting in line.', 'Appreciated Sara! We reserve pre-orders in custom crates so you never have to wait.', NULL, 'published', '2026-09-26 08:00:45', '2026-09-26 08:00:45');

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` varchar(255) NOT NULL,
  `target_id` int NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `favorites` (`id`, `user_id`, `type`, `target_id`, `created_at`, `updated_at`) VALUES
(2, 6, 'product', 5, '2026-09-26 10:33:02', '2026-09-26 10:33:02');

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target_role` varchar(255) NOT NULL DEFAULT 'all',
  `is_active` int NOT NULL DEFAULT '1',
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `announcements` (`id`, `title`, `content`, `target_role`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Welcome to MarketLink Platform!', 'Connecting organic local farmers directly with consumers for weekly farmers market pre-orders. Zero food wastage, 100% farm fresh guarantee!', 'all', 1, '2026-09-26 08:00:45', '2026-09-26 08:00:45'),
(2, 'Farmer Notice: Update your weekly stock templates by Thursday 8 PM', 'Please review and publish your weekend market harvest so customers can place pre-orders before cutoff times.', 'farmer', 1, '2026-09-26 08:00:45', '2026-09-26 08:00:45');

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'General',
  `is_active` int NOT NULL DEFAULT '1',
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'How does pre-ordering on MarketLink work?', 'Browse products from your favorite local farmers, add them to your cart, select your pickup market day and time slot, and submit the pre-order. You pay cash or card directly when you pick up at the farmer’s stall.', 'General', 1, '2026-09-26 08:00:45', '2026-09-26 08:00:45'),
(2, 'Is payment required online?', 'No online payment gateway is required. All pre-orders are settled directly in person at the market stall during pickup.', 'General', 1, '2026-09-26 08:00:45', '2026-09-26 08:00:45'),
(3, 'Can I cancel or modify my pre-order?', 'Yes! You can cancel or modify your order from your Customer Dashboard before the farmer’s designated cut-off time (usually 3-4 hours prior to market start).', 'General', 1, '2026-09-26 08:00:45', '2026-09-26 08:00:45'),
(4, 'What are the operating market timings?', 'Weekend markets generally operate between 08:00 AM and 02:00 PM on Saturdays and Sundays. You can check the interactive Market Map for exact location coordinates and hours.', 'General', 1, '2026-09-26 08:00:45', '2026-09-26 08:00:45'),
(5, 'How can a farmer join MarketLink?', 'Click \"Register as Farmer\", enter your business/stall information and market details. Once our Admin team reviews and approves your stall profile, you can immediately begin listing your weekly produce.', 'General', 1, '2026-09-26 08:00:45', '2026-09-26 08:00:45'),
(6, 'Where can I see the live stall map?', 'Visit the \"Markets & Map\" page in the navigation bar to see interactive OpenStreetMap markers for all farmers markets and active stalls with direct navigation routes.', 'General', 1, '2026-09-26 08:00:45', '2026-09-26 08:00:45');

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` int NOT NULL DEFAULT '0',
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
