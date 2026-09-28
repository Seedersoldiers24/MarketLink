-- MarketLink - eGreen Basket SQL Database Dump
-- Exported on: 2026-09-26 15:38:24
-- Compatible with MySQL 5.7+ / 8.0+ / MariaDB

SET FOREIGN_KEY_CHECKS = 0;
CREATE DATABASE IF NOT EXISTS `marketlink` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `marketlink`;

--
-- Structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `role` enum('admin','farmer','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `status` enum('active','suspended','deactivated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'MarketLink Admin', 'admin@marketlink.com', '+1 (555) 010-0001', 'Central Platform Office, Suite 400', 'admin', 'active', NULL, '$2y$12$40/eRBcT6BqZlo9Xf4dOGeWTGFFglFtzAaKJslRfd0k2n5DGI5vji', NULL, '2026-09-26 15:36:09', '2026-09-26 15:36:09');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('2', 'Sarah Jenkins', 'customer@marketlink.com', '+1 (555) 234-5678', '742 Evergreen Terrace, Springfield', 'customer', 'active', NULL, '$2y$12$760q3QFejb86b3vrW/egVe4f20eTycW.IQnI/lzl8VHLmI/00hVCG', NULL, '2026-09-26 15:36:09', '2026-09-26 15:36:09');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('3', 'Michael Chang', 'michael@marketlink.com', '+1 (555) 345-6789', '120 Oakridge Lane, Springfield', 'customer', 'active', NULL, '$2y$12$xL7BM25qPq4D2XOQsTzRjOtK.ahcFQJrVnmB7g5Z.wpeoIUOfj/Gy', NULL, '2026-09-26 15:36:09', '2026-09-26 15:36:09');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('4', 'Emily Watson', 'emily@marketlink.com', '+1 (555) 456-7890', '88 Blossom Hill Rd, Springfield', 'customer', 'active', NULL, '$2y$12$DyWg8rt4vnC0m6F5o5QrF.ZievblLK3WQEC25D2W3c1Qh6T32Vht.', NULL, '2026-09-26 15:36:10', '2026-09-26 15:36:10');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('5', 'John Green', 'farmer@marketlink.com', '+1 (555) 789-0123', 'Sunny Valley Way, Valley Ridge Farm #12', 'farmer', 'active', NULL, '$2y$12$dnijMJwHEWG7f7IRue79IOoN4lp/1shMWMYtV5K/a4MuecugYIs8.', NULL, '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('6', 'Elena Vance', 'elena@marketlink.com', '+1 (555) 890-1234', 'Riverbend Creek Road, Orchard Haven', 'farmer', 'active', NULL, '$2y$12$QdxeDlmuQRzYSYFOGkD7O.gHck/fZLWpjTrEmRL.uCPp8C0.mB4R.', NULL, '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('7', 'Carlos Rodriguez', 'carlos@marketlink.com', '+1 (555) 901-2345', 'Highland Meadows Trail #45', 'farmer', 'active', NULL, '$2y$12$lbUxF3YDNmDsNRnqZXcnC.bOoNGuT8hCLdYIQwd.LnexANX4n.9Ey', NULL, '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('8', 'Maria Chen', 'maria@marketlink.com', '+1 (555) 012-3456', 'Artisan Mill House, Mill Valley Road', 'farmer', 'active', NULL, '$2y$12$KVhF/VtYIH6iARUNhbGRXOFGdmPBTwOCf6B1YDGRqCAwhvVmxhJue', NULL, '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('9', 'David Miller', 'david@marketlink.com', '+1 (555) 123-9876', 'Meadow Valley Pastures #8', 'farmer', 'active', NULL, '$2y$12$ZfXWmoLUR2GJ8TYAkhF/lO6/ytgKAVITszoCaUe2IgdvqOzc.8Kgy', NULL, '2026-09-26 15:36:12', '2026-09-26 15:36:12');

--
-- Structure for table `password_reset_tokens`
--
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Structure for table `sessions`
--
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Structure for table `markets`
--
DROP TABLE IF EXISTS `markets`;
CREATE TABLE `markets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `market_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Springfield',
  `operating_days` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timings` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `map_provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OpenStreetMap',
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `markets_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `markets`
--
INSERT INTO `markets` (`id`, `market_name`, `slug`, `address`, `city`, `operating_days`, `timings`, `latitude`, `longitude`, `map_provider`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Downtown Central Farmers Market', 'downtown-central-farmers-market', '100 Market St, Civic Plaza', 'Springfield', 'Saturday & Sunday', '07:30 AM - 02:00 PM', '37.77492900', '-122.41941600', 'OpenStreetMap', 'The largest weekend market in town featuring over 40 local growers, artisanal bakers, live acoustic music, and pre-order express pickup stalls.', 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=800&q=80', '1', '2026-09-26 15:36:10', '2026-09-26 15:36:10');
INSERT INTO `markets` (`id`, `market_name`, `slug`, `address`, `city`, `operating_days`, `timings`, `latitude`, `longitude`, `map_provider`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Riverside Green Square Market', 'riverside-green-square-market', '45 Riverbank Promenade', 'Springfield', 'Wednesday & Saturday', '08:00 AM - 01:30 PM', '37.78330000', '-122.41670000', 'OpenStreetMap', 'Scenic waterfront market specializing in fresh berries, crisp greens, seasonal orchards, and handmade organic cheeses.', 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80', '1', '2026-09-26 15:36:10', '2026-09-26 15:36:10');
INSERT INTO `markets` (`id`, `market_name`, `slug`, `address`, `city`, `operating_days`, `timings`, `latitude`, `longitude`, `map_provider`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Westside Community Pavilion', 'westside-community-pavilion', '820 Sunset Boulevard', 'Springfield', 'Tuesday & Friday', '08:30 AM - 02:30 PM', '37.76500000', '-122.44300000', 'OpenStreetMap', 'Convenient weekday pickup destination with dedicated curbside pre-order parking stalls and organic produce certs.', 'https://images.unsplash.com/photo-1519999482648-25049ddd37b1?auto=format&fit=crop&w=800&q=80', '1', '2026-09-26 15:36:10', '2026-09-26 15:36:10');
INSERT INTO `markets` (`id`, `market_name`, `slug`, `address`, `city`, `operating_days`, `timings`, `latitude`, `longitude`, `map_provider`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES ('4', 'East Bay Harvest Fair', 'east-bay-harvest-fair', '312 Grand Meadow Blvd', 'Springfield', 'Sunday', '08:00 AM - 03:00 PM', '37.80440000', '-122.27120000', 'OpenStreetMap', 'A lively Sunday family festival with farm-fresh produce, sourdough breads, clover honeys, and dairy reserves.', 'https://images.unsplash.com/photo-1506484381205-f7945653044d?auto=format&fit=crop&w=800&q=80', '1', '2026-09-26 15:36:10', '2026-09-26 15:36:10');

--
-- Structure for table `farmer_profiles`
--
DROP TABLE IF EXISTS `farmer_profiles`;
CREATE TABLE `farmer_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `market_id` bigint unsigned DEFAULT NULL,
  `stall_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stall_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `operating_days` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Saturday, Sunday',
  `pickup_windows` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cutoff_hours_before` int NOT NULL DEFAULT '12',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `farmer_profiles_user_id_foreign` (`user_id`),
  KEY `farmer_profiles_market_id_foreign` (`market_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `farmer_profiles`
--
INSERT INTO `farmer_profiles` (`id`, `user_id`, `market_id`, `stall_name`, `stall_number`, `contact_person`, `contact_number`, `address`, `operating_days`, `pickup_windows`, `cutoff_hours_before`, `latitude`, `longitude`, `bio`, `avatar`, `is_approved`, `created_at`, `updated_at`) VALUES ('1', '5', '1', 'Sunny Valley Organics', 'Stall A-14 (North Wing)', 'John & Clara Green', '+1 (555) 789-0123', '100 Market St, Stall A-14, Springfield', 'Saturday & Sunday', '08:00 AM - 10:00 AM, 10:00 AM - 12:00 PM, 12:00 PM - 02:00 PM', '12', '37.77492900', '-122.41941600', 'Third-generation regenerative family farm dedicated to pesticide-free heirloom vegetables, greenhouse greens, and vine-ripened tomatoes.', 'https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=400&q=80', '1', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `farmer_profiles` (`id`, `user_id`, `market_id`, `stall_name`, `stall_number`, `contact_person`, `contact_number`, `address`, `operating_days`, `pickup_windows`, `cutoff_hours_before`, `latitude`, `longitude`, `bio`, `avatar`, `is_approved`, `created_at`, `updated_at`) VALUES ('2', '6', '2', 'Riverbend Berry & Orchard Farm', 'Stall B-03 (Riverside Pier)', 'Elena Vance', '+1 (555) 890-1234', '45 Riverbank Promenade, Stall B-03', 'Wednesday & Saturday', '08:30 AM - 10:30 AM, 10:30 AM - 12:30 PM, 12:30 PM - 01:30 PM', '8', '37.78330000', '-122.41670000', 'Nestled alongside the mountain river, we cultivate the sweetest strawberries, plump blueberries, crisp heritage apples, and artisan ciders.', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&q=80', '1', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `farmer_profiles` (`id`, `user_id`, `market_id`, `stall_name`, `stall_number`, `contact_person`, `contact_number`, `address`, `operating_days`, `pickup_windows`, `cutoff_hours_before`, `latitude`, `longitude`, `bio`, `avatar`, `is_approved`, `created_at`, `updated_at`) VALUES ('3', '7', '3', 'Highland Natural Apiaries & Honey', 'Stall W-07', 'Carlos Rodriguez', '+1 (555) 901-2345', '820 Sunset Boulevard, Westside Pavilion', 'Tuesday & Friday', '09:00 AM - 11:00 AM, 11:00 AM - 01:00 PM, 01:00 PM - 02:30 PM', '10', '37.76500000', '-122.44300000', 'Pure wildflower raw honeys, organic beeswax candles, royal jelly, and hand-jarred berry preserves produced with ethical bee-keeping.', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80', '1', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `farmer_profiles` (`id`, `user_id`, `market_id`, `stall_name`, `stall_number`, `contact_person`, `contact_number`, `address`, `operating_days`, `pickup_windows`, `cutoff_hours_before`, `latitude`, `longitude`, `bio`, `avatar`, `is_approved`, `created_at`, `updated_at`) VALUES ('4', '8', '1', 'Artisan Grove Sourdough & Hearth', 'Stall S-02 (Bakery Canopy)', 'Maria & Luke Chen', '+1 (555) 012-3456', '100 Market St, Stall S-02, Springfield', 'Saturday & Sunday', '07:30 AM - 09:30 AM, 09:30 AM - 11:30 AM, 11:30 AM - 01:30 PM', '14', '37.77492900', '-122.41941600', 'Naturally leavened organic artisan sourdough, 100% stone-milled whole grain country loaves, rosemary focaccia, and butter croissants baked at dawn.', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80', '1', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `farmer_profiles` (`id`, `user_id`, `market_id`, `stall_name`, `stall_number`, `contact_person`, `contact_number`, `address`, `operating_days`, `pickup_windows`, `cutoff_hours_before`, `latitude`, `longitude`, `bio`, `avatar`, `is_approved`, `created_at`, `updated_at`) VALUES ('5', '9', '4', 'Green Meadow Dairy & Pastures', 'Stall E-08 (East Pavilion)', 'David Miller', '+1 (555) 123-9876', '312 Grand Meadow Blvd, East Bay Fair', 'Sunday', '08:00 AM - 10:30 AM, 10:30 AM - 01:00 PM, 01:00 PM - 03:00 PM', '12', '37.80440000', '-122.27120000', 'Certified organic dairy pasture producing whole non-homogenized A2 milk, hand-pressed herb jack cheeses, and golden pasture-raised eggs.', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80', '1', '2026-09-26 15:36:12', '2026-09-26 15:36:12');

--
-- Structure for table `categories`
--
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'leaf',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `image`, `description`, `created_at`, `updated_at`) VALUES ('1', 'Organic Vegetables', 'vegetables', 'carrot', 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80', 'Field-grown crisp carrots, heirloom tomatoes, fresh leafy greens, and pesticide-free root crops.', '2026-09-26 15:36:10', '2026-09-26 15:36:10');
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `image`, `description`, `created_at`, `updated_at`) VALUES ('2', 'Fresh Orchard Fruits', 'fruits', 'apple-alt', 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?auto=format&fit=crop&w=600&q=80', 'Sun-ripened berries, crisp gala apples, sweet peaches, and citrus fresh from the orchard trees.', '2026-09-26 15:36:10', '2026-09-26 15:36:10');
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `image`, `description`, `created_at`, `updated_at`) VALUES ('3', 'Farmstead Dairy & Eggs', 'dairy', 'cheese', 'https://images.unsplash.com/photo-1528751014936-863e6e7a319c?auto=format&fit=crop&w=600&q=80', 'Grass-fed whole milk, cultured churned butter, artisan aged cheddar, and free-range pastured eggs.', '2026-09-26 15:36:10', '2026-09-26 15:36:10');
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `image`, `description`, `created_at`, `updated_at`) VALUES ('4', 'Artisanal Bakery & Breads', 'baked-goods', 'bread-slice', 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=600&q=80', 'Slow-fermented wild sourdough loaves, flaky morning brioche, and rustic grain baguettes.', '2026-09-26 15:36:10', '2026-09-26 15:36:10');
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `image`, `description`, `created_at`, `updated_at`) VALUES ('5', 'Fresh Herbs & Spices', 'herbs', 'seedling', 'https://images.unsplash.com/photo-1509358271058-acd22cc93898?auto=format&fit=crop&w=600&q=80', 'Aromatic sweet genovese basil, garden rosemary, curly parsley, and dried ground seasoning.', '2026-09-26 15:36:10', '2026-09-26 15:36:10');
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `image`, `description`, `created_at`, `updated_at`) VALUES ('6', 'Raw Honey & Fruit Preserves', 'preserves-honey', 'jar', 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=600&q=80', 'Unpasteurized wildflower honeycomb honey, seasonal strawberry jam, and spiced apple butter.', '2026-09-26 15:36:10', '2026-09-26 15:36:10');

--
-- Structure for table `products`
--
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `farmer_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kg',
  `stock_quantity` int NOT NULL DEFAULT '0',
  `is_sold_out` tinyint(1) NOT NULL DEFAULT '0',
  `is_weekly_template` tinyint(1) NOT NULL DEFAULT '0',
  `harvest_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_farmer_id_foreign` (`farmer_id`),
  KEY `products_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('1', '1', '1', 'Organic Heirloom Vine Tomatoes', 'organic-heirloom-vine-tomatoes', 'Sweet, juicy, multi-colored heirloom tomatoes harvested fresh this morning. Perfect for Caprese salads and roasting.', '4.50', 'kg', '45', '0', '1', 'Harvested 24 hrs prior to market', 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('2', '1', '1', 'Crisp Rainbow Sweet Carrots', 'crisp-rainbow-sweet-carrots', 'Crunchy bunches of purple, yellow, and orange organic baby carrots with leafy greens intact.', '3.20', 'bunch', '60', '0', '1', 'Fresh harvest every Friday', 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('3', '1', '1', 'Hydroponic Butterhead Green Lettuce', 'hydroponic-butterhead-green-lettuce', 'Tender, velvety living lettuce heads packaged with live roots for long-lasting crispness in your fridge.', '2.80', 'head', '30', '0', '1', 'Picked daily', 'https://images.unsplash.com/photo-1556801712-76c8eb07bbc9?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('4', '1', '5', 'Fresh Genovese Sweet Basil', 'fresh-genovese-sweet-basil', 'Fragrant, broad Italian basil leaves with sweet peppery notes. Ideal for homemade pesto and tomato pairings.', '2.50', 'bunch', '25', '0', '1', 'Harvested at morning dew', 'https://images.unsplash.com/photo-1618375531912-867984bdfd87?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('5', '2', '2', 'Sweet Mountain Strawberries', 'sweet-mountain-strawberries', 'Intensely sweet, red-to-the-core alpine strawberries grown under cool morning river mists.', '5.50', 'pint box', '50', '0', '1', 'Hand-picked yesterday', 'https://images.unsplash.com/photo-1518635017498-87f514b751ba?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('6', '2', '2', 'Organic Plump Blueberries', 'organic-plump-blueberries', 'Antioxidant-packed sweet blueberries with natural silver bloom. Firm, juicy, and freshly sorted.', '6.00', 'basket', '35', '0', '1', 'Fresh morning harvest', 'https://images.unsplash.com/photo-1498557850523-fd3d118b962e?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('7', '2', '2', 'Crisp Honeycrisp Orchard Apples', 'crisp-honeycrisp-orchard-apples', 'Unwaxed, balanced sweet-tart Honeycrisp apples fresh from Riverbend century-old orchard trees.', '4.20', 'kg', '70', '0', '1', 'Picked this week', 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('8', '3', '6', 'Raw Wildflower Meadow Honey', 'raw-wildflower-meadow-honey', 'Pure unpasteurized honey rich in natural pollens and enzymes. Golden amber flavor with delicate floral undertones.', '9.50', '500g jar', '40', '0', '1', 'Late Summer Harvest', 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('9', '3', '6', 'Artisan Strawberry Thyme Jam', 'artisan-strawberry-thyme-jam', 'Handcrafted small-batch fruit preserves cooked in copper kettles with organic cane sugar and garden thyme.', '7.00', '250ml jar', '28', '0', '1', 'Artisan batched weekly', 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('10', '4', '4', 'San Francisco Style Country Sourdough', 'san-francisco-style-country-sourdough', '36-hour slow cold fermentation loaf with blistered crust, open airy crumb, and signature tangy flavor.', '6.50', 'loaf (800g)', '35', '0', '1', 'Baked dawn of market day', 'https://images.unsplash.com/photo-1589367920969-ab8e050bbb04?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('11', '4', '4', 'Rosemary Sea Salt Olive Oil Focaccia', 'rosemary-sea-salt-focaccia', 'Fluffy, pillowy focaccia dimpled with cold-pressed olive oil, Maldon flaked sea salt, and fresh garden rosemary.', '5.00', 'slab', '20', '0', '1', 'Baked dawn of market day', 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('12', '4', '4', 'French Pure Butter Morning Croissants', 'french-pure-butter-morning-croissants', 'Traditional 27-layer laminated puff pastry croissants made with cultured European butter.', '4.00', 'pack of 2', '25', '0', '1', 'Baked dawn of market day', 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('13', '5', '3', 'Farmstead Aged Herb Jack Cheese', 'farmstead-aged-herb-jack-cheese', 'Handmade raw milk Monterey Jack aged 6 months, infused with garden chives, garlic, and cracked pepper.', '8.50', '250g wedge', '30', '0', '1', 'Aged 180 days', 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('14', '5', '3', 'Pasture-Raised Organic Farm Eggs', 'pasture-raised-organic-farm-eggs', 'Rich, deep-orange yolks from hens foraging freely on clover and alfalfa fields under open skies.', '6.00', 'dozen', '50', '0', '1', 'Collected daily', 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock_quantity`, `is_sold_out`, `is_weekly_template`, `harvest_date`, `image`, `created_at`, `updated_at`) VALUES ('15', '5', '3', 'Cultured Churned Sweet Cream Butter', 'cultured-churned-sweet-cream-butter', 'Slow-churned 84% butterfat pasture butter lightly finished with fleur de sel. Incredibly rich and creamy.', '5.50', '250g block', '25', '0', '1', 'Churned every Thursday', 'https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?auto=format&fit=crop&w=600&q=80', '2026-09-26 15:36:12', '2026-09-26 15:36:12');

--
-- Structure for table `orders`
--
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `farmer_id` bigint unsigned NOT NULL,
  `market_id` bigint unsigned DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time_slot` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` enum('placed','accepted','ready_for_pickup','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'placed',
  `payment_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pay at Pickup (Cash/Card)',
  `customer_notes` text COLLATE utf8mb4_unicode_ci,
  `farmer_notes` text COLLATE utf8mb4_unicode_ci,
  `cutoff_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_farmer_id_foreign` (`farmer_id`),
  KEY `orders_market_id_foreign` (`market_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--
INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `farmer_id`, `market_id`, `total_amount`, `pickup_date`, `pickup_time_slot`, `order_status`, `payment_status`, `customer_notes`, `farmer_notes`, `cutoff_time`, `created_at`, `updated_at`) VALUES ('1', 'ML-2026-9001', '2', '1', '1', '14.70', '2026-09-28', '08:00 AM - 10:00 AM', 'accepted', 'Pay at Pickup (Cash/Card)', 'Please pick ripe red tomatoes, we are hosting Sunday lunch!', 'Reserved our finest beefsteaks for you!', '2026-09-27 20:00:00', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `farmer_id`, `market_id`, `total_amount`, `pickup_date`, `pickup_time_slot`, `order_status`, `payment_status`, `customer_notes`, `farmer_notes`, `cutoff_time`, `created_at`, `updated_at`) VALUES ('2', 'ML-2026-9002', '2', '4', '1', '15.50', '2026-09-28', '09:30 AM - 11:30 AM', 'ready_for_pickup', 'Pay at Pickup (Cash/Card)', 'Looking forward to the warm sourdough loaf.', 'Your loaf has been marked and bagged with love!', '2026-09-27 18:00:00', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `farmer_id`, `market_id`, `total_amount`, `pickup_date`, `pickup_time_slot`, `order_status`, `payment_status`, `customer_notes`, `farmer_notes`, `cutoff_time`, `created_at`, `updated_at`) VALUES ('3', 'ML-2026-8940', '2', '2', '2', '17.50', '2026-09-21', '10:30 AM - 12:30 PM', 'completed', 'Paid in Cash at Stall', 'Strawberries were phenomenal!', 'Thank you Sarah!', '2026-09-20 20:00:00', '2026-09-26 15:36:12', '2026-09-26 15:36:12');

--
-- Structure for table `order_items`
--
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES ('1', '1', '1', '2', '4.50', '9.00', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES ('2', '1', '2', '1', '3.20', '3.20', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES ('3', '1', '4', '1', '2.50', '2.50', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES ('4', '2', '10', '1', '6.50', '6.50', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES ('5', '2', '11', '1', '5.00', '5.00', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES ('6', '2', '12', '1', '4.00', '4.00', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES ('7', '3', '5', '2', '5.50', '11.00', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES ('8', '3', '6', '1', '6.00', '6.00', '2026-09-26 15:36:12', '2026-09-26 15:36:12');

--
-- Structure for table `reviews`
--
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `farmer_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `rating` tinyint NOT NULL DEFAULT '5',
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `farmer_reply` text COLLATE utf8mb4_unicode_ci,
  `farmer_replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_customer_id_foreign` (`customer_id`),
  KEY `reviews_farmer_id_foreign` (`farmer_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_order_id_foreign` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--
INSERT INTO `reviews` (`id`, `customer_id`, `farmer_id`, `product_id`, `order_id`, `rating`, `comment`, `farmer_reply`, `farmer_replied_at`, `created_at`, `updated_at`) VALUES ('1', '2', '2', '5', '3', '5', 'The mountain strawberries were the sweetest we have ever tasted. Pre-ordering made pickup completely hassle-free with zero line waiting!', 'Thank you Sarah! So thrilled your family enjoyed them. Looking forward to seeing you this Saturday!', '2026-09-22 15:36:12', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `reviews` (`id`, `customer_id`, `farmer_id`, `product_id`, `order_id`, `rating`, `comment`, `farmer_reply`, `farmer_replied_at`, `created_at`, `updated_at`) VALUES ('2', '3', '1', '1', NULL, '5', 'Incredible heirloom tomatoes! You can truly taste the difference of fresh farm harvest compared to supermarket produce.', 'We take great pride in our composted soil nutrients! Appreciate your review Michael!', '2026-09-24 15:36:12', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `reviews` (`id`, `customer_id`, `farmer_id`, `product_id`, `order_id`, `rating`, `comment`, `farmer_reply`, `farmer_replied_at`, `created_at`, `updated_at`) VALUES ('3', '4', '4', '10', NULL, '5', 'The crust on the sourdough was crispy, deep golden, and the crumb had the most amazing fermented aroma. Will pre-order every week!', 'Hearing this makes early 3 AM baking shifts completely worth it! Thank you Emily!', '2026-09-25 15:36:12', '2026-09-26 15:36:12', '2026-09-26 15:36:12');

--
-- Structure for table `favorites`
--
DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `favoritable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favoritable_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `favorites_user_id_favoritable_type_favoritable_id_unique` (`user_id`,`favoritable_type`,`favoritable_id`),
  KEY `favorites_favoritable_type_favoritable_id_index` (`favoritable_type`,`favoritable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--
INSERT INTO `favorites` (`id`, `user_id`, `favoritable_type`, `favoritable_id`, `created_at`, `updated_at`) VALUES ('1', '2', 'App\\Models\\Product', '1', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `favorites` (`id`, `user_id`, `favoritable_type`, `favoritable_id`, `created_at`, `updated_at`) VALUES ('2', '2', 'App\\Models\\FarmerProfile', '1', '2026-09-26 15:36:12', '2026-09-26 15:36:12');

--
-- Structure for table `announcements`
--
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint unsigned NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_role` enum('all','customer','farmer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcements_admin_id_foreign` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--
INSERT INTO `announcements` (`id`, `admin_id`, `title`, `message`, `target_role`, `is_active`, `created_at`, `updated_at`) VALUES ('1', '1', 'Welcome to the New Harvest Season & MarketLink Launch!', 'We are excited to launch MarketLink across Springfield! Reserve your weekly farm baskets, avoid the sellouts, and pick up fresh at your local stalls.', 'all', '1', '2026-09-26 15:36:12', '2026-09-26 15:36:12');
INSERT INTO `announcements` (`id`, `admin_id`, `title`, `message`, `target_role`, `is_active`, `created_at`, `updated_at`) VALUES ('2', '1', 'Downtown Market Saturday Pre-Order Cutoff: Friday 8:00 PM', 'Dear Customers, remember to place your weekend pre-orders before Friday 8 PM so our local farmers can harvest and pack your fresh orders.', 'customer', '1', '2026-09-26 15:36:12', '2026-09-26 15:36:12');

--
-- Structure for table `reports`
--
DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `generated_by` bigint unsigned NOT NULL,
  `report_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_generated_by_foreign` (`generated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--
INSERT INTO `reports` (`id`, `generated_by`, `report_type`, `title`, `summary`, `data`, `created_at`, `updated_at`) VALUES ('1', '1', 'sales_summary', 'Market Performance & Pre-Order Volume Summary Q3', 'Platform aggregated 487 pre-orders across 4 regional markets, driving $12,480 in direct farm revenue with 0% packaging waste.', '{\"total_orders\": 487, \"total_revenue\": 12480, \"active_farmers\": 5, \"active_customers\": 128, \"top_selling_categories\": [\"Vegetables\", \"Baked Goods\", \"Berries\", \"Dairy\"]}', '2026-09-26 15:36:12', '2026-09-26 15:36:12');

--
-- Structure for table `cache`
--
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Structure for table `cache_locks`
--
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Structure for table `jobs`
--
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Structure for table `job_batches`
--
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Structure for table `failed_jobs`
--
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Structure for table `migrations`
--
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_09_26_000001_create_markets_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_09_26_000002_create_farmer_profiles_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_09_26_000003_create_categories_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_09_26_000004_create_products_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_09_26_000005_create_orders_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_09_26_000006_create_order_items_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_09_26_000007_create_reviews_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_09_26_000008_create_favorites_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_09_26_000009_create_announcements_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('13', '2026_09_26_000010_create_reports_table', '1');

SET FOREIGN_KEY_CHECKS = 1;
