-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 27, 2023 at 07:19 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stuffedpals_database`
--
CREATE DATABASE IF NOT EXISTS `stuffedpals_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `stuffedpals_database`;

DELIMITER $$
--
-- Procedury
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddProduct` (IN `_productName` VARCHAR(100), IN `_productDescriptionLong` TEXT, IN `_productDescriptionShort` VARCHAR(50), IN `_productPrice` DECIMAL(5,2) UNSIGNED, IN `_productQuantity` INT(11) UNSIGNED, IN `_categoryId` INT(11) UNSIGNED, IN `_supplierId` INT(11) UNSIGNED)   BEGIN
    DECLARE _productId INT;

    -- Adding record do Product table
    INSERT INTO Product (category_id, supplier_id, product_name, product_description_long, product_description_short, product_price)
    VALUES (_categoryId, _supplierId, _productName, _productDescriptionLong, __productDescriptionShort, _productPrice);

    -- Using new product ID to create record in Inventory table
    SET _productId = LAST_INSERT_ID();

    -- Dodanie rekordu do tabeli Inventory
    INSERT INTO Inventory (product_id, product_quantity)
    VALUES (_productId, _productQuantity);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteProduct` (IN `_productId` INT(11) UNSIGNED)   BEGIN
    -- Deleting record from Inventory
    DELETE FROM Inventory WHERE product_id = _productId;

   -- Deleting records from Product_Image
   DELETE FROM Product_Image WHERE product_id = _productId;

    -- Deleting records from Review
    DELETE FROM Review WHERE product_id = _productId;

    -- Deleting record from Product
    DELETE FROM Product WHERE id = _productId;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart_item`
--

CREATE TABLE IF NOT EXISTS `cart_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Session',
  `product_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Product',
  `quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`),
  UNIQUE KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Category information';

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(13, 'Bases'),
(14, 'Clothes'),
(15, 'Accessories');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `product_id` int(11) NOT NULL COMMENT 'Foreign key from Product',
  `product_quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table for emails that agreed to newsletter';

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'Foreign key from User',
  `total_price` decimal(5,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_details_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Order_details',
  `product_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Product',
  `quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id` (`product_id`),
  KEY `order_details_id` (`order_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_status`
--

CREATE TABLE IF NOT EXISTS `order_status` (
  `order_details_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Order_Details',
  `order_status_description` text DEFAULT NULL,
  UNIQUE KEY `order_details_id` (`order_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Order status information';

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_method`
--

CREATE TABLE IF NOT EXISTS `payment_method` (
  `order_details_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Order_Details',
  `payment_method_description` text DEFAULT NULL,
  UNIQUE KEY `order_details_id` (`order_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Order payment information';

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Category',
  `supplier_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Supplier',
  `product_name` varchar(100) DEFAULT NULL,
  `product_description_long` text DEFAULT NULL,
  `product_description_short` varchar(50) DEFAULT NULL,
  `product_price` decimal(5,2) NOT NULL DEFAULT 0.00,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `supplier_id`, `product_name`, `product_description_long`, `product_description_short`, `product_price`, `date_added`) VALUES
(14, 15, 5, 'Midnight Elegance Booties', 'Step into a world of sophistication with our Midnight Elegance Booties, perfectly tailored for your plushie\'s formal occasions. Crafted with velvety black fabric and detailed stitching, these boots offer both style and comfort.', 'Perfectly tailored for your plushie\'s formal occas', 45.00, '2023-11-24 08:48:25'),
(15, 15, 3, 'Clear Vision Plushie Spectacles', 'Enhance your plushie\'s intellect with our Clear Vision Spectacles. Featuring transparent lenses set in a sleek, thin frame, these glasses add a touch of charm to any plush character.', 'Featuring transparent lenses set in a sleek, thin ', 35.00, '2023-11-24 08:48:25'),
(16, 13, 2, 'Cocoa Cuddles Bear', 'Meet Cocoa Cuddles, your plushie\'s new best friend! With its soft, chocolate-brown fur and an embrace as warm as hot cocoa, this bear is the perfect snuggle companion for all ages.', 'This bear is the perfect snuggle companion for all', 85.00, '2023-11-24 08:48:25'),
(17, 14, 4, 'Bubblegum Bliss Onesie Set', 'Wrap your plushie in the sweetness of our Bubblegum Bliss Onesie Set. Its vibrant pink color and cozy shorts make it a delightful outfit for your plushie to lounge in style.', 'Wrap your plushie in the sweetness of this comfort', 55.00, '2023-11-24 08:48:25'),
(18, 14, 4, 'Ocean Breeze Onesie Set', 'Dress your plushie in our Ocean Breeze Onesie Set to bring the serenity of the sea to playtime. The calming blue hue and comfortable shorts are ideal for a day of adventure or relaxation.', 'The calming blue hue and comfortable shorts are id', 55.00, '2023-11-24 08:48:25');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Product',
  `product_image_path` varchar(200) DEFAULT NULL COMMENT 'Path to image',
  `image_description` text DEFAULT NULL COMMENT 'Description used to alt attribute',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table for product images';

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `product_image_path`, `image_description`) VALUES
(1, 14, 'assets\\products\\plush-accessories\\plush_accessory_11\\boots_1.png', 'Mini black boots on pink background '),
(2, 10, 'product_images\\plush-accessories\\plush_accessory_1.png', 'Mini pair of glasses with transparent lens on pink background'),
(3, 11, 'product_images\\plush-bases\\bear_base\\bear_1.png', 'Light-brown bear plushie on table'),
(4, 12, 'product_images\\plush-clothies\\clothes_set_2\\clothes_1.png', 'Mini clothing set for plushie including pink onesie and jeans shorts'),
(5, 13, 'product_images\\plush-clothies\\clothes_set_1\\clothes_1.jpg', 'Mini clothing set for plushie including light-blue onesie and jeans shorts');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Product',
  `user_id` int(11) DEFAULT NULL COMMENT 'Foreign key from User',
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table for products reviews';

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'Foreign key from User',
  `total` decimal(5,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(100) DEFAULT NULL,
  `supplier_address` varchar(100) DEFAULT NULL,
  `supplier_email` varchar(100) DEFAULT NULL,
  `supplier_phone_number` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_name`, `supplier_address`, `supplier_email`, `supplier_phone_number`) VALUES
(1, 'Fluffy Fabrics Ltd.', '123 Cotton Lane, Fabricville, FAB 4C1', 'contact@fluffyfabrics.com', '+18001234567'),
(2, 'Plush Pals Materials Co.', '456 Softie St., Plushburg, PLU 8P2', 'sales@plushpalsmaterials.co', '+18002345678'),
(3, 'Toyland Accessories Inc.', '789 Stitch Row, Toyville, TOY 6T3', 'info@toylandaccessories.com', '+18003456789'),
(4, 'Cuddly Creations Supplies', '321 Teddy Ave., Cuddleton, CUD 5C4', 'support@cuddlycreationssupplies.com', '+18004567890'),
(5, 'Plush Apparel and More', '654 Fabrication Drive, Crafttown, CRA 3F5', 'inquiries@plushapparelmore.com', '+18005678901'),
(6, 'Little Wonders Toy Supplies', '987 Imagination Court, Wondercity, WON 2W6', 'help@littlewonderstoysupplies.com', '+18006789012');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(40) NOT NULL,
  `user_password` varchar(60) NOT NULL COMMENT 'Hashed by md5',
  `user_firstname` varchar(100) DEFAULT NULL,
  `user_lastname` varchar(100) DEFAULT NULL,
  `user_phone_number` varchar(12) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UC_user_login_unique` (`user_login`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_login`, `user_password`, `user_firstname`, `user_lastname`, `user_phone_number`, `user_email`) VALUES
(23, 'Eteiz', '$2y$10$5wnjzEo2I53GwPxYkG7xy.vqO68e5xEEBbU6e8amGxCQn3MQsuLYC', NULL, NULL, NULL, 'mrsrosequartz@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'Foreign key from User',
  `user_homeaddress` varchar(100) DEFAULT NULL,
  `user_city` varchar(100) DEFAULT NULL,
  `user_postalcode` varchar(6) DEFAULT NULL,
  `user_country` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_details_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_status`
--
ALTER TABLE `order_status`
  ADD CONSTRAINT `order_status_ibfk_1` FOREIGN KEY (`order_details_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD CONSTRAINT `payment_method_ibfk_1` FOREIGN KEY (`order_details_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
