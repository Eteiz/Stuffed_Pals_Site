-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 19, 2024 at 08:07 AM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddProduct` (IN `p_productName` VARCHAR(100), IN `p_categoryId` INT, IN `p_supplierId` INT, IN `p_productPrice` DECIMAL(5,2) UNSIGNED, IN `p_productQuantity` INT(11) UNSIGNED, IN `p_imagePath` VARCHAR(200), IN `p_imageDescription` TEXT, IN `p_productDescription` TEXT, OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
    DECLARE newProductId INT;

    IF p_productName IS NULL OR 
       p_categoryId IS NULL OR 
       p_supplierId IS NULL OR 
       p_productPrice IS NULL OR 
       p_productQuantity IS NULL OR 
       p_imagePath IS NULL OR 
       p_imageDescription IS NULL OR 
       p_productDescription IS NULL OR 
       p_categoryId < 0 OR 
       p_supplierId < 0 OR 
       p_productPrice < 0 OR 
       p_productQuantity < 0 THEN
        SET p_status = 1;
        SET p_message = 'Incorrect address parameters.';
    ELSE
    	INSERT INTO Product (category_id, supplier_id, product_name, product_description_long, product_price) VALUES (p_categoryId, p_supplierId, p_productName, p_productDescription, p_productPrice);
        IF ROW_COUNT() = 0 THEN
            SET p_status = 1;
            SET p_message = 'Error while adding product.';
        ELSE
            SET newProductId = LAST_INSERT_ID();
            INSERT INTO Inventory (product_id, product_quantity) VALUES (newProductId, p_productQuantity);
            IF ROW_COUNT() = 0 THEN
                DELETE FROM Product WHERE id = newProductId;
                SET p_status = 1;
                SET p_message = 'Error while adding product.';
            ELSE
                INSERT INTO product_image (product_id, product_image_path, image_description) VALUES (newProductId, p_imagePath, p_imageDescription);
                IF ROW_COUNT() = 0 THEN
                    DELETE FROM Inventory WHERE product_id = newProductId;
                    DELETE FROM Product WHERE id = newProductId;
                    SET p_status = 1;
                    SET p_message = 'Error while adding product.';
                ELSE
                	SET p_status = 0;
                	SET p_message = 'Product added successfully.';
                END IF;
            END IF; 
    	END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddToNewsletter` (IN `p_email` VARCHAR(255), OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
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
       p_userEmail IS NULL OR
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
    ELSEIF NOT (p_userEmail RLIKE '^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$') THEN
    	SET p_status = 1;
    	SET p_message = 'Email must be a valid email format.';    
    ELSEIF NOT (p_userPhoneNumber RLIKE '^\\+[0-9]{11}$') AND 
    	   NOT (p_userPhoneNumber RLIKE '^[0-9]{9}$') THEN
    	SET p_status = 1;
    	SET p_message = 'Phone number must be either 12 characters with a leading + and 11 digits, or 9 digits.';
    ELSEIF NOT (p_userHomeAddress RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź0-9/\\-. ]+$') THEN
    	SET p_status = 1;
    	SET p_message = 'Home address must only contain letters, digits, /\\-., and spaces.';
    ELSEIF NOT (p_userPostalCode RLIKE '^[0-9]{2}-[0-9]{3}$') THEN
        SET p_status = 1;
        SET p_message = 'Postal code must be in the format 00-000.';
    ELSEIF NOT (p_userCity RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') OR
           NOT (p_userState RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') OR
           NOT (p_userCountry RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') THEN
        SET p_status = 1;
        SET p_message = 'City, state and country name must only contain letters, digits, ./-, and spaces.';
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `CancelCartReservation` (IN `p_userId` INT)   BEGIN
  DECLARE p_cartId INT DEFAULT 0;
  DECLARE p_cartReserved INT DEFAULT 0;
  DECLARE p_cartReservationTime DATETIME DEFAULT NULL;
  DECLARE p_productId INT DEFAULT 0;
  DECLARE cartItemQuantity INT DEFAULT 0;
  DECLARE finished INT DEFAULT 0;
  DECLARE cur CURSOR FOR SELECT product_id, quantity FROM cart_item WHERE cart_id = p_cartId;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
  
  IF p_userId IS NOT NULL AND p_userId >= 0 THEN 
    -- Getting user's cart id
    SELECT id INTO p_cartId FROM cart WHERE user_id = p_userId AND (cart_reserved IS NOT NULL OR cart_reserved = 1);
    IF p_cartId IS NOT NULL AND p_cartId >= 0 THEN
      -- Updating cart's reservation if the cart is reserved
      SELECT cart_reserved, cart_reservation_time INTO p_cartReserved, p_cartReservationTime FROM cart WHERE id = p_cartId;
      IF p_cartReserved = 1 AND p_cartReservationTime IS NOT NULL THEN
        UPDATE cart SET cart_reserved = 0, cart_reservation_time = NULL WHERE id = p_cartId;

        OPEN cur;
        read_loop: LOOP
          FETCH cur INTO p_productId, cartItemQuantity;
          IF finished = 1 THEN 
            LEAVE read_loop;
          END IF;

          -- Adding the quantity from cart_item to the product_quantity in Inventory
          UPDATE Inventory 
          SET product_quantity = product_quantity + cartItemQuantity
          WHERE product_id = p_productId;
        END LOOP;
        CLOSE cur;
      END IF;
    END IF;
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateOrder` (IN `p_userId` INT, IN `p_userFirstName` VARCHAR(100), IN `p_userLastName` VARCHAR(100), IN `p_userEmail` VARCHAR(255), IN `p_userPhoneNumber` VARCHAR(12), IN `p_userHomeAddress` VARCHAR(100), IN `p_userCity` VARCHAR(100), IN `p_userPostalCode` VARCHAR(6), IN `p_userState` VARCHAR(100), IN `p_userCountry` VARCHAR(100), IN `p_userDeliveryMethod` VARCHAR(100), IN `p_userPaymentMethod` VARCHAR(100), OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
	-- Declaring variables
    DECLARE p_productId INT DEFAULT 0;
	DECLARE p_orderId INT DEFAULT 0;
    DECLARE p_cartId INT DEFAULT 0;
    DECLARE p_quantity INT DEFAULT 0;
    DECLARE p_price DECIMAL(5,2) DEFAULT 0;
    DECLARE p_subtotal_price DECIMAL(10,2) DEFAULT 0;
    DECLARE finished INT DEFAULT 0;
    DECLARE cur CURSOR FOR SELECT product_id, quantity FROM cart_item WHERE cart_id = p_cartId;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;

    IF p_userId IS NULL OR p_userId <= 0 OR
       p_userFirstName IS NULL OR p_userLastName IS NULL OR p_userEmail IS NULL OR
       p_userPhoneNumber IS NULL OR p_userHomeAddress IS NULL OR p_userCity IS NULL OR
       p_userPostalCode IS NULL OR p_userState IS NULL OR p_userCountry IS NULL THEN
       	SET p_status = 1;
       	SET p_message = 'Incorrect address parameters.';
    ELSE
        IF NOT (p_userFirstName RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź -]+$') OR
               NOT (p_userLastName RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź -]+$') THEN
            SET p_status = 1;
            SET p_message = 'First and Last name must only contain letters, - sign, and spaces.';
        ELSEIF NOT (p_userEmail RLIKE '^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$') THEN
            SET p_status = 1;
            SET p_message = 'Email must be a valid email format.';
        ELSEIF NOT (p_userPhoneNumber RLIKE '^\\+[0-9]{11}$') AND 
               NOT (p_userPhoneNumber RLIKE '^[0-9]{9}$') THEN
            SET p_status = 1;
            SET p_message = 'Phone number must be either 12 characters with a leading + and 11 digits, or 9 digits.';
        ELSEIF NOT (p_userHomeAddress RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź0-9/\\-. ]+$') THEN
            SET p_status = 1;
            SET p_message = 'Home address must only contain letters, digits, /\\-., and spaces.';
        ELSEIF NOT (p_userPostalCode RLIKE '^[0-9]{2}-[0-9]{3}$') THEN
            SET p_status = 1;
            SET p_message = 'Postal code must be in the format 00-000.';
        ELSEIF p_userCountry = 'Select country' THEN
            SET p_status = 1;
            SET p_message = 'Please select country.';
        ELSEIF p_userDeliveryMethod = 'Select delivery method' THEN
            SET p_status = 1;
            SET p_message = 'Please select delivery method.';
        ELSEIF p_userPaymentMethod = 'Select payment method' THEN
            SET p_status = 1;
            SET p_message = 'Please select payment method.';
        ELSE
        	-- Creating order_details
        	INSERT INTO order_details (user_id, order_payment_form, order_delivery, order_status)
            VALUES (
                p_userId,
                p_userPaymentMethod,
                p_userDeliveryMethod,
                CASE 
                    WHEN p_userPaymentMethod = 'Cash card' THEN 'Payment accepted'
                    WHEN p_userPaymentMethod = 'Cash on delivery' THEN 'Pending'
                    ELSE 'Pending'
                END
            );
            IF ROW_COUNT() = 0 THEN
                SET p_status = 1;
                SET p_message = 'Error while creating order.';
            ELSE
                SET p_orderId = LAST_INSERT_ID();
                -- Creating order_address
                INSERT INTO order_address (
                    order_id, order_firstname, order_lastname, order_email, 
                    order_phone, order_homeaddress, order_city, order_postalcode, 
                    order_state, order_country
                ) VALUES (
                    p_orderId, p_userFirstName, p_userLastName, p_userEmail, 
                    p_userPhoneNumber, p_userHomeAddress, p_userCity, p_userPostalCode, 
                    p_userState, p_userCountry
                );
                IF ROW_COUNT() = 0 THEN
                    DELETE FROM order_details WHERE id = p_orderId;
                    SET p_status = 1;
                    SET p_message = 'Error while creating order address.';
                ELSE
                    -- Creating order_item records
                        SET p_cartId = (SELECT id FROM cart WHERE user_id = p_userId);

                        IF p_cartId IS NOT NULL THEN
                            OPEN cur;

                            read_loop: LOOP
                                FETCH cur INTO p_productId, p_quantity;
                                IF finished THEN 
                                    LEAVE read_loop;
                                END IF;

                                SELECT product_price INTO p_price FROM Product WHERE id = p_productId; 
                                SET p_subtotal_price = p_quantity * p_price; 

                                INSERT INTO order_item (order_id, product_id, product_quantity, product_subtotal_price)
                                VALUES (p_orderId, p_productId, p_quantity, p_subtotal_price);

                                IF ROW_COUNT() = 0 THEN
                                    -- Rollback
                                    DELETE FROM order_address WHERE order_id = p_orderId;
                                    DELETE FROM order_details WHERE id = p_orderId;
                                    SET p_status = 1;
                                    SET p_message = 'Error while completing order.';
                                    CLOSE cur;
                                ELSE
                                    DELETE FROM cart_item WHERE product_id = p_productId AND cart_id = p_cartId;
                                END IF;
                            END LOOP read_loop;
                            CLOSE cur;

                            -- Updating the order_price in order_details
                            UPDATE order_details
                            SET order_price = (SELECT SUM(product_subtotal_price) FROM order_item WHERE order_id = p_orderId) + 10.00
                            WHERE id = p_orderId;
                            
                            -- Updating all carts --
                            CALL UpdateAllCarts();

                            SET p_status = 0;
                            SET p_message = 'Order items created successfully.';
                        ELSE
                            SET p_status = 1;
                            SET p_message = 'Cart not found.';
                        END IF;
                END IF;
            END IF;
        END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteProduct` (IN `p_productId` INT, OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
    IF p_productId IS NULL OR p_productId < 0 THEN
        SET p_status = 1;
        SET p_message = "Incorrect product parameters.";
    ELSE
        DELETE FROM product_image WHERE product_id = p_productId;
        IF ROW_COUNT() = 0 THEN
            SET p_status = 1;
            SET p_message = "Error while deleting product.";
		ELSE
            DELETE FROM inventory WHERE product_id = p_productId;
            IF ROW_COUNT() = 0 THEN
                SET p_status = 1;
                SET p_message = "Error while deleting product.";
            ELSE 
                DELETE FROM product WHERE id = p_productId;
                IF ROW_COUNT() = 0 THEN
                    SET p_status = 1;
                    SET p_message = "Error while deleting product.";
                ELSE
                    SET p_status = 0;
                    SET p_message = "Product deleted successfully.";
                END IF;
            END IF;
        END IF;
    END IF;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditProduct` (IN `p_productId` INT, IN `p_productName` VARCHAR(100), IN `p_categoryId` INT, IN `p_supplierId` INT, IN `p_productPrice` DECIMAL(5,2), IN `p_productQuantity` INT, IN `p_imagePath` VARCHAR(200), IN `p_imageDescription` TEXT, IN `p_productDescription` TEXT, OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
    DECLARE product_updated INT DEFAULT 0;
    DECLARE inventory_updated INT DEFAULT 0;
    DECLARE image_updated INT DEFAULT 0;
    
    IF p_productId IS NULL OR p_productId < 0 OR p_categoryId IS NULL OR p_supplierId IS NULL OR p_productPrice IS NULL OR p_productQuantity IS NULL OR 
            p_categoryId < 0 OR p_supplierId < 0 OR p_productPrice < 0 OR p_productQuantity < 0 THEN
        SET p_status = 1;
        SET p_message = 'Incorrect input parameters.';
    ELSE
        UPDATE Product
        SET category_id = p_categoryId,
            supplier_id = p_supplierId,
            product_name = p_productName,
            product_description_long = p_productDescription,
            product_price = p_productPrice
        WHERE id = p_productId;
        SET product_updated = ROW_COUNT();

        UPDATE Inventory
        SET product_quantity = p_productQuantity
        WHERE product_id = p_productId;
        SET inventory_updated = ROW_COUNT();

        UPDATE product_image
        SET product_image_path = p_imagePath,
            image_description = p_imageDescription
        WHERE product_id = p_productId;
        SET image_updated = ROW_COUNT();

        IF product_updated > 0 OR inventory_updated > 0 OR image_updated > 0 THEN
            SET p_status = 0;
            SET p_message = 'Product updated successfully.';
        ELSE
            SET p_status = 1;
            SET p_message = 'Error while updating product.';
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcessCartItems` (IN `cartId` INT)   BEGIN
    DECLARE p_productId INT DEFAULT 0;
    DECLARE p_cartItemQuantity INT DEFAULT 0;
    DECLARE p_inventoryQuantity INT DEFAULT 0;
    DECLARE finishedItem INT DEFAULT 0;

    DECLARE item_cursor CURSOR FOR SELECT product_id, quantity FROM cart_item WHERE cart_id = cartId;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET finishedItem = 1;

    OPEN item_cursor;
    item_loop: LOOP
        FETCH item_cursor INTO p_productId, p_cartItemQuantity;
        IF finishedItem THEN 
            LEAVE item_loop;
        END IF;

        SELECT product_quantity INTO p_inventoryQuantity FROM Inventory WHERE product_id = p_productId;

        IF p_inventoryQuantity = 0 THEN
            DELETE FROM cart_item WHERE product_id = p_productId AND cart_id = cartId;
        ELSEIF p_inventoryQuantity < p_cartItemQuantity THEN
            UPDATE cart_item SET quantity = p_inventoryQuantity WHERE product_id = p_productId AND cart_id = cartId;
        END IF;
    END LOOP item_loop;

    CLOSE item_cursor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegisterUser` (IN `p_username` VARCHAR(40), IN `p_password` VARCHAR(60), IN `p_email` VARCHAR(100), OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
    DECLARE user_exists INT;
    DECLARE valid_username INT;

    IF p_username IS NULL OR p_password IS NULL OR p_email IS NULL THEN
        SET p_status = 1;
        SET p_message = 'Incorrect registration parameters.';
    ELSE
        SET valid_username = (CHAR_LENGTH(p_username) >= 5 AND CHAR_LENGTH(p_username) <= 40 AND p_username RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź0-9]+$');
        IF NOT valid_username THEN
            SET p_status = 1;
            SET p_message = 'Username must contain 5-40 characters, including letters and numbers.';
        ELSE
            SELECT COUNT(*) INTO user_exists FROM user 
            WHERE user_login = p_username OR user_email = p_email;

            IF user_exists > 0 THEN
                SET p_status = 1;
                SET p_message = 'Username or email already exists.';
            ELSEIF NOT (p_email RLIKE '^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$') THEN
                SET p_status = 1;
                SET p_message = 'Email must be a valid email format.';
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
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `StartCartReservation` (IN `p_userId` INT)   BEGIN
	DECLARE p_cartId INT DEFAULT 0;
    DECLARE p_cartReserved INT DEFAULT 0;
    DECLARE p_cartReservationTime DATETIME DEFAULT NULL;
    DECLARE p_productId INT DEFAULT 0;
    DECLARE p_quantity INT DEFAULT 0;
    DECLARE finished INT DEFAULT 0;
    DECLARE cur CURSOR FOR SELECT product_id, quantity FROM cart_item WHERE cart_id = p_cartId;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
      
    IF p_userId IS NOT NULL AND p_userId >= 0 THEN 
      -- Updating user's cart before reservation
      CALL UpdateAllCarts();
      
	  -- Getting user's cart id
      SELECT id INTO p_cartId FROM cart WHERE user_id = p_userId AND (cart_reserved IS NULL OR cart_reserved = 0);
      IF p_cartID IS NOT NULL AND p_cartID >= 0 THEN
          
        -- Updating cart's reservation if the cart is not already reserved
        SELECT cart_reserved, cart_reservation_time INTO p_cartReserved, p_cartReservationTime from cart where id = p_cartId;
        IF p_cartReserved = 0 AND p_cartReservationTime IS NULL THEN
            UPDATE cart SET cart_reserved = 1, cart_reservation_time = NOW() WHERE user_id = p_userId AND id = p_cartId;

            OPEN cur;
            read_loop: LOOP
              FETCH cur INTO p_productId, p_quantity;
              IF finished THEN 
                LEAVE read_loop;
              END IF;

			  -- Subtracting the quantity od reserved items from Inventory
              UPDATE Inventory SET product_quantity = product_quantity - p_quantity WHERE product_id = p_productId;

            END LOOP read_loop;
            CLOSE cur;
        END IF;
      END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateAllCarts` ()   BEGIN
    DECLARE p_cartId INT DEFAULT 0;
    DECLARE p_cartReserved INT DEFAULT 0;
    DECLARE p_cartReservationTime DATETIME DEFAULT NULL;
    DECLARE finishedCart INT DEFAULT 0;

    DECLARE cart_cursor CURSOR FOR SELECT id FROM cart;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET finishedCart = 1;

    OPEN cart_cursor;
    cart_loop: LOOP
        FETCH cart_cursor INTO p_cartId;
        IF finishedCart THEN 
            LEAVE cart_loop;
        END IF;

        SELECT cart_reserved, cart_reservation_time INTO p_cartReserved, p_cartReservationTime FROM cart WHERE id = p_cartId LIMIT 1;
        IF p_cartReserved = 0 AND p_cartReservationTime IS NULL THEN
            CALL ProcessCartItems(p_cartId);
        END IF;
    END LOOP cart_loop;

    CLOSE cart_cursor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateCart` (IN `p_userId` INT)   BEGIN
    DECLARE p_cartId INT DEFAULT 0;
    DECLARE p_cartReserved INT DEFAULT 0;
    DECLARE p_cartReservationTime DATETIME DEFAULT NULL;
    DECLARE p_productId INT DEFAULT 0;
    DECLARE p_inventoryQuantity INT DEFAULT 0;
    DECLARE p_cartItemQuantity INT DEFAULT 0;
    DECLARE finished INT DEFAULT 0;

    DECLARE item_cursor CURSOR FOR SELECT product_id, quantity FROM cart_item WHERE cart_id = p_cartId;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;

    IF p_userId IS NOT NULL AND p_userId >= 0 THEN 
        -- Getting user's cart id
        SELECT id, cart_reserved, cart_reservation_time INTO p_cartId, p_cartReserved, p_cartReservationTime FROM cart WHERE user_id = p_userId LIMIT 1;

        -- Iterating through cart items
        IF p_cartId IS NOT NULL AND p_cartId >= 0 AND p_cartReserved = 0 AND p_cartReservationTime IS NULL THEN
            OPEN item_cursor;
            item_loop: LOOP
                FETCH item_cursor INTO p_productId, p_cartItemQuantity;
                IF finished THEN 
                    LEAVE item_loop;
                END IF;

                -- Getting product quantity from user's cart and inventory 
                SELECT product_quantity INTO p_inventoryQuantity FROM Inventory WHERE product_id = p_productId;

                -- Updating cart content based on Inventory
                IF (p_inventoryQuantity <= 0 AND p_cartItemQuantity >= 0) OR (p_cartItemQuantity <= 0) THEN
                    DELETE FROM cart_item WHERE product_id = p_productId AND cart_id = p_cartId;
                ELSEIF p_inventoryQuantity < p_cartItemQuantity THEN
                    UPDATE cart_item SET quantity = p_inventoryQuantity WHERE product_id = p_productId AND cart_id = p_cartId;
                END IF;
            END LOOP item_loop;
            CLOSE item_cursor;
        END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUserAddress` (IN `p_userId` INT, IN `p_userAddressId` INT, IN `p_userFirstName` VARCHAR(100), IN `p_userLastName` VARCHAR(100), IN `p_userEmail` VARCHAR(255), IN `p_userPhoneNumber` VARCHAR(12), IN `p_userHomeAddress` VARCHAR(100), IN `p_userCity` VARCHAR(100), IN `p_userPostalCode` VARCHAR(6), IN `p_userState` VARCHAR(100), IN `p_userCountry` VARCHAR(100), OUT `p_status` INT, OUT `p_message` VARCHAR(255))   BEGIN
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
    ELSEIF NOT (p_userEmail RLIKE '^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$') THEN
    	SET p_status = 1;
    	SET p_message = 'Email must be a valid email format.';    
    ELSEIF NOT (p_userPhoneNumber RLIKE '^\\+[0-9]{11}$') AND 
    	   NOT (p_userPhoneNumber RLIKE '^[0-9]{9}$') THEN
    	SET p_status = 1;
    	SET p_message = 'Phone number must be either 12 characters with a leading + and 11 digits, or 9 digits.';
    ELSEIF NOT (p_userHomeAddress RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź0-9/\\-. ]+$') THEN
    	SET p_status = 1;
    	SET p_message = 'Home address must only contain letters, digits, /\\-., and spaces.';
    ELSEIF NOT (p_userPostalCode RLIKE '^[0-9]{2}-[0-9]{3}$') THEN
        SET p_status = 1;
        SET p_message = 'Postal code must be in the format 00-000.';
    ELSEIF NOT (p_userCity RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') OR
           NOT (p_userState RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') OR
           NOT (p_userCountry RLIKE '^[A-Za-zĄąĆćĘęŁłŃńÓóŚśŻżŹź./ -]+$') THEN
        SET p_status = 1;
        SET p_message = 'City, state and country name must only contain letters, digits, ./-, and spaces.';
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
-- Struktura tabeli dla tabeli `admin_table`
--

CREATE TABLE IF NOT EXISTS `admin_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_login` varchar(64) DEFAULT NULL,
  `admin_password` varchar(60) DEFAULT NULL,
  `date_created` date DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`id`, `admin_login`, `admin_password`, `date_created`) VALUES
(2, '57689564bcb5bbacc387a513b3cde90cb6f6e93d766efbbb035c91a75f7f452d', '$2y$10$yi4rKB5ZhFB5I5YTjIu3FOrB7mrgDOSYOpIqop3Eh/eUWjxGzcoC2', '2024-01-12');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'Foreign key from User',
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cart_reserved` tinyint(1) DEFAULT 0,
  `cart_reservation_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(23, 7),
(29, 50),
(30, 30),
(31, 75),
(32, 100),
(33, 40),
(34, 25),
(35, 40);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table for emails that agreed to newsletter';

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_address`
--

CREATE TABLE IF NOT EXISTS `order_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL COMMENT 'Foreign key from order_details',
  `order_firstname` varchar(100) DEFAULT 'Not specified',
  `order_lastname` varchar(100) DEFAULT 'Not specified',
  `order_email` varchar(255) DEFAULT 'Not specified',
  `order_phone` varchar(12) DEFAULT NULL,
  `order_homeaddress` varchar(100) DEFAULT 'Not specified',
  `order_city` varchar(100) DEFAULT 'Not specified',
  `order_postalcode` varchar(6) DEFAULT NULL,
  `order_state` varchar(100) DEFAULT 'Not specified',
  `order_country` varchar(100) DEFAULT 'Not specified',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_address`
--

INSERT INTO `order_address` (`id`, `order_id`, `order_firstname`, `order_lastname`, `order_email`, `order_phone`, `order_homeaddress`, `order_city`, `order_postalcode`, `order_state`, `order_country`) VALUES
(16, 16, 'Marta', 'Ambroziak', 'ambroziak.m@onet.pl', '+48516633874', 'Starosty Kosa 10/21', 'Ostrołęka', '07-410', 'Mazowieckie', 'Poland');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'Foreign key from user_id',
  `order_price` decimal(5,2) NOT NULL DEFAULT 0.00,
  `order_payment_form` varchar(100) DEFAULT NULL,
  `order_delivery` varchar(100) DEFAULT NULL,
  `order_status` varchar(100) DEFAULT NULL,
  `order_created_date` date NOT NULL DEFAULT current_timestamp(),
  `order_finished_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `user_id`, `order_price`, `order_payment_form`, `order_delivery`, `order_status`, `order_created_date`, `order_finished_date`) VALUES
(16, NULL, 56.50, 'Card', 'Standard', 'Pending', '2024-01-13', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL COMMENT 'Foreign key from order_details',
  `product_id` int(11) DEFAULT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT 0,
  `product_subtotal_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `product_quantity`, `product_subtotal_price`) VALUES
(19, 16, 23, 3, 46.50);

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
  `product_price` decimal(5,2) NOT NULL DEFAULT 0.00,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `supplier_id`, `product_name`, `product_description_long`, `product_price`, `date_added`) VALUES
(23, 13, 2, 'Coconut Brown Bear', 'The Brown Coconut Bear is a delightful and unique plush toy that captures the hearts of all ages. Designed to resemble a friendly bear with a distinct coconut-themed pattern, this toy combines the comforting features of a classic teddy bear with a playful tropical twist. Its soft, brown fur is reminiscent of a coconuts rugged exterior, while its snuggly texture offers an inviting, warm embrace.', 15.50, '2024-01-12 18:09:31'),
(29, 15, 3, 'Classic Sneaker Charm Miniatures', 'Step into style with our Classic Sneaker Charm Miniatures! Perfect for adding a touch of cool to your plush pal, these mini sneakers are meticulously crafted to resemble the iconic high-top design. Made with durable materials and detailed stitching, they\\\\&#39;re not only stylish but also built to last. Each pair features real lace-up fronts, adding authenticity and a dash of fun to dressing up your stuffed companion. Suitable for a wide range of plush sizes, these mini sneakers will ensure your cuddly friend is the trendiest pal around. Whether strolling in the park or displayed on your shelf, these charming kicks are sure to be a conversation starter. Lace up and let your plushie\\\\&#39;s personality shine!', 14.99, '2024-01-19 01:56:52'),
(30, 15, 6, 'Plushie Paparazzi Camera', 'Capture the imagination with our Plushie Paparazzi Camera, the perfect accessory for your plush pal\\&#39;s adventurous side. This mini replica camera, complete with a realistic design and a mock strap for easy attachment, will turn your stuffed friend into a photographer in no time! With intricate detailing, including lens grooves and dials, it is an excellent choice for interactive play or to add to the thematic display of your plush collection. Whether your plushie is \\&#39;shooting\\&#39; in the great outdoors or posing in a playful scene, this camera adds an element of storytelling and creativity to your plush pal\\&#39;s world. Snap up this accessory and watch as your plushies capture moments in their charming, imaginary world.', 18.99, '2024-01-19 06:46:30'),
(31, 13, 1, 'Smarty Paws Plushie Spectacles', 'Add a touch of intelligence and charm to your stuffed pal with our Smarty Paws Plushie Spectacles. These miniature glasses, crafted with meticulous attention to detail, feature a classic round frame with a sleek golden finish and tinted lenses. Perfect for bookworm plushies or to give a wise look to your old-time teddy, these spectacles fit snugly on a variety of plush sizes. They are not only a fun addition to your plushies wardrobe but also a great way to encourage a love for reading and knowledge in a cute, tangible form. Let your plush pal look the part of a distinguished intellectual or a seasoned professor with these quaint and adorable spectacles!', 9.99, '2024-01-19 06:48:01'),
(32, 15, 6, 'Geek Chic Miniature Glasses', 'Introducing the \\&#34;Geek Chic Miniature Glasses\\&#34; – the ultimate accessory for your intellectual plush pal! These delicately framed, round glasses with clear lenses exude a smart and sophisticated vibe, perfect for any plushie ready to hit the books or take on the day with a studious look. The thin gold frames add a touch of elegance, while the adjustable arms ensure a comfortable fit for a variety of plush sizes. Whether for a photo shoot, a plushie meet-up, or to simply', 8.99, '2024-01-19 06:50:46'),
(33, 15, 3, 'Cotton Candy Kicks for Plushies', 'Brighten up your plushie\\\\&#39;s wardrobe with our \\\\&#34;Cotton Candy Kicks for Plushies,\\\\&#34; the sweetest addition to any stuffed companion\\\\&#39;s attire. These miniature sneakers come in a delightful pastel pink, reminiscent of the joyful hues of cotton candy. The white laces and classic design give these tiny shoes an authentic look, while the soft fabric ensures they\\\\&#39;re easy to slip onto your plush pal\\\\&#39;s feet. Ideal for a plushie\\\\&#39;s day out or as a charming accessory for your stuffed friend\\\\&#39;s ensemble, these kicks will add a pop of color and playfulness to any plush collection. Get ready to strut in style with these irresistibly cute plushie sneakers', 12.99, '2024-01-19 06:52:14'),
(34, 13, 1, 'Whisker Whispers Plushie Cat', 'Meet Whisker Whispers, the plushie cat that\\&#39;s purring its way into hearts with its soft, grey fur and those big, sparkling blue eyes. Each detail, from the delicate pink inner ears to the embroidered paws, has been lovingly crafted for an adorable finish. This cuddly feline friend is perfect for cat lovers of all ages, offering a comforting hug and a dash of playful charm. The Whisker Whispers cat isn\\&#39;t just a stuffed animal; it\\&#39;s a companion for cozy nights, a confidant for secret whispers, and a charming friend for life\\&#39;s adventures. Adopt this gentle plushie soul today, and let the soothing purrs of contentment fill your home.', 24.99, '2024-01-19 06:53:38'),
(35, 13, 2, 'Emperor\'s Embrace Cuddly Penguin Pal', 'Embrace the chill with the Emperor\'s Embrace; Cuddly Penguin Pal, a royal addition to any plush collection. Dressed in a charming icy blue hue, this plush penguin stands proud with its adorable crown, signaling it\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&#39;s ready for any playful coronation. Its soft, fluffy texture and kind, sparkling eyes invite warm cuddles and endless adventures in imaginary ice kingdoms. Perfect for both young dreamers and the young at heart, this penguin plushie is not only a snuggly companion for cold nights but also a delightful buddy for day-to-day discoveries. Make a place in your home for this lovable Emperor, and watch as it waddles its way into your warmest affections.', 24.99, '2024-01-19 06:54:51');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_image_path` varchar(200) DEFAULT NULL COMMENT 'Path to image',
  `image_description` text DEFAULT NULL COMMENT 'Description used to alt attribute',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table for product images';

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `product_image_path`, `image_description`) VALUES
(12, 23, 'assets/products/base_bear.png', 'Brown plushie bear on table.'),
(18, 29, 'assets/products/accessories_1.png', 'Black miniature sneakers'),
(19, 30, 'assets/products/accessories_2.png', 'Miniature black camera'),
(20, 31, 'assets/products/accessories_3.png', 'Lavander spectacles'),
(21, 32, 'assets/products/accessories_4.png', 'Transparent spectacles'),
(22, 33, 'assets/products/accessories_5.png', 'Mini pink kicks'),
(23, 34, 'assets/products/base_cat.png', 'Grey plushie cat'),
(24, 35, 'assets/products/base_penguin.png', 'Blue penguin plushie');

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
  `user_email` varchar(255) DEFAULT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `UC_user_login_unique` (`user_login`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_login`, `user_password`, `user_email`, `date_created`) VALUES
(60, 'Eteiz', '$2y$10$EL4Bt.qlZ6RqmHlVCrsbq.VoSRAolQggy/6oyswD03Z340jq4DE8O', 'm.ambroziak.contact@gmail.com', '2024-01-19');

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
  `user_phone` varchar(12) DEFAULT NULL,
  `user_homeaddress` varchar(100) DEFAULT 'Not specified',
  `user_city` varchar(100) DEFAULT 'Not specified',
  `user_postalcode` varchar(6) DEFAULT NULL,
  `user_state` varchar(100) DEFAULT 'Not specified',
  `user_country` varchar(100) DEFAULT 'Not specified',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_phone`, `user_homeaddress`, `user_city`, `user_postalcode`, `user_state`, `user_country`) VALUES
(44, 60, 'Marta', 'Ambroziak', 'm.ambroziak.contact@gmail.com', '+48123123123', 'Lorem Ipsum 21/24', 'Lorem', '01-234', 'Mazowieckie', 'Poland');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `order_address`
--
ALTER TABLE `order_address`
  ADD CONSTRAINT `order_address_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `RestartCartReservation` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
  DECLARE p_cartId INT;
  DECLARE p_productId INT;
  DECLARE p_quantity INT;
  DECLARE finished INT DEFAULT 0;

  DECLARE cur CURSOR FOR 
    SELECT cart.id, cart_item.product_id, cart_item.quantity 
    FROM cart
    JOIN cart_item ON cart.id = cart_item.cart_id
    WHERE cart.cart_reserved = 1 AND cart.cart_reservation_time <= NOW() - INTERVAL 15 MINUTE;

  DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;

  OPEN cur;

  read_loop: LOOP
    FETCH cur INTO p_cartId, p_productId, p_quantity;
    IF finished THEN 
      LEAVE read_loop;
    END IF;
    
    -- Update product quantities in Inventory
    UPDATE Inventory
    SET product_quantity = product_quantity + p_quantity
    WHERE product_id = p_productId;

    -- Reset cart records
    UPDATE cart
    SET cart_reserved = 0, cart_reservation_time = NULL
    WHERE id = p_cartId AND cart_reserved = 1;

  END LOOP;

  CLOSE cur;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
