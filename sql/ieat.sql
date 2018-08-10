-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2018 at 09:38 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ieat`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `province_id` int(2) NOT NULL,
  `address` text,
  `po_box` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `customer_id`, `province_id`, `address`, `po_box`) VALUES
(1, 1, 1, '1010 Guy', 'A1B2C3');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` int(11) NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `content` varchar(256) DEFAULT NULL,
  `img` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `title`, `content`, `img`) VALUES
(4, 'Sample 1', 'Sample Cotent', 'cherry.jpg'),
(5, 'Sample 3', '', 'open24.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `amount` float(12,2) DEFAULT NULL,
  `comment` varchar(256) DEFAULT NULL,
  `customer_name` varchar(256) DEFAULT NULL,
  `phone` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `full_name` varchar(60) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `reward` int(1) DEFAULT NULL,
  `user_name` varchar(60) DEFAULT NULL,
  `user_pass` varchar(60) DEFAULT NULL,
  `activity_status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `full_name`, `phone`, `mobile`, `reward`, `user_name`, `user_pass`, `activity_status`) VALUES
(1, 'Mehran Ishanian', '5149296960', '5149296960', 0, 'superadmin', 'Ad123456', 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_types`
--

CREATE TABLE `delivery_types` (
  `delivery_type_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivery_types`
--

INSERT INTO `delivery_types` (`delivery_type_id`, `name`) VALUES
(1, 'PickUp'),
(2, 'Cash On Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `dessert_menus`
--

CREATE TABLE `dessert_menus` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `img` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `drink_menus`
--

CREATE TABLE `drink_menus` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `img` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  `user_pass` varchar(20) DEFAULT NULL,
  `level_no` int(1) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `address` varchar(120) DEFAULT NULL,
  `province_id` int(1) DEFAULT NULL,
  `zip_code` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `full_name`, `user_name`, `user_pass`, `level_no`, `phone`, `mobile`, `address`, `province_id`, `zip_code`) VALUES
(1, 'Nasreen', 'nasreen', '1234', 1, NULL, NULL, NULL, 2, NULL),
(2, 'Golnoosh', 'goli', '123456', -1, NULL, NULL, NULL, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(3) NOT NULL,
  `name` varchar(60) NOT NULL,
  `content` text,
  `calories` int(11) DEFAULT NULL,
  `amount` float(12,2) DEFAULT NULL,
  `img` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `content`, `calories`, `amount`, `img`) VALUES
(25, 'Oven Roasted Chicken ', 'The Oven Roasted Chicken sandwich is warm, with savory chick', 350, 15.00, 'OvenRoasted_Chicken_594x334.jpg'),
(26, 'Spicy Italian', 'Our Spicy Italian sandwich is a combo of pepperoni and Genoa', 300, 20.00, 'Spicy_Italian_594x334.jpg'),
(27, 'Roast Beef', 'Our Roast Beef sandwich has lean, sliced beef piled up high,', 450, 18.00, 'RoastBeef_594x334.jpg'),
(28, 'Turkey Breast', 'Enjoy a low-fat flavor feast of premium sliced turkey breast', 300, 20.00, 'Turkey_Breast_594x334.jpg'),
(29, 'Chicken & Bacon Ranch Melt ', 'The Chicken & Bacon Ranch Melt sandwich is packed with tender all-white meat chicken with seasoning and marinade, savory bacon, melty Montery cheddar cheese', 400, 16.00, 'RPLC_chicken_bacon_ranch.jpg'),
(30, 'Steak & Cheese', 'Our Steak & Cheese sandwich is where warm, delicious steak gets topped with melty cheesiness. Get crazy with veggies and sauces to make it what you want.', 300, 15.00, 'SOCT_594x334.jpg'),
(31, 'Meatball Marinara ', 'The Meatball Marinara sandwich is drenched in irresistible marinara sauce, sprinkled with Parmesan cheese, topped with whatever you want (no judgement) and perfectly toasted just for you.', 300, 17.00, 'RPLC_meatball_marinara.jpg'),
(32, 'Tuna', 'Our tasty Tuna Sandwich is simply sumptuous. Made with flaked tuna, mixed with mayo and your choice of fresh vegetables served on freshly baked bread. This favourite contains no artificial colours or flavours.', 480, 20.00, 'RPLC-sandwich-Tuna-594x334.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `full_name` varchar(60) DEFAULT NULL,
  `province_id` int(1) DEFAULT NULL,
  `address` text,
  `zip_code` varchar(6) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `discount` double(5,2) DEFAULT NULL,
  `total_price` double(7,2) NOT NULL,
  `payment_type_id` int(1) DEFAULT NULL,
  `delivery_type_id` int(1) DEFAULT NULL,
  `description` text,
  `feedback` text,
  `order_date_time` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0: waiting, 1: registered, 2: sent, 3: delivered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `full_name`, `province_id`, `address`, `zip_code`, `phone`, `discount`, `total_price`, `payment_type_id`, `delivery_type_id`, `description`, `feedback`, `order_date_time`, `status`) VALUES
(12, 4, 'user@test.com', NULL, '#409, 198 Ann', NULL, '5149991428', NULL, 43.70, NULL, NULL, '', NULL, '2018-08-10 20:52:19', 0),
(13, 5, 'user2@test.com', NULL, '#607, Towers', NULL, '5149991428', NULL, 41.40, NULL, NULL, '', NULL, '2018-08-10 20:53:38', 3),
(14, 4, 'user@test.com', NULL, '#409, 198 Ann', NULL, '5149991428', NULL, 20.70, NULL, NULL, '', NULL, '2018-08-10 20:54:53', 2),
(15, 4, 'user@test.com', NULL, '#409, 198 Ann', NULL, '5149991428', NULL, 43.70, NULL, NULL, '', NULL, '2018-08-10 21:09:00', 1),
(16, 4, 'user@test.com', NULL, '#409, 198 Ann', NULL, '5149991428', NULL, 63.25, NULL, NULL, '', NULL, '2018-08-10 21:29:09', 1),
(17, 4, 'user@test.com', NULL, '#409, 198 Ann', NULL, '5149991428', NULL, 40.25, NULL, NULL, '', NULL, '2018-08-10 21:32:32', 1),
(18, 4, 'user@test.com', NULL, '#409, 198 Ann', NULL, '5149991428', NULL, 40.25, NULL, NULL, '', NULL, '2018-08-10 21:32:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(2) NOT NULL DEFAULT '1',
  `menu_id` int(3) NOT NULL,
  `sub_menu_id` int(3) NOT NULL,
  `price` double(6,2) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `amount` float(12,2) DEFAULT NULL,
  `comment` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `quantity`, `menu_id`, `sub_menu_id`, `price`, `name`, `count`, `amount`, `comment`) VALUES
(1, 1, 1, 1, 4, 6.00, NULL, NULL, NULL, NULL),
(2, 1, 2, 2, 10, 7.00, NULL, NULL, NULL, NULL),
(3, 16, 1, 0, 0, 0.00, '', 0, 0.00, ''),
(4, 18, 1, 0, 0, 0.00, 'Oven Roasted Chicken ', 1, 15.00, ''),
(5, 18, 1, 0, 0, 0.00, 'Turkey Breast', 1, 20.00, 'No Onion');

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `payment_type_id` int(1) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`payment_type_id`, `name`) VALUES
(1, 'Cash'),
(2, 'Credit Card'),
(3, 'PayPal');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `province_id` int(1) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`province_id`, `name`) VALUES
(1, 'Quebec'),
(2, 'Ontario'),
(3, 'Nova Scotia'),
(4, 'New Brunswick'),
(5, 'Manitoba'),
(6, 'British Columbia'),
(7, 'Prince Edward Island'),
(8, 'Saskatchewan'),
(9, 'Alberta'),
(10, 'Newfoundland and Labrador');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `store_id` int(1) NOT NULL,
  `name` varchar(60) NOT NULL,
  `province_id` int(1) NOT NULL,
  `address` varchar(60) NOT NULL,
  `zip_code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`store_id`, `name`, `province_id`, `address`, `zip_code`) VALUES
(1, 'Guy', 1, '1520 Guy Avenue', 'H3H23Z'),
(2, 'Sherbrook', 1, '230 Sherbrook Street', 'H2H1S1'),
(3, 'Rene Levesque', 1, '580 Rene Levesque', 'H4S1S5');

-- --------------------------------------------------------

--
-- Table structure for table `sub_menus`
--

CREATE TABLE `sub_menus` (
  `sub_menu_id` int(3) NOT NULL,
  `menu_id` int(3) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `picture` varchar(60) DEFAULT NULL,
  `price` double(6,2) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_menus`
--

INSERT INTO `sub_menus` (`sub_menu_id`, `menu_id`, `name`, `picture`, `price`, `description`) VALUES
(1, 1, 'Chicken Cordon Bleu Panini', 'S1-1.jpg', 10.00, 'Say “Oui” to our Chicken Cordon Bleu Panini, featuring layers of Black Forest ham and 100% Canadian rotisserie-style chicken drizzled with creamy honey mustard, on our Ciabatta bread. Topped with slices of rich Swiss cheese, baby spinach and tomatoes, and pressed to perfection on our Panini grill, it\'s sure to deliver a distinctly crispy and delicious experience.'),
(2, 1, 'Chipotle Steak and Cheese Panini', 'S1-2.jpg', 12.00, 'Our Chipotle Steak & Cheese Panini combines exciting flavours all pressed to crispy perfection on our Panini grill.  Featuring our tender, 100% Canadian steak with cheddar cheese, green peppers and red onions, on our Ciabatta bread, it\'s bursting with flavour and will be sure to deliver a crave-worthy and delicious taste experience.'),
(3, 1, 'Triple Cheese', 'S1-3.jpg', 11.00, 'Satisfy your comfort food cravings with our Triple Grilled Cheese Panini. It’s the classic melty-cheese taste you love, pressed on our Panini grill. We combine cheddar, Swiss and Monterey cheddar cheeses, and load it up with fresh baby spinach, juicy red tomatoes and crunchy red onions on our Ciabatta bread. We then press it to perfection, melding all the flavours together to deliver a warm and crispy grilled cheese experience.'),
(4, 1, 'B.L.T.', 'S1-4.jpg', 20.00, 'Introducing our new grilled wraps! Bacon, lettuce and tomatoes are topped with mayonnaise, wrapped in a flour tortilla, and grilled to tasty B.L.T. perfection.'),
(5, 1, 'Chicken & Bacon Ranch', 'S1-5.jpg', 10.00, 'Filled with 100% Canadian rotisserie-style chicken, Maple wood smoked bacon, Monterey Cheddar cheese rolled in a tortilla and grilled to perfection, the Chicken & Bacon Ranch is the perfect combination of crispy and melty.'),
(6, 1, 'Chipotle Steak & Bacon', 'S1-6.jpg', 11.00, 'The all-new Chipotle Steak & Bacon grilled wrap!  A delight made with 100% Canadian seasoned beef, bacon, Monterey cheddar, topped with creamy Chipotle Southwest sauce, and wrapped in a delicious tortilla that’s grilled to perfection.'),
(7, 1, 'Chipotle Southwest Steak & Cheese Signature Wrap', 'S1-7.jpg', 6.00, 'Saddle up with this delicious tomato basil wrap jam-packed with a double portion of 100% canadian steak and topped with your favorite tex-mex flavors like Monterey cheddar, guacamole, lettuce, tomatoes, red onions, green peppers and Chipotle Southwest sauce.'),
(8, 1, 'Turkey, Bacon & Guacamole Wrap', 'S1-8.jpg', 8.00, 'The name says it all. A delicious Tomato Basil wrap filled with a double portion of 100% canadian turkey breast and Maple wood smoked bacon topped with guacamole, lettuce, tomatoes, red onions, and Ranch.'),
(9, 1, 'Savoury Chicken Caesar Signature Wrap', 'S1-9.jpg', 9.00, 'Who can resist the classic combination of a delicious Spinach wrap filled with a double portion of tender chicken with seasoning and marinade topped with Monterey Cheddar, Parmesan cheese, lettuce, tomatoes and Savory Caesar sauce? It’s fit for an emperor.'),
(10, 2, 'Chipotle Southwest Steak & Cheese Signature Wrap', 'S2-1.jpg', 7.00, 'Saddle up with this delicious tomato basil wrap jam-packed with a double portion of 100% canadian steak and topped with your favorite tex-mex flavors like Monterey cheddar, guacamole, lettuce, tomatoes, red onions, green peppers and Chipotle Southwest sauce.'),
(11, 2, 'Savoury Chicken Caesar Signature Wrap', 'S2-2.jpg', 12.00, 'Who can resist the classic combination of a delicious Spinach wrap filled with a double portion of tender chicken with seasoning and marinade topped with Monterey Cheddar, Parmesan cheese, lettuce, tomatoes and Savory Caesar sauce? It’s fit for an emperor.'),
(12, 2, 'Turkey, Bacon & Guacamole Wrap', 'S2-3.jpg', 11.00, 'The name says it all. A delicious Tomato Basil wrap filled with a double portion of 100% canadian turkey breast and Maple wood smoked bacon topped with guacamole, lettuce, tomatoes, red onions, and Ranch.');

-- --------------------------------------------------------

--
-- Table structure for table `timings`
--

CREATE TABLE `timings` (
  `store_id` int(1) NOT NULL,
  `day_of_the_week` int(1) NOT NULL,
  `order_time_from` time NOT NULL DEFAULT '09:00:00',
  `order_time_to` time NOT NULL DEFAULT '20:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `timings`
--

INSERT INTO `timings` (`store_id`, `day_of_the_week`, `order_time_from`, `order_time_to`) VALUES
(1, 1, '09:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `phone` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `phone`, `address`, `is_admin`) VALUES
(1, 'nasrin_ptn@yahoo.com', '$2y$10$07zH7l.FZWhlLxzVTba.5u3KVI/jce3OOwcdPKuihfxUSZ6DEK8Ze', 'Nasrin izadi', '5149991428', 'Towers\r\n607', 0),
(2, 'admin@test.com', '$2y$10$psQAnBdkrkVM0vskuRDGB.2X64cG.f2mJS1Mx9LcEvIVYs.MBXpme', NULL, NULL, NULL, 1),
(3, 'nasrin@test.com', '$2y$10$MciS55HjwtHfnH8sY8ogW.aTv4IadPU3RIhuX2d1bUoBJDX97zqLm', 'Nasrin izadi', '5149991428', 'Towers\r\n607', 0),
(4, 'user@test.com', '$2y$10$QBqFAw.sFJXmkLiNG7qLgeMVTDr1gO89nV6m4c1ydGU7bSVHK2l9O', 'Jane Doe', '5149991428', '#409, 198 Ann', 0),
(5, 'user2@test.com', '$2y$10$0qlrcNI4.7h99qilvdzmselmvrxShfcrQmtqx1LMVbSAGRQF.5az.', 'John Doe', '5149991428', '#607, Towers', 0),
(6, 'golnoosh@test.com', '$2y$10$iv.xibZEmxtrCjNj5nyPJekqMVKg4kYMig6AFHJ7KHS93oadTq/xm', NULL, NULL, NULL, 0),
(7, 'sohrab@test.com', '$2y$10$VxuIvlQ8u/w.4ulF6lWbT.QW5FekyzNNmiTbKmPpJfmD5velwrxRG', NULL, NULL, NULL, 0),
(8, 'shahram@test.com', '$2y$10$P7Ul2ognb4BL12ooRz/Vqusz9sdvLZJtWMrjrg9LkMAMCk/0CrXqO', NULL, NULL, NULL, 0),
(9, 'maria@test.com', '$2y$10$LM1M1jpUna1agdrhkt2bD.tYxCjv1D0wE1y5u7NVFdZgRo/kZcaEK', NULL, NULL, NULL, 0),
(10, 'mehran@test.com', '$2y$10$8QPBCbSpsA9UGmcoIuCNeOHY2j3l231jpauyy91vZfmlhGVbXO/Ii', NULL, NULL, NULL, 0),
(11, 'maryam@test.com', '$2y$10$QKXcuZyTxin1tNd3TcrFwe7N4w1s.xdJYcN6.uIxtFSFipcZFunwS', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE `user_levels` (
  `user_level_id` int(11) NOT NULL,
  `user_level_name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`user_level_id`, `user_level_name`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default'),
(1, 'Employee'),
(2, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `user_level_permissions`
--

CREATE TABLE `user_level_permissions` (
  `user_level_id` int(11) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_level_permissions`
--

INSERT INTO `user_level_permissions` (`user_level_id`, `table_name`, `permission`) VALUES
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}customers', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}deliverytypes', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}employees', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}menus', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orderdetails', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orders', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}paymenttypes', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}provinces', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}stores', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}sub_menus', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}timings', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevelpermissions', 0),
(-2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevels', 0),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}customers', 104),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}deliverytypes', 104),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}employees', 104),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}menus', 104),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orderdetails', 104),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orders', 104),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}paymenttypes', 0),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}provinces', 0),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}stores', 0),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}sub_menus', 104),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}timings', 0),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevelpermissions', 0),
(1, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevels', 0),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}customers', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}deliverytypes', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}employees', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}menus', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orderdetails', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orders', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}paymenttypes', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}provinces', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}stores', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}sub_menus', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}timings', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevelpermissions', 111),
(2, '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevels', 111);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `delivery_types`
--
ALTER TABLE `delivery_types`
  ADD PRIMARY KEY (`delivery_type_id`);

--
-- Indexes for table `dessert_menus`
--
ALTER TABLE `dessert_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drink_menus`
--
ALTER TABLE `drink_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`payment_type_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`province_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD PRIMARY KEY (`sub_menu_id`);

--
-- Indexes for table `timings`
--
ALTER TABLE `timings`
  ADD PRIMARY KEY (`store_id`,`day_of_the_week`,`order_time_from`,`order_time_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`user_level_id`);

--
-- Indexes for table `user_level_permissions`
--
ALTER TABLE `user_level_permissions`
  ADD PRIMARY KEY (`user_level_id`,`table_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery_types`
--
ALTER TABLE `delivery_types`
  MODIFY `delivery_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `payment_type_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `province_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `store_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_menus`
--
ALTER TABLE `sub_menus`
  MODIFY `sub_menu_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
