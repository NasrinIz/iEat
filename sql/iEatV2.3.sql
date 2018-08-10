-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2018 at 04:27 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `iEat`
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
(5, 'Sample ad 2', 'Sample content 2', 'fabio-alves-386882-unsplash.jpg'),
(6, 'Sample ad 3', 'Sample content 3', 'fancycrave-458020-unsplash.jpg'),
(7, 'Sample ad 4', 'Sample content 4', 'jonathan-pielmayer-583293-unsplash.jpg'),
(8, 'Sample ad 5 ', 'Sample content 5', 'anton-porsche-114866-unsplash.jpg');

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

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `name`, `count`, `amount`, `comment`, `customer_name`, `phone`, `address`) VALUES
(10, 'Paninis & Wraps', 1, 20.00, '', 'Guest', '', ''),
(11, 'All Sandwiches', 1, 20.00, '', 'Guest', '', '');

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
  `picture` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `picture`) VALUES
(1, 'Paninis & Wraps', 'S1-1.jpg'),
(2, 'Featured Products', 'S1-2.jpg'),
(3, 'All Sandwiches', 'S1-3.jpg'),
(4, '8 Under 6', 'S1-4.jpg'),
(5, 'Breakfast', 'S1-5.jpg'),
(6, 'Salads', 'S1-6.jpg'),
(7, 'Sides', 'S1-7.jpg'),
(19, 'Sample Menu', 'natalya-340213-unsplash.jpg'),
(20, 'Sample 2 ', 'natalya-340213-unsplash.jpg');

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
(1, 1, 'Mehran Ishanian', 1, '152 Rene Levesque', 'A1B2C3', '+151412345', 0.00, 50.00, 1, 2, NULL, NULL, '2018-07-26 00:00:00', 6),
(2, 3, '', NULL, '', NULL, '', NULL, 160.00, NULL, NULL, '', NULL, '2030-07-18 03:07:00', 0),
(3, 3, '', NULL, '', NULL, '', NULL, 160.00, NULL, NULL, '', NULL, '2030-07-18 03:07:00', 0),
(4, 3, 'Nasrin izadi', NULL, 'Towers\r\n607', NULL, '5149991428', NULL, 160.00, NULL, NULL, '', NULL, '2030-07-18 03:07:00', 3),
(5, 3, 'Nasrin izadi', NULL, 'Towers\r\n607', NULL, '5149991428', NULL, 20.00, NULL, NULL, '', NULL, '2030-07-18 04:07:00', 3),
(6, 3, 'Nasrin izadi', NULL, 'Towers\r\n607', NULL, '5149991428', NULL, 20.00, NULL, NULL, '', NULL, '2030-07-18 03:07:00', 5),
(7, 3, 'Nasrin izadi', NULL, 'Towers\r\n607', NULL, '5149991428', NULL, 20.00, NULL, NULL, '', NULL, '2031-07-18 12:07:00', 0),
(8, 3, 'Nasrin izadi', NULL, 'Towers\r\n607', NULL, '5149991428', NULL, 20.00, NULL, NULL, '', NULL, '2031-07-18 12:07:00', 1),
(9, 3, 'Nasrin izadi', NULL, 'Towers\r\n607', NULL, '5149991428', NULL, 20.00, NULL, NULL, '', NULL, '2031-07-18 12:07:00', 0),
(10, 2, '', NULL, '', NULL, '', NULL, 60.00, NULL, NULL, '', NULL, '2006-08-18 08:08:00', 0),
(11, 0, '', NULL, '', NULL, '', NULL, 40.00, NULL, NULL, '', NULL, '2006-08-18 09:08:00', 0),
(12, 0, 'Nasrin izadi', NULL, 'Towers\r\n607', NULL, '5149991428', NULL, 20.00, NULL, NULL, '', NULL, '2006-08-18 09:08:00', 0),
(13, 0, 'Nasrin izadi', NULL, 'Towers\r\n607', NULL, '5149991428', NULL, 20.00, NULL, NULL, '', NULL, '2006-08-18 09:08:00', 0);

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
  `price` double(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `quantity`, `menu_id`, `sub_menu_id`, `price`) VALUES
(1, 1, 1, 1, 4, 6.00),
(2, 1, 2, 2, 10, 7.00);

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
(1, 1, '08:00:00', '21:00:00');

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
(3, 'nasrin@test.com', '$2y$10$MciS55HjwtHfnH8sY8ogW.aTv4IadPU3RIhuX2d1bUoBJDX97zqLm', 'Nasrin izadi', '5149991428', 'Towers\r\n607', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
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
-- AUTO_INCREMENT for table `dessert_menus`
--
ALTER TABLE `dessert_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `drink_menus`
--
ALTER TABLE `drink_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;