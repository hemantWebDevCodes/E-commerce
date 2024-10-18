-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2024 at 09:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(201) NOT NULL,
  `admin_mobile` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`admin_id`, `username`, `email`, `admin_mobile`, `password`, `role`, `status`) VALUES
(1, 'Hemant Saini', 'hemant@gmail.com', '0', 'hemant', 0, 1),
(2, '', '', '0', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL,
  `main_bcategory` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `hadding_first` varchar(201) NOT NULL,
  `hedding_second` varchar(255) NOT NULL,
  `btn_text` varchar(121) NOT NULL,
  `banner_image` varchar(233) NOT NULL,
  `banner_paragraph` varchar(234) NOT NULL,
  `status` varchar(234) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`banner_id`, `main_bcategory`, `category_name`, `hadding_first`, `hedding_second`, `btn_text`, `banner_image`, `banner_paragraph`, `status`) VALUES
(1, 0, '', 'Best Seller', '', '', 'upload/pro.jpg', '', '1'),
(2, 0, '', 'Best Seller', '', '', 'upload/pro1.jpg', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `color_manage`
--

CREATE TABLE `color_manage` (
  `color_id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `color_manage`
--

INSERT INTO `color_manage` (`color_id`, `color`, `status`) VALUES
(1, 'Blue', '1'),
(2, 'Red', '1'),
(3, 'Green', '1'),
(4, 'Pink', '1');

-- --------------------------------------------------------

--
-- Table structure for table `contect`
--

CREATE TABLE `contect` (
  `contect_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contect`
--

INSERT INTO `contect` (`contect_id`, `name`, `email`, `mobile`, `comment`, `added_on`) VALUES
(1, 'Hemant saini', 'Hemantsaini1563@gmail.com', 2147483647, 'Hii, I am Hemant saini  from jaipur. your Project so nice.', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `coupon_type` varchar(255) NOT NULL,
  `coupon_value` int(11) NOT NULL,
  `coupon_min_value` int(11) NOT NULL,
  `expire_date` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`coupon_id`, `coupon_code`, `coupon_type`, `coupon_value`, `coupon_min_value`, `expire_date`, `status`) VALUES
(1, 'disc', 'Rupee', 30, 300, 2024, '1'),
(2, 'person', 'Percentage', 10, 200, 2024, '1');

-- --------------------------------------------------------

--
-- Table structure for table `main_category`
--

CREATE TABLE `main_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_category`
--

INSERT INTO `main_category` (`category_id`, `category_name`, `category_role`) VALUES
(1, 'Man', '1'),
(2, 'Electronics', '1'),
(3, 'Mobiles', '1'),
(4, 'Fation', '1'),
(5, 'Book', '1'),
(6, 'Home & Furniture', '1'),
(7, 'Fation', '0');

-- --------------------------------------------------------

--
-- Table structure for table `order_deatail`
--

CREATE TABLE `order_deatail` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_attribute_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_deatail`
--

INSERT INTO `order_deatail` (`id`, `product_id`, `order_id`, `product_attribute_id`, `quantity`, `price`) VALUES
(1, 1, 1, 2, 1, 270),
(2, 2, 2, 4, 1, 400);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`status_id`, `status_name`) VALUES
(1, 'Pending'),
(2, 'Processing'),
(3, 'Shipped'),
(4, 'Canceled'),
(5, 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `sub_category_id` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `discount_price` int(11) NOT NULL,
  `discount_precentage` varchar(255) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `best_seller` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `added_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `p_name`, `category`, `sub_category_id`, `image`, `discount_price`, `discount_precentage`, `short_desc`, `description`, `meta_title`, `meta_description`, `meta_keyword`, `best_seller`, `status`, `added_by`) VALUES
(1, 'shirt', '6', '5', 'upload/chaire1.jpg', 20, '10', 'This is Short description', 'This is testing description', 'This is a Best Product', 'best Product', 'best Chairs', '1', '1', '1'),
(2, 'Lymio Casual Shirt for Men', '1', '8', 'upload/shirt.jpg', 20, '10', 'Casual Shirt for Men|| Shirt for Men|| Men Stylish Shirt', 'Casual Shirt for Men|| Shirt for Men|| Men Stylish Shirt', 'Casual Shirt for Men', 'Casual Shirt for Men|| Shirt for Men|| Men Stylish Shirt', ' Men Stylish Shirt', '1', '1', '1'),
(3, 'Lymio Casual Shirt for Men', '1', '8', 'upload/shirt4.jpg', 20, '10', 'Casual Shirt for Men|| Shirt for Men|| Men Stylish Shirt', 'Casual Shirt for Men|| Shirt for Men|| Men Stylish Shirt', 'Casual Shirt for Men', 'Casual Shirt for Men|| Shirt for Men|| Men Stylish Shirt', ' Men Stylish Shirt', '1', '1', '1'),
(4, 'Apple iPhone 13 (128GB) ', '3', '25', 'upload/applepink.jpg', 20, '20', 'Advanced dual-camera system with 12MP Wide and Ultra Wide cameras; Photographic Styles, Smart HDR 4, Night mode, 4K Dolby Vision HDR recording', '15 cm (6.1-inch) Super Retina XDR display\r\nCinematic mode adds shallow depth of field and shifts focus automatically in your videos', ' Apple iPhone', ' Apple iPhone 14 Pro 128GB', 'new mobile', '1', '1', '1'),
(5, ' Men Cargo Pants', '1', '8', 'upload/cargoPants2.jpg', 20, '20', 'Lymio Men Cargo || Men Cargo Pants || Men Cargo Pants Cotton || Cargos for Men (Cargo-05-08)', 'Lymio Men Cargo || Men Cargo Pants || Men Cargo Pants Cotton || Cargos for Men (Cargo-05-08)', 'Lymio Men Cargo || Men Cargo Pants ', '', 'Lymio Men Cargo ', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute`
--

CREATE TABLE `product_attribute` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `mrp` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_attribute`
--

INSERT INTO `product_attribute` (`id`, `product_id`, `mrp`, `price`, `quantity`, `color_id`, `size_id`) VALUES
(1, 1, 200, '250', 3, 3, 1),
(2, 1, 220, '270', 2, 2, 2),
(3, 1, 300, '370', 1, 4, 1),
(4, 2, 379, '400', 3, 1, 1),
(5, 2, 400, '450', 2, 3, 2),
(6, 3, 379, '400', 3, 2, 2),
(7, 4, 41, '41,999', 3, 1, 0),
(8, 4, 41, '41,999', 2, 4, 0),
(9, 5, 470, '520', 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `product_images`) VALUES
(1, 2, 'upload/products_image/682722548_shirt4.jpg'),
(2, 4, 'upload/products_image/878253731_appleBlue.jpg'),
(3, 4, 'upload/products_image/124745308_apple.jpg'),
(4, 4, 'upload/products_image/508631389_applepink.jpg'),
(5, 5, 'upload/products_image/555746079_cargoPants1.jpg'),
(6, 5, 'upload/products_image/533687034_cargoPants2.jpg'),
(7, 5, 'upload/products_image/302740422_cargoPants3.jpg'),
(8, 5, 'upload/products_image/368469774_cargoPants.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE `product_order` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_value` varchar(255) NOT NULL,
  `coupon_code` int(11) NOT NULL,
  `added_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_order`
--

INSERT INTO `product_order` (`id`, `order_id`, `mobile`, `user_id`, `order_status`, `state`, `city`, `pincode`, `address`, `payment_type`, `price`, `total_price`, `payment_status`, `coupon_id`, `coupon_value`, `coupon_code`, `added_on`) VALUES
(1, 0, '9839292383', 1, '3', 'Rajasthan ', 'jaipur', 9283282, 'bhainslana,jaipur', 'cod', 0, 270, 'success', 0, '', 0, '2024-09-26'),
(2, 0, '9839292383', 1, '1', 'Rajasthan ', 'jaipur', 93238293, 'bhainslana,jaipur', 'option2', 0, 400, 'pending', 0, '', 0, '2024-10-12');

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `size_master`
--

CREATE TABLE `size_master` (
  `size_id` int(11) NOT NULL,
  `size` varchar(255) NOT NULL,
  `order_by` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size_master`
--

INSERT INTO `size_master` (`size_id`, `size`, `order_by`, `status`) VALUES
(1, 'sm', 1, '1'),
(2, 'xl', 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `subcate_id` int(11) NOT NULL,
  `subcate_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`subcate_id`, `subcate_name`, `category_id`, `status`) VALUES
(1, 'Laptop', 2, '1'),
(2, 'Tablets', 2, '1'),
(3, 'Headphones', 2, '1'),
(4, 'Smartwatches', 2, '1'),
(5, 'Chairs', 6, '1'),
(6, 'Bedroom ', 6, '1'),
(7, 'able Lamps', 6, '1'),
(8, 'Clothing ', 1, '1'),
(9, 'Shoes', 1, '1'),
(10, 'Jackets', 1, '1'),
(11, 'Kurta', 1, '1'),
(12, 'Belts', 1, '1'),
(13, 'Jewelry', 4, '1'),
(14, 'Blazers', 1, '1'),
(15, 'Skirts', 4, '1'),
(16, 'Heels', 4, '1'),
(17, 'Trousers', 4, '1'),
(18, 'Novels', 5, '1'),
(19, 'Recipe Books', 5, '1'),
(20, 'Picture Books', 5, '1'),
(21, 'Study Guides', 5, '1'),
(22, 'Programing Books', 5, '1'),
(23, 'Mobile Parts', 3, '1'),
(24, 'Wearable Devices', 3, '1'),
(25, 'Smartphones', 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE `user_registration` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(201) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `password` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`id`, `name`, `email`, `mobile`, `password`) VALUES
(1, 'Hemant Saini', 'hemantsaini@gmail.com', '0988989878', '98989898');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `product_id`, `added_on`) VALUES
(4, 1, 4, '2027-09-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `color_manage`
--
ALTER TABLE `color_manage`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `contect`
--
ALTER TABLE `contect`
  ADD PRIMARY KEY (`contect_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `main_category`
--
ALTER TABLE `main_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `order_deatail`
--
ALTER TABLE `order_deatail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_attribute`
--
ALTER TABLE `product_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size_master`
--
ALTER TABLE `size_master`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`subcate_id`);

--
-- Indexes for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `color_manage`
--
ALTER TABLE `color_manage`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contect`
--
ALTER TABLE `contect`
  MODIFY `contect_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `main_category`
--
ALTER TABLE `main_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_deatail`
--
ALTER TABLE `order_deatail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_attribute`
--
ALTER TABLE `product_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `size_master`
--
ALTER TABLE `size_master`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `subcate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_registration`
--
ALTER TABLE `user_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
