-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2024 at 04:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rk_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `status` enum('active','disabled') DEFAULT 'active',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fname`, `lname`, `status`, `email`, `password`) VALUES
(1, 'Biju', 'Aryal', 'active', 'bijuaryal17@gmail.com', '67910565b6a5a6fefbb514e8248ae0a7'),
(2, 'Reeya', 'Ramudamu', 'active', 'reeyaramudamu@gmail.com', '67910565b6a5a6fefbb514e8248ae0a7'),
(3, 'Sailesh', 'Acharya', 'active', 'saileshacharya1229@gmail.com', '67910565b6a5a6fefbb514e8248ae0a7');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `discount`, `created_at`, `updated_at`) VALUES
(1, 9, 0, '2024-09-05 14:38:58', '2024-09-10 10:08:46'),
(2, 1, 0, '2024-09-05 15:46:53', '2024-09-11 08:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `price`, `total_price`) VALUES
(66, 1, 19, 1, 11104.00, 11104.00),
(67, 1, 22, 1, 0.00, NULL),
(68, 1, 15, 1, 0.00, NULL),
(69, 1, 23, 1, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(2, 'Necklaces', 'Neck Jewellery'),
(3, 'Ring', 'Finger Jewellery'),
(4, 'Bracelet', 'Hand Jewellery'),
(6, 'Earrings', 'Ear Jewellery'),
(7, 'Armlet', 'Arm Jewellery'),
(8, 'Bangle', 'Hand Jewellery'),
(9, 'Pendant', 'Neck Jewellery'),
(10, 'Gold', 'Gold'),
(11, 'Diamond', 'Diamond'),
(12, 'Locket', 'Locket'),
(13, 'Brooch', 'Brooch'),
(14, 'Hairpin', 'Hairpin'),
(15, 'Spoon', 'Spoon');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','delivered','cancelled','dispatched') DEFAULT 'pending',
  `total_amount` decimal(10,0) NOT NULL,
  `shipping_address` text NOT NULL,
  `billing_address` text NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('paid','pending','failed') DEFAULT 'pending',
  `tracking_number` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `status`, `total_amount`, `shipping_address`, `billing_address`, `payment_method`, `payment_status`, `tracking_number`, `created_at`, `updated_at`) VALUES
(27, 9, '2024-09-06 11:37:05', 'delivered', 25303, 'h', 'h', 'stripe', 'paid', 'TAYEH0FH18US', '2024-09-06 11:37:05', '2024-09-11 14:15:29'),
(28, 9, '2024-09-06 11:42:45', 'confirmed', 64553, 'h', 'h', 'stripe', 'paid', 'WCU73MHCWCFE', '2024-09-06 11:42:45', '2024-09-11 09:08:13'),
(29, 9, '2024-09-06 11:59:48', 'confirmed', 113753, 'h', 'h', 'stripe', 'paid', 'WPTQLQTLLPY1', '2024-09-06 11:59:48', '2024-09-11 09:11:19'),
(30, 9, '2024-09-10 10:08:46', 'confirmed', 100186, 'h', 'h', 'stripe', 'paid', 'YQW5WJGVG71V', '2024-09-10 10:08:46', '2024-09-11 09:11:30'),
(31, 1, '2024-09-10 18:46:39', 'confirmed', 25403, 'Hetauda - 07, Makwanpur', 'Hetauda - 07, Makwanpur', 'cod', 'paid', '8QCJHUXFH2VO', '2024-09-10 18:46:39', '2024-09-11 14:14:29'),
(32, 1, '2024-09-10 18:50:59', 'confirmed', 41194, 'Hetauda - 07, Makwanpur', 'Hetauda - 07, Makwanpur', 'stripe', 'paid', '8S2ZD29K0TZ1', '2024-09-10 18:50:59', '2024-09-11 14:14:53'),
(33, 1, '2024-09-11 08:18:06', 'confirmed', 652788, 'Hetauda - 07, Makwanpur', 'Hetauda - 07, Makwanpur', 'stripe', 'paid', 'B4K6I61UQTY9', '2024-09-11 08:18:06', '2024-09-11 08:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `total_price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `total_price`) VALUES
(28, 27, 18, 1, 25403, 25403),
(29, 28, 11, 1, 48428, 48428),
(30, 28, 22, 1, 16225, 16225),
(31, 29, 10, 2, 50000, 100000),
(32, 29, 19, 1, 11104, 11104),
(33, 29, 21, 1, 2649, 2649),
(34, 30, 17, 1, 100196, 100196),
(35, 31, 18, 1, 25403, 25403),
(36, 32, 16, 1, 41194, 41194),
(37, 33, 17, 6, 100196, 601176),
(38, 33, 18, 4, 25403, 101612);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('paid','pending','failed') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `payment_status`, `transaction_id`, `amount`, `payment_date`) VALUES
(10, 27, 'stripe', 'paid', 'TXN-66dae9af6a05e3.61452456', 189, '2024-09-06 11:38:23'),
(11, 28, 'stripe', 'paid', 'TXN-66daead0409f93.99332269', 64553, '2024-09-06 11:43:12'),
(12, 29, 'stripe', 'paid', 'TXN-66daeed494d198.84277964', 113753, '2024-09-06 12:00:20'),
(13, 30, 'stripe', 'paid', 'TXN-66e01ace7c3f93.48423822', 100186, '2024-09-10 10:09:18'),
(14, 32, 'stripe', 'paid', 'TXN-66e0953a5be367.20802920', 41194, '2024-09-10 18:51:38'),
(15, 33, 'stripe', 'paid', 'TXN-66e15264d90e34.50584248', 652788, '2024-09-11 08:18:44'),
(16, 31, 'cod', 'paid', 'TXN-66e15d94c789d8.97755935', 25403, '2024-09-11 05:21:28');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `material` varchar(255) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `main_image_url` varchar(255) DEFAULT NULL,
  `small_images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `short_description`, `long_description`, `category_id`, `price`, `material`, `weight`, `main_image_url`, `small_images`, `stock_quantity`, `created_at`, `updated_at`) VALUES
(10, 'Zyair Gold Chain', 'Zyair Gold Chain', 'This exquisite piece of jewelry seamlessly blends classic design with contemporary elegance, making it a must-have addition to any collection.', 2, 50000, 'Diamond', 11.63, 'productImageb814eb6fe4d2bef05c1b122ce517_1725378046.jpeg', '1_1725378046.png,2_1725378046.jpeg', 50, '2024-09-03 15:40:46', '2024-09-08 12:45:34'),
(11, 'Classic Gold Locket', 'Beautiful Zarkon Stone Classic Gold Locket', 'Embark on a journey of timeless sophistication with our breathtaking Zarkon Stone Classic Gold Locket. Inspired by the allure of celestial beauty and crafted with meticulous attention to detail, this exquisite piece epitomizes luxury and refinement.', 12, 48428, 'Gold', 3.39, 'productImage8de91970e702d96a82276012367c_1725524685.jpg', '1_1725524685.jpg,2_1725524685.jpg,3_1725524685.jpg', 50, '2024-09-05 08:24:45', '2024-09-08 12:45:34'),
(12, 'Ruby Gold Necklace', 'Timeless beauty and sophistication', 'The Ruby Necklace features a classic and elegant design, making it a versatile piece that complements any outfit. Whether worn daily or reserved for special occasions, this ring adds a touch of sophistication to your look.', 2, 153295, 'Gold', 11.37, 'productImage6a8acc4a3b9302b7c5db8645f9ae_1725524756.jpeg', '1_1725524756.jpeg', 50, '2024-09-05 08:25:56', '2024-09-08 12:45:34'),
(13, 'Trilogy Diamond Ring', 'Luxurious band', 'Elevate your elegance with our stunning Trilogy Diamond Ring, a timeless symbol of past, present, and future. This exquisite piece features three dazzling diamonds, meticulously set in a classic and elegant design.', 3, 102488, 'Diamond', 4.96, 'productImaged2128db560c0c490e273f5f74863_1725524844.jpeg', '1_1725524844.jpeg', 50, '2024-09-05 08:27:24', '2024-09-08 12:45:34'),
(14, 'Six Diamond Ring', 'Beautiful Emerald Diamond Ring', 'Encircling the central emerald are sparkling round-cut diamonds, meticulously set to amplify the ring\'s overall brilliance. These diamonds create a stunning contrast with the emerald, enhancing its vivid color and adding a touch of glamour.', 3, 54942, 'Diamond, Emerald', 2.15, 'productImage1e03334179906baaa04f753d9a6f_1725524936.jpg', '1_1725524936.jpg,2_1725524936.jpg,3_1725524936.jpg', 50, '2024-09-05 08:28:56', '2024-09-08 12:45:34'),
(15, 'Radiant Rose Sun Brooch', 'Versatile accessory for any outfit.', 'The brooch comes in an elegant gift box, making it an ideal present for birthdays, anniversaries, Mother\'s Day, or any other special occasion. Delight your loved ones with a gift that is both meaningful and beautiful.', 13, 8000, 'Diamond', 11.63, 'productImage2bd44bfb78a05e3906bc59b17ec0_1725524992.jpg', '1_1725524992.jpg', 50, '2024-09-05 08:29:52', '2024-09-08 12:45:34'),
(16, 'Low weight Bangle', 'Low weight Bangle', 'What an amazingly handcrafted gold bangle made with love from our expert karigars in very low weight. Imaging wearing this in solid gold which cost you 4 times higher. This bangle can make you feel that right away.', 8, 41194, 'Gold', 2.58, 'productImage75e100b5d456891b421c9cf64b8c_1725525079.jpg', '1_1725525079.jpg', 49, '2024-09-05 08:31:19', '2024-09-10 18:50:59'),
(17, 'Maeve Gold Earring', 'sleek and minimalist design', 'Perfect for both casual and formal occasions, these earrings effortlessly elevate your style with their understated charm and timeless allure.', 6, 100196, 'Gold', 6.92, 'productImagee82cc3574c68fb8e1e4ac1831306_1725525150.jpg', '1_1725525150.jpg', 43, '2024-09-05 08:32:30', '2024-09-11 08:18:06'),
(18, 'Nikita Gold Tilahari', 'Touch of luxury', 'This exquisite piece of art embodies the perfect blend of traditional craftsmanship and contemporary design, making it an essential addition to any sophisticated wardrobe.', 2, 25403, 'Gold', 1.60, 'productImagea562bc2184f23af438f0381d323a_1725526176.jpg', '1_1725526176.jpg,2_1725526176.jpg', 45, '2024-09-05 08:49:36', '2024-09-11 08:18:06'),
(19, 'Levi Gold Hairpin', 'touch of sophistication', 'The Levi hairpin is meticulously crafted from pure 24K gold, boasting a brilliant luster that captures the essence of opulence. Its design features intricate patterns and delicate engravings, showcasing the artisan\'s exceptional skill and attention to detail. The harmonious blend of classic and contemporary elements ensures that each hairpin is a unique work of art, making a statement of timeless beauty.', 14, 11104, 'Gold', 0.52, 'productImage8d21faa7b1c484d1b722c4561ccf_1725528260.jpg', '1_1725528260.jpg,2_1725528260.jpg,3_1725528260.jpg', 50, '2024-09-05 09:24:20', '2024-09-08 12:45:34'),
(20, 'Neha Gold Mala', 'lustrous shine', 'The Neha Gold Mala is designed to be versatile, making it suitable for various occasions. Whether you\'re attending a wedding, a festive celebration, or a formal event, this mala adds a touch of sophistication to your attire. Its elegant design makes it a perfect match for traditional outfits like sarees and lehengas, as well as modern ensembles.', 2, 18893, 'Gold', 0.91, 'productImaged6f77682a0285f24c0d6e7f6e051_1725528368.jpeg', '1_1725528368.jpeg,2_1725528368.jpeg', 50, '2024-09-05 09:26:08', '2024-09-08 12:45:34'),
(21, 'Silver Spoon', 'antibacterial properties', 'The silver spoon in the Pasni ceremony is more than just a utensil; it is a symbol of purity, health, and tradition. It represents the family\'s love, blessings, and hopes for the child\'s bright future. As you prepare for this significant celebration, choosing a beautiful and high-quality silver spoon can add a touch of elegance and meaning to the ritual, creating memories that will last a lifetime.', 15, 2649, 'Silver', 11.66, 'productImage90517676ca6e9535ea7860041c0d_1725528466.png', '1_1725528466.png,2_1725528466.png', 50, '2024-09-05 09:27:46', '2024-09-08 12:45:34'),
(22, 'Opal Gold Hairpin', 'truly unique', 'Our opal gold hairpin is designed to complement a variety of hairstyles, adding a touch of sophistication and charm. Whether adorning an elegant updo for a formal event or adding a subtle sparkle to a casual look, this hairpin is a versatile accessory that enhances any outfit. Its timeless design ensures it remains a cherished piece in your jewelry collection.', 14, 16225, 'Gold', 0.78, 'productImagef506300211e23e70ca362a557e18_1725528634.jpg', '1_1725528634.jpg,2_1725528634.jpg,3_1725528634.jpg', 50, '2024-09-05 09:30:34', '2024-09-08 12:45:34'),
(23, 'Darshit Gold Chain', 'Meticulously crafted', 'Elevate your style with the exquisite Darshit Gold Chain, a testament to craftsmanship and luxury. Meticulously crafted from the finest materials, this timeless piece combines classic design with contemporary flair, making it a versatile addition to any jewelry collection.', 2, 165037, 'Gold', 11.95, 'productImage89eeb038a7902ca0ea0e117c8e96_1725528761.png', '1_1725528761.jpeg,2_1725528761.png,3_1725528761.png', 50, '2024-09-05 09:32:41', '2024-09-08 12:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `redeemcode`
--

CREATE TABLE `redeemcode` (
  `code_Id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `visibility` enum('public','private') DEFAULT 'public',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL,
  `remaining_Usage` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `redeemcode`
