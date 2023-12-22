-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2023 at 12:06 AM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddToNewsletter` (IN `p_email` VARCHAR(100), OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
    DECLARE existing_count INT;
    SELECT COUNT(*) INTO existing_count FROM newsletter WHERE email_address = p_email;

    IF existing_count = 0 THEN
        BEGIN
            INSERT INTO newsletter (email_address) VALUES (p_email);
            IF ROW_COUNT() > 0 THEN
                SET p_status = 0; 
                SET p_message = 'Subscription successful!';
            ELSE
                SET p_status = 1; 
                SET p_message = 'Error during adding to newsletter.';
            END IF;
        END;
    ELSE
        SET p_status = 1;
        SET p_message = 'This email is already subscribed.';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddUserAddress` (IN `p_userId` INT, IN `p_userFirstName` VARCHAR(100), IN `p_userLastName` VARCHAR(100), IN `p_userEmail` VARCHAR(255), IN `p_userPhoneNumber` VARCHAR(15), IN `p_userHomeAddress` VARCHAR(100), IN `p_userCity` VARCHAR(100), IN `p_userPostalCode` VARCHAR(6), IN `p_userState` VARCHAR(100), IN `p_userCountry` VARCHAR(100), OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
    IF p_userId IS NULL OR p_userId < 0 OR
       p_userFirstName IS NULL OR
       p_userLastName IS NULL OR
       p_userPhoneNumber IS NULL OR
       p_userHomeAddress IS NULL OR
       p_userCity IS NULL OR
       p_userPostalCode IS NULL OR
       p_userState IS NULL OR
       p_userCountry IS NULL THEN
        SET p_status = 1;
        SET p_message = 'Incorrect address parameters.';
    ELSEIF NOT (p_userFirstName RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź -]+$') OR
           NOT (p_userLastName RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź -]+$') THEN
        SET p_status = 1;
        SET p_message = 'First and Last name must only contain letters, - sign, and spaces.';
    ELSEIF NOT (p_userPhoneNumber RLIKE '^[0-9+-]{9,12}$') THEN
        SET p_status = 1;
        SET p_message = 'Phone number must only contain digits and -+ signs and be between 9 and 12 characters.';
    ELSEIF NOT (p_userHomeAddress RLIKE '^[A-Za-z0-9ĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') THEN
        SET p_status = 1;
        SET p_message = 'Home address must only contain letters, digits, ./-, and spaces.';
    ELSEIF NOT (p_userCity RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') OR
           NOT (p_userState RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') OR
           NOT (p_userCountry RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') THEN
        SET p_status = 1;
        SET p_message = 'City, State and Country must only contain letters, digits, ./-, and spaces.';
    ELSEIF p_userCountry = 'Select country' THEN
        SET p_status = 1;
        SET p_message = 'Please select country.';
    ELSE
        BEGIN
            DECLARE EXIT HANDLER FOR SQLEXCEPTION
            BEGIN
                SET p_status = 1;
                SET p_message = 'Error while adding address.';
            END;

            INSERT INTO user_address (
                user_id,
                user_firstname,
                user_lastname,
                user_email,
                user_phone,
                user_homeaddress,
                user_city,
                user_postalcode,
                user_state,
                user_country
            )
            VALUES (
                p_userId,
                p_userFirstName,
                p_userLastName,
                p_userEmail,
                p_userPhoneNumber,
                p_userHomeAddress,
                p_userCity,
                p_userPostalCode,
                p_userState,
                p_userCountry
            );
            IF ROW_COUNT() > 0 THEN
                SET p_status = 0;
                SET p_message = 'Address successfully added.';
            ELSE
                SET p_status = 1;
                SET p_message = 'Error while adding address.';
            END IF;
        END;
    END IF;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteUser` (IN `p_userId` INT)   BEGIN
    DELETE FROM User_Address WHERE user_id = p_userId;
    DELETE FROM User WHERE id = p_userId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteUserAddress` (IN `p_userId` INT, IN `p_userAddressId` INT, OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
    IF p_userId IS NULL OR p_userId < 0 OR p_userAddressId IS NULL OR p_userAddressId < 0 THEN
        SET p_status = 1;
        SET p_message = 'Incorrect address parameters.';
    ELSE
        IF NOT EXISTS(SELECT 1 FROM user_address WHERE id = p_userAddressId) THEN
            SET p_status = 1;
            SET p_message = 'Address does not exist.';
        ELSE
            IF NOT EXISTS(SELECT 1 FROM user_address WHERE id = p_userAddressId AND user_id = p_userId) THEN
                SET p_status = 1;
                SET p_message = 'Address does not exist.';
            ELSE
                BEGIN
                    DECLARE EXIT HANDLER FOR SQLEXCEPTION
                    BEGIN
                        SET p_status = 1;
                        SET p_message = 'Error while deleting address.';
                    END;
                    
                    DELETE FROM user_address WHERE id = p_userAddressId AND user_id = p_userId;
                    IF ROW_COUNT() > 0 THEN
                        SET p_status = 0;
                        SET p_message = 'Address successfully deleted.';
                    ELSE
                        SET p_status = 1;
                        SET p_message = 'Error while deleting address.';
                    END IF;
                END;
            END IF;
        END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductAvailability` ()   BEGIN
    SELECT COUNT(Product.id) AS available_count 
    FROM Product 
    JOIN Inventory ON Product.id = Inventory.product_id 
    WHERE Inventory.product_quantity > 0;

    SELECT COUNT(Product.id) AS out_of_stock_count 
    FROM Product 
    LEFT JOIN Inventory ON Product.id = Inventory.product_id 
    WHERE Inventory.product_quantity <= 0 OR Inventory.product_id IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductCategories` ()   BEGIN
    SELECT Category.id, Category.category_name, COUNT(Product.id) AS product_count 
    FROM Category 
    LEFT JOIN Product ON Category.id = Product.category_id 
    GROUP BY Category.id, Category.category_name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductInformation` (IN `p_productId` INT)   BEGIN
    SELECT 
        Product.id as product_id, 
        Product.product_name, 
        Product.product_description_long as product_description,
        Product.product_price, 
        Supplier.supplier_name,
        IFNULL(Inventory.product_quantity, 0) as quantity
    FROM Product 
    JOIN Supplier ON Product.supplier_id = Supplier.id
    LEFT JOIN Inventory ON Product.id = Inventory.product_id
    WHERE Product.id = p_productId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductSuppliers` ()   BEGIN
    SELECT Supplier.id, Supplier.supplier_name, COUNT(Product.id) AS product_count 
    FROM Supplier
    LEFT JOIN Product ON Supplier.id = Product.supplier_id 
    GROUP BY Supplier.id, Supplier.supplier_name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegisterUser` (IN `p_username` VARCHAR(40), IN `p_password` VARCHAR(60), IN `p_email` VARCHAR(100), OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
    DECLARE user_exists INT;
    DECLARE valid_username INT;

    -- User validation
    SET valid_username = (CHAR_LENGTH(p_username) >= 5 AND CHAR_LENGTH(p_username) <= 40 AND p_username REGEXP '^[A-Za-z0-9]+$');
    IF NOT valid_username THEN
        SET p_status = 1;
        SET p_message = 'Error during registration.';
    ELSE
        SELECT COUNT(*) INTO user_exists FROM user 
        WHERE user_login = p_username OR user_email = p_email;

        IF user_exists > 0 THEN
            SET p_status = 1;
            SET p_message = 'Username or email already exists.';
        ELSE
            INSERT INTO user (user_login, user_password, user_email) 
            VALUES (p_username, p_password, p_email);

            IF ROW_COUNT() > 0 THEN
                SET p_status = 0;
                SET p_message = 'Registration successful.';
            ELSE
                SET p_status = 1;
                SET p_message = 'Error during registration.';
            END IF;
        END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUserAddress` (IN `p_userId` INT, IN `p_userAddressId` INT, IN `p_userFirstName` VARCHAR(100), IN `p_userLastName` VARCHAR(100), IN `p_userEmail` VARCHAR(255), IN `p_userPhoneNumber` VARCHAR(15), IN `p_userHomeAddress` VARCHAR(100), IN `p_userCity` VARCHAR(100), IN `p_userPostalCode` VARCHAR(6), IN `p_userState` VARCHAR(100), IN `p_userCountry` VARCHAR(100), OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
    IF p_userId IS NULL OR p_userId < 0 OR p_userAddressId IS NULL OR p_userAddressId < 0 THEN
        SET p_status = 1;
        SET p_message = 'Incorrect address parameters.';
    ELSEIF NOT EXISTS(SELECT 1 FROM user_address WHERE id = p_userAddressId AND user_id = p_userId) THEN
        SET p_status = 1;
        SET p_message = 'Address does not exist.';
    ELSEIF NOT (p_userFirstName RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź -]+$') OR
           NOT (p_userLastName RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź -]+$') THEN
        SET p_status = 1;
        SET p_message = 'First and Last name must only contain letters, - sign, and spaces.';
    ELSEIF NOT (p_userPhoneNumber RLIKE '^[0-9+-]{9,12}$') THEN
        SET p_status = 1;
        SET p_message = 'Phone number must only contain digits and -+ signs.';
    ELSEIF NOT (p_userHomeAddress RLIKE '^[A-Za-z0-9ĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+(/[A-Za-z0-9ĄąĆćĘęŁłŃńÓóŚśŻżŹź]+)?$') THEN
        SET p_status = 1;
        SET p_message = 'Home address must only contain letters, digits, ./-, and spaces.';
    ELSEIF NOT (p_userCity RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') OR
           NOT (p_userState RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') THEN
        SET p_status = 1;
        SET p_message = 'City and State must only contain letters, ./-, and spaces.';
    ELSEIF p_userCountry = 'Select country' THEN
        SET p_status = 1;
        SET p_message = 'Please select country.';
    ELSE
        BEGIN
            DECLARE EXIT HANDLER FOR SQLEXCEPTION
            BEGIN
                SET p_status = 1;
                SET p_message = 'Error while updating address.';
            END;

            UPDATE user_address SET
                user_firstname = p_userFirstName,
                user_lastname = p_userLastName,
                user_email = p_userEmail,
                user_phone = p_userPhoneNumber,
                user_homeaddress = p_userHomeAddress,
                user_city = p_userCity,
                user_postalcode = p_userPostalCode,
                user_state = p_userState,
                user_country = p_userCountry
            WHERE id = p_userAddressId AND user_id = p_userId;
            
            IF ROW_COUNT() > 0 THEN
                SET p_status = 0;
                SET p_message = 'Address successfully updated.';
            ELSE
                SET p_status = 1;
                SET p_message = 'No changes made to address.';
            END IF;
        END;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'Foreign key from User',
  `total_price` decimal(5,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `total_price`) VALUES
(7, 49, 0.00),
(8, 48, 0.00),
(9, 55, 0.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart_item`
--

CREATE TABLE IF NOT EXISTS `cart_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Cart',
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `cart_item_ibfk_1` (`cart_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`id`, `cart_id`, `product_id`, `quantity`) VALUES
(131, 8, 16, 5),
(132, 8, 15, 6),
(133, 8, 14, 1),
(134, 7, 16, 1),
(142, 9, 15, 6),
(143, 9, 16, 5);

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

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`product_id`, `product_quantity`) VALUES
(14, 1),
(15, 6),
(16, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table for emails that agreed to newsletter';

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email_address`) VALUES
(19, 'ambroziak.m@onet.pl');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Product',
  `product_quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(16, 13, 2, 'Cocoa Cuddles Bear', 'Meet Cocoa Cuddles, your plushie\'s new best friend! With its soft, chocolate-brown fur and an embrace as warm as hot cocoa, this bear is the perfect snuggle companion for all ages.', 'This bear is the perfect snuggle companion for all', 85.50, '2023-11-24 08:48:25'),
(17, 14, 4, 'Bubblegum Bliss Onesie Set', 'Wrap your plushie in the sweetness of our Bubblegum Bliss Onesie Set. Its vibrant pink color and cozy shorts make it a delightful outfit for your plushie to lounge in style.', 'Wrap your plushie in the sweetness of this comfort', 55.00, '2023-11-24 08:48:25'),
(18, 14, 4, 'Ocean Breeze Onesie Set', 'Dress your plushie in our Ocean Breeze Onesie Set to bring the serenity of the sea to playtime. The calming blue hue and comfortable shorts are ideal for a day of adventure or relaxation.', 'The calming blue hue and comfortable shorts are id', 55.00, '2023-11-25 08:48:25');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table for product images';

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `product_image_path`, `image_description`) VALUES
(2, 15, 'assets\\products\\plush-accessories\\plush_accessory_1.png', 'Mini pair of glasses with transparent lens on pink background'),
(3, 16, 'assets\\products\\plush-bases\\bear_base\\bear_1.png', 'Light-brown bear plushie on table'),
(4, 17, 'assets\\products\\plush-clothes\\clothes_set_2\\clothes_1.png', 'Mini clothing set for plushie including pink onesie and jeans shorts'),
(5, 18, 'assets\\products\\plush-clothes\\clothes_set_1\\clothes_1.jpg', 'Mini clothing set for plushie including light-blue onesie and jeans shorts'),
(6, 16, 'assets\\products\\plush-bases\\bear_base\\bear_2.png', 'Light-brown bear plushie held in hands'),
(7, 16, 'assets\\products\\plush-bases\\bear_base\\bear_3.png', 'Light-brown bear plushie on table');

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
  `user_email` varchar(100) DEFAULT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `UC_user_login_unique` (`user_login`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_login`, `user_password`, `user_email`, `date_created`) VALUES
(49, 'Volteh', '$2y$10$GhyzGCB0DtOpqXikGxfgIuSUJFtgh29HC24JvsjYBHlG.a0KwYFGm', 'Volteh@wp.pl', '2023-12-11'),
(55, 'Eteiz', '$2y$10$QjuMe4wD46BjMQLqB.tGYuYTYLQJXf6Y3CxaW7TI9G3v1nwuyJ16K', 'mrsrosequartz@gmail.com', '2023-12-19');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'Foreign key from User',
  `user_firstname` varchar(100) DEFAULT 'Not specified',
  `user_lastname` varchar(100) DEFAULT 'Not specified',
  `user_email` varchar(255) DEFAULT 'Not specified',
  `user_phone` varchar(15) DEFAULT NULL,
  `user_homeaddress` varchar(100) DEFAULT NULL,
  `user_city` varchar(100) DEFAULT NULL,
  `user_postalcode` varchar(6) DEFAULT NULL,
  `user_state` varchar(100) DEFAULT NULL,
  `user_country` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_phone`, `user_homeaddress`, `user_city`, `user_postalcode`, `user_state`, `user_country`) VALUES
(5, 49, 'Jan', 'Mieleszko', 'volteh@gmail.com', '+4851633874', 'Piotrkowska 292/3A', 'Łódź', '93-004', 'Łódzkie', 'Polska'),
(24, 55, 'Martyna', 'Ambroziak', 'ambroziak.m@onet.pl', '+48516633874', 'Starosty Kosa 10/21', 'Ostrołęka', '07-410', 'Mazowieckie', 'Poland'),
(25, 55, 'Marta', 'Ambroziak', 'ambroziak.m@onet.pl', '+48516633874', 'Starosty Kosa 10/21', 'Ostrołęka', '07-410', 'Mazowieckie', 'Poland');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_order`
--

CREATE TABLE IF NOT EXISTS `user_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) DEFAULT NULL COMMENT 'Foreign key from Cart',
  `user_id` int(11) DEFAULT NULL COMMENT 'Foreign key from User',
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