--

INSERT INTO `redeemcode` (`code_Id`, `code`, `price`, `visibility`, `created_at`, `expires_at`, `remaining_Usage`) VALUES
(1, 'SAVE100', 100, 'private', '2024-09-04 13:55:48', '2024-09-26 14:29:58', 2),
(2, 'SALE10000', 10000, 'private', '2024-09-04 14:26:01', '2024-09-11 14:30:06', 50),
(3, 'REEYA50', 50, 'public', '2024-09-04 14:32:16', '2024-09-16 10:47:16', 5),
(4, 'BIJU', 1000000, 'public', '2024-09-06 10:30:00', '2024-09-07 06:45:00', 476),
(5, 'REEYA', 10, 'public', '2024-09-09 17:37:19', '2024-09-24 17:36:55', 49),
(6, 'HANUMANKIND', 50000, 'private', '2024-09-10 18:17:04', '2024-09-25 14:32:04', 18);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `status` enum('active','disabled') DEFAULT 'active',
  `verification` enum('verified','unverified') DEFAULT 'unverified',
  `verification_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `profile_pic`, `email`, `password`, `phone_number`, `address`, `street`, `apartment`, `city`, `status`, `verification`, `verification_token`, `created_at`, `updated_at`) VALUES
(1, 'Reeya', 'Ramudamu', 'default.jpg', 'reeyaramudamu@gmail.com', '67910565b6a5a6fefbb514e8248ae0a7', '9821823397', 'Hetauda - 07, Makwanpur', 'Kantirajpath', '', 'Hetauda', 'active', 'verified', NULL, '2024-09-03 15:55:59', '2024-09-10 18:50:59'),
(9, 'Biju ', 'Aryal', 'profile_1725907422.png', 'bijuaryal17@gmail.com', '67910565b6a5a6fefbb514e8248ae0a7', '9845405351', 'Hetauda - 07, Makwanpur', 'Kantirajpath', '', 'Hetauda', 'active', 'verified', NULL, '2024-09-05 09:50:55', '2024-09-10 11:10:10'),
(14, 'Bijay', 'Aryal', 'default.jpg', 'bijayaryal60@gmail.com', '67910565b6a5a6fefbb514e8248ae0a7', '9845405351', NULL, NULL, NULL, NULL, 'active', 'verified', NULL, '2024-09-08 09:39:33', '2024-09-09 18:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`wishlist_id`, `user_id`, `created_at`) VALUES
(1, 9, '2024-09-05 14:09:16'),
(2, 1, '2024-09-05 14:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `wishlist_item_id` int(11) NOT NULL,
  `wishlist_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `redeemcode`
--
ALTER TABLE `redeemcode`
  ADD PRIMARY KEY (`code_Id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`wishlist_item_id`),
  ADD KEY `wishlist_id` (`wishlist_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `redeemcode`
--
ALTER TABLE `redeemcode`
  MODIFY `code_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `wishlist_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_ibfk_1` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlists` (`wishlist_id`),
  ADD CONSTRAINT `wishlist_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
