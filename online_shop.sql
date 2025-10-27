-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 13, 2025 at 02:48 PM
-- Server version: 11.5.2-MariaDB
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_shop`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `024_automaticOrders`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `024_automaticOrders` ()   BEGIN
	DECLARE var_number_of_added_items INT ; 
    DECLARE var_number_of_orders INT;
    
    SET var_number_of_added_items = FLOOR(16*RAND()+5);
    SET var_number_of_orders = FLOOR(5+RAND()*2);
    
    CALL 024_shopping_cart_data_dump(var_number_of_added_items);
    CALL 024_order_data_dump(var_number_of_orders);


END$$

DROP PROCEDURE IF EXISTS `024_order_data_dump`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `024_order_data_dump` (IN `var_number_of_orders` INT)   BEGIN
    DECLARE var_customer_id INT;
    DECLARE var_product_id INT;

    DECLARE i INT;

    SET i = 1;

    WHILE i <= var_number_of_orders DO
        SET var_customer_id = (SELECT customer_id FROM 024_shopping_cart ORDER BY RAND() LIMIT 1);
        SET var_product_id = (SELECT product_id FROM 024_shopping_cart WHERE customer_id = var_customer_id ORDER BY RAND() LIMIT 1);
        IF var_customer_id IS NOT NULL THEN
            INSERT INTO 024_order_table (customer_id, product_id, quantity, order_date, adress_id, method_id)
            SELECT customer_id, product_id, quantity, NOW(), 024_get_address(var_customer_id), 024_get_payment_method(customer_id)
            FROM 024_shopping_cart
            WHERE customer_id = var_customer_id AND product_id = var_product_id;
            DELETE FROM 024_shopping_cart WHERE customer_id = var_customer_id AND product_id = var_product_id ;
            SET i = i + 1;   
        END IF;
    END WHILE;
	SELECT * FROM 024_order_view;
END$$

DROP PROCEDURE IF EXISTS `024_shopping_cart_data_dump`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `024_shopping_cart_data_dump` (IN `var_number_of_items` INT)   BEGIN

    DECLARE var_customer_id INT;
    DECLARE var_product_id INT;
    DECLARE var_quantity INT;
    DECLARE i INT;
    
    
    SET i = 1;


    WHILE i <= var_number_of_items DO
        SET var_customer_id = FLOOR(1+RAND()*10);
        SET var_product_id = FLOOR(1+RAND()*10);
        SET var_quantity = FLOOR(1+RAND()*10);
        SET i = i + 1;
        INSERT INTO 024_shopping_cart (customer_id, product_id, quantity)
        VALUES (var_customer_id, var_product_id, var_quantity)  
        ON DUPLICATE KEY UPDATE quantity = var_quantity + quantity; 
    END WHILE;
    SELECT * FROM 024_shopping_cart_view;
END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `024_age`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `024_age` (`birthdate` DATE) RETURNS INT(11) DETERMINISTIC RETURN FLOOR((DATEDIFF(CURDATE(),birthdate)/365.25))$$

DROP FUNCTION IF EXISTS `024_full_name`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `024_full_name` (`first_name` VARCHAR(100), `last_name` VARCHAR(100)) RETURNS VARCHAR(210) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC RETURN CONCAT(first_name,' ',last_name)$$

DROP FUNCTION IF EXISTS `024_get_address`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `024_get_address` (`var_customer_id` INT) RETURNS INT(11)  BEGIN
RETURN (SELECT adress_id FROM 024_adress_customer WHERE customer_id = var_customer_id LIMIT 1);
END$$

DROP FUNCTION IF EXISTS `024_get_payment_method`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `024_get_payment_method` (`var_customer_id` INT) RETURNS INT(11)  BEGIN
RETURN (SELECT method_id FROM 024_payment_customer WHERE customer_id = var_customer_id LIMIT 1);
END$$

DROP FUNCTION IF EXISTS `024_membership_level`$$
CREATE DEFINER=`Alan`@`localhost` FUNCTION `024_membership_level` (`var_money_spent` INT) RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE var_level_name VARCHAR(50);
    
    IF var_money_spent > 1500 THEN 
        SET var_level_name = 'Diamond';
    ELSEIF var_money_spent > 1000 AND var_money_spent<1500 THEN
        SET var_level_name = 'Platinum';
    ELSEIF var_money_spent > 500 AND var_money_spent <1000 THEN
        SET var_level_name = 'Gold';
    ELSE
        SET var_level_name = 'Silver';
    END IF;
    
    RETURN var_level_name;
END$$

DELIMITER ;

-- --------------------------------------------------------
DROP TABLE IF EXISTS `024_shopping_cart_view`;
DROP TABLE IF EXISTS `024_shopping_cart`;
DROP TABLE IF EXISTS `024_order_view`;
DROP TABLE IF EXISTS `024_order_table`;
DROP TABLE IF EXISTS `024_adress_customer`;
DROP TABLE IF EXISTS `024_payment_customer`;
DROP TABLE IF EXISTS `024_products_category`;
DROP TABLE IF EXISTS `024_payment_method`;
DROP TABLE IF EXISTS `024_adress`;
DROP TABLE IF EXISTS `024_category`;
DROP TABLE IF EXISTS `024_products`;
DROP TABLE IF EXISTS `024_customers`;

--
-- Table structure for table `024_adress`
--





CREATE TABLE IF NOT EXISTS `024_adress` (
  `adress_id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  PRIMARY KEY (`adress_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_adress`
--

INSERT INTO `024_adress` (`adress_id`, `street`, `city`, `province`, `zip_code`) VALUES
(1, '1234 Main St', 'Mahon', 'Islas Baleares', '07701'),
(2, '5678 1st St', 'Barcelona', 'Cataluña', '08011'),
(3, '9101 2nd St', 'Madrid', 'Comunidad de Madrid', '28001'),
(4, '1123 3rd St', 'Sevilla', 'Andalucia', '41001'),
(5, '4567 4th St', 'Granada', 'Andalucia', '18001'),
(6, '8910 5th St', 'Zaragoza', 'Aragon', '50001'),
(7, '2345 6th St', 'Valencia', 'Comunidad Valenciana', '46001'),
(8, '6789 7th St', 'Barcelona', 'Cataluña', '08035'),
(9, '1011 8th St', 'Mahon', 'Islas Baleares', '07702'),
(10, '1213 9th St', 'Madrid', 'Comunidad de Madrid', '28003');

-- --------------------------------------------------------

--
-- Table structure for table `024_adress_customer`
--

DROP TABLE IF EXISTS `024_adress_customer`;
CREATE TABLE IF NOT EXISTS `024_adress_customer` (
  `adress_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`adress_id`,`customer_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_adress_customer`
--

INSERT INTO `024_adress_customer` (`adress_id`, `customer_id`) VALUES
(1, 1),
(5, 1),
(2, 2),
(7, 2),
(3, 3),
(9, 3),
(2, 4),
(4, 4),
(4, 5),
(5, 5),
(6, 6),
(7, 7),
(8, 7),
(8, 8),
(10, 8),
(1, 9),
(9, 9),
(3, 10),
(10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `024_category`
--

DROP TABLE IF EXISTS `024_category`;
CREATE TABLE IF NOT EXISTS `024_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_category`
--

INSERT INTO `024_category` (`category_id`, `name`, `description`) VALUES
(1, 'Football', 'All football related products'),
(2, 'Basketball', 'All basketball related products'),
(3, 'Tennis', 'All tennis related products'),
(4, 'Clothing', 'All clothing related products'),
(5, 'Footwear', 'All footwear related products'),
(6, 'Outdoor', 'All outdoor related products'),
(7, 'Golf', 'All golf related products'),
(8, 'Running', 'All running related products');

-- --------------------------------------------------------

--
-- Table structure for table `024_customers`
--

DROP TABLE IF EXISTS `024_customers`;
CREATE TABLE IF NOT EXISTS `024_customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `birth_date` date DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_customers`
--

INSERT INTO `024_customers` (`customer_id`, `first_name`, `last_name`, `email`, `username`, `password`, `phone`, `birth_date`) VALUES
(1, 'John', 'Doe', 'example@gmail.com', 'johndoe', '123456', '1234567891', '1965-11-25'),
(2, 'Jane', 'Doe', 'example@hotmail.com', 'janedoe', '123456', '1234567891', '1999-06-11'),
(3, 'John', 'Smith', 'example@outlook.com', 'johnsmith', '123456', '1234567890', '1985-03-30'),
(4, 'Jane', 'Smith', 'janesmith@gmail.com', 'janesmith', '123456', '1234567890', '1977-11-22'),
(5, 'John', 'Johnson', 'johnjohnson@outlook.com', 'johnjohnson', '123456', '1234567890', '1983-09-22'),
(6, 'Jane', 'Johnson', 'janejohnson@gmail.com', 'janejohnson', '123456', '1234567890', '1980-03-09'),
(7, 'John', 'Brown', 'johnbrown@gmail.com', 'johnbrown', '123456', '1234567890', '1999-10-06'),
(8, 'Jane', 'Brown', 'janebrown@gmail.com', 'janebrown', '123456', '1234567890', '1998-09-26'),
(9, 'John', 'Williams', 'johnwilliams@hotmail.com', 'johnwilliams', '123456', '1234567890', '1989-08-22'),
(10, 'Jane', 'Williams', 'janewilliams@outlook.com', 'janewilliams', '123456', '1234567890', '2001-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `024_orders_table`
--

DROP TABLE IF EXISTS `024_orders_table`;
CREATE TABLE IF NOT EXISTS `024_orders_table` (
  `order_number` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `address_id` int(11) NOT NULL,
  `method_id` int(11) NOT NULL,
  PRIMARY KEY (`order_number`,`product_id`,`customer_id`),
  KEY `product_id` (`product_id`),
  KEY `method_id` (`method_id`),
  KEY `customer_id` (`customer_id`),
  KEY `address_id` (`address_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_orders_table`
--

INSERT INTO `024_orders_table` (`order_number`, `customer_id`, `product_id`, `quantity`, `order_date`, `address_id`, `method_id`) VALUES
(1, 1, 1, 1, '2024-03-12 00:00:00', 1, 1),
(1, 1, 9, 1, '2024-03-12 00:00:00', 1, 1),
(2, 2, 2, 2, '2024-01-02 00:00:00', 2, 2),
(2, 2, 4, 6, '2024-01-02 00:00:00', 2, 2),
(3, 3, 3, 3, '2024-08-12 00:00:00', 3, 3),
(3, 3, 10, 2, '2024-01-03 00:00:00', 3, 3),
(4, 4, 4, 4, '2024-04-01 00:00:00', 4, 4),
(4, 4, 5, 7, '2024-04-01 00:00:00', 4, 4),
(5, 5, 1, 3, '2024-01-05 00:00:00', 5, 5),
(5, 5, 5, 5, '2024-06-04 00:00:00', 5, 5),
(6, 4, 6, 8, '2024-06-13 00:00:00', 6, 6),
(6, 6, 6, 6, '2024-10-24 00:00:00', 6, 6),
(7, 7, 2, 4, '2024-01-07 00:00:00', 7, 7),
(7, 7, 7, 7, '2024-01-07 00:00:00', 7, 7),
(8, 8, 7, 9, '2024-01-08 00:00:00', 8, 8),
(8, 8, 8, 8, '2024-05-11 00:00:00', 8, 8),
(9, 9, 9, 9, '2024-07-04 00:00:00', 9, 9),
(10, 10, 8, 10, '2024-12-17 00:00:00', 10, 10),
(10, 10, 10, 10, '2024-04-03 00:00:00', 10, 10),
(11, 9, 3, 5, '2024-08-12 00:00:00', 9, 9),
(12, 9, 3, 9, '2025-03-12 00:50:06', 1, 1),
(13, 1, 9, 2, '2025-03-12 00:50:06', 1, 1),
(14, 4, 6, 8, '2025-03-12 00:50:06', 2, 2),
(15, 7, 2, 9, '2025-03-12 00:50:06', 7, 7),
(16, 6, 4, 10, '2025-03-12 00:50:06', 6, 6),
(17, 2, 9, 8, '2025-03-12 00:50:06', 2, 2),
(18, 5, 8, 7, '2025-03-12 00:50:06', 4, 4),
(19, 8, 7, 8, '2025-03-12 00:50:06', 8, 8),
(20, 5, 9, 2, '2025-03-12 00:50:06', 4, 4),
(21, 4, 2, 7, '2025-03-12 00:50:06', 2, 2),
(22, 7, 6, 7, '2025-03-12 00:50:06', 7, 7),
(23, 9, 5, 8, '2025-03-12 00:50:06', 1, 1),
(24, 7, 9, 5, '2025-03-12 00:50:06', 7, 7),
(25, 8, 10, 5, '2025-03-12 00:50:06', 8, 8),
(26, 3, 6, 1, '2025-03-12 00:50:06', 3, 3),
(27, 4, 4, 6, '2025-03-12 00:50:06', 2, 2),
(28, 5, 10, 5, '2025-03-12 00:50:06', 4, 4),
(29, 7, 7, 3, '2025-03-12 00:50:06', 7, 7),
(30, 6, 3, 5, '2025-03-12 00:50:06', 6, 6),
(31, 1, 4, 5, '2025-03-12 00:50:06', 1, 1),
(32, 7, 1, 3, '2025-03-12 00:50:06', 7, 7),
(33, 3, 7, 5, '2025-03-12 00:50:06', 3, 3),
(34, 8, 1, 2, '2025-03-12 00:50:06', 8, 8),
(35, 3, 10, 8, '2025-03-12 00:50:06', 3, 3),
(36, 2, 7, 9, '2025-03-12 00:50:06', 2, 2),
(37, 3, 1, 7, '2025-03-12 00:50:06', 3, 3),
(38, 4, 10, 5, '2025-03-12 00:50:06', 2, 2),
(39, 9, 9, 5, '2025-03-12 00:50:06', 1, 1),
(40, 8, 9, 10, '2025-03-12 00:50:06', 8, 8),
(41, 10, 4, 1, '2025-03-12 00:50:06', 3, 3),
(42, 9, 1, 8, '2025-03-12 00:50:06', 1, 1),
(43, 1, 8, 8, '2025-03-12 00:50:06', 1, 1),
(44, 6, 8, 1, '2025-03-12 00:50:06', 6, 6),
(45, 4, 5, 4, '2025-03-12 00:50:06', 2, 2),
(46, 10, 9, 3, '2025-03-12 00:50:06', 3, 3),
(47, 4, 7, 9, '2025-03-12 00:50:06', 2, 2),
(48, 6, 1, 5, '2025-03-12 00:50:06', 6, 6),
(49, 2, 5, 8, '2025-03-12 00:50:06', 2, 2),
(50, 9, 4, 1, '2025-03-12 00:50:06', 1, 1),
(51, 6, 5, 9, '2025-03-12 00:50:06', 6, 6),
(52, 2, 4, 6, '2025-03-12 00:50:06', 2, 2),
(53, 8, 2, 7, '2025-03-12 00:50:06', 8, 8),
(54, 10, 3, 5, '2025-03-12 00:53:08', 3, 3),
(55, 4, 5, 2, '2025-03-12 00:53:08', 2, 2),
(56, 3, 5, 5, '2025-03-12 00:53:08', 3, 3),
(57, 7, 3, 3, '2025-03-12 00:53:08', 7, 7),
(58, 6, 10, 4, '2025-03-12 00:53:08', 6, 6),
(59, 2, 3, 10, '2025-03-12 00:53:08', 2, 2),
(60, 5, 10, 5, '2025-03-12 00:53:08', 4, 4),
(61, 9, 6, 3, '2025-03-12 00:53:08', 1, 1),
(62, 4, 3, 5, '2025-03-12 00:53:08', 2, 2),
(63, 6, 4, 3, '2025-03-12 00:53:08', 6, 6),
(64, 8, 1, 8, '2025-03-12 00:53:08', 8, 8),
(65, 8, 5, 2, '2025-03-12 00:53:08', 8, 8),
(66, 5, 2, 7, '2025-03-12 00:53:08', 4, 4),
(67, 4, 10, 7, '2025-03-12 00:53:08', 2, 2),
(68, 9, 3, 9, '2025-03-12 00:53:08', 1, 1),
(69, 6, 6, 10, '2025-03-12 00:53:08', 6, 6),
(70, 1, 2, 8, '2025-03-12 00:53:08', 1, 1),
(71, 5, 7, 8, '2025-03-12 00:53:08', 4, 4),
(72, 2, 6, 4, '2025-03-12 00:53:08', 2, 2),
(73, 3, 4, 3, '2025-03-12 00:53:08', 3, 3),
(74, 4, 6, 10, '2025-03-12 00:53:08', 2, 2),
(75, 2, 7, 9, '2025-03-12 00:53:08', 2, 2),
(76, 1, 6, 9, '2025-03-12 00:53:08', 1, 1),
(77, 7, 2, 10, '2025-03-12 00:53:08', 7, 7),
(78, 10, 2, 9, '2025-03-12 00:53:08', 3, 3),
(79, 2, 10, 2, '2025-03-12 00:53:08', 2, 2),
(80, 10, 10, 10, '2025-03-12 00:53:08', 3, 3),
(81, 1, 9, 1, '2025-03-12 00:53:08', 1, 1),
(82, 10, 8, 8, '2025-03-12 00:53:08', 3, 3),
(83, 6, 3, 5, '2025-03-12 00:53:08', 6, 6),
(84, 5, 8, 5, '2025-03-12 00:53:08', 4, 4),
(85, 1, 7, 10, '2025-03-12 00:53:08', 1, 1),
(86, 1, 1, 1, '2025-03-12 00:53:08', 1, 1),
(87, 5, 4, 6, '2025-03-12 00:53:08', 4, 4),
(88, 10, 5, 6, '2025-03-12 00:53:08', 3, 3),
(89, 2, 2, 6, '2025-03-12 00:53:08', 2, 2),
(90, 9, 10, 1, '2025-03-12 00:53:08', 1, 1),
(91, 4, 4, 9, '2025-03-12 00:53:08', 2, 2),
(92, 6, 5, 5, '2025-03-12 00:53:08', 6, 6),
(93, 5, 5, 8, '2025-03-12 00:53:08', 4, 4),
(94, 7, 7, 4, '2025-03-12 00:54:26', 7, 7),
(95, 6, 10, 9, '2025-03-12 00:54:26', 6, 6),
(96, 5, 9, 10, '2025-03-12 00:54:26', 4, 4),
(97, 2, 5, 9, '2025-03-12 00:54:26', 2, 2),
(98, 9, 1, 8, '2025-03-12 00:54:26', 1, 1),
(99, 5, 3, 8, '2025-03-12 00:54:26', 4, 4),
(100, 9, 3, 9, '2025-03-17 16:53:48', 1, 1),
(101, 10, 4, 8, '2025-03-17 16:53:48', 3, 3),
(102, 10, 4, 1, '2025-03-17 16:53:48', 3, 3),
(104, 2, 6, 7, '2025-03-17 16:53:48', 2, 2),
(105, 2, 6, 4, '2025-03-17 16:53:48', 2, 2),
(107, 9, 4, 9, '2025-03-17 16:53:48', 1, 1),
(108, 9, 4, 5, '2025-03-17 16:53:48', 1, 1),
(110, 8, 7, 9, '2025-03-17 16:53:48', 8, 8);

-- --------------------------------------------------------

--
-- Stand-in structure for view `024_order_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `024_order_view`;
CREATE TABLE IF NOT EXISTS `024_order_view` (
);

-- --------------------------------------------------------

--
-- Table structure for table `024_payment_customer`
--

DROP TABLE IF EXISTS `024_payment_customer`;
CREATE TABLE IF NOT EXISTS `024_payment_customer` (
  `method_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`method_id`,`customer_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_payment_customer`
--

INSERT INTO `024_payment_customer` (`method_id`, `customer_id`) VALUES
(1, 1),
(5, 1),
(2, 2),
(7, 2),
(3, 3),
(9, 3),
(2, 4),
(4, 4),
(4, 5),
(5, 5),
(6, 6),
(7, 7),
(8, 7),
(8, 8),
(10, 8),
(1, 9),
(9, 9),
(3, 10),
(10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `024_payment_method`
--

DROP TABLE IF EXISTS `024_payment_method`;
CREATE TABLE IF NOT EXISTS `024_payment_method` (
  `method_id` int(11) NOT NULL AUTO_INCREMENT,
  `method_name` varchar(100) NOT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `card_number` varchar(100) DEFAULT NULL,
  `expiration_date` varchar(100) DEFAULT NULL,
  `security_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_payment_method`
--

INSERT INTO `024_payment_method` (`method_id`, `method_name`, `account_number`, `card_number`, `expiration_date`, `security_code`) VALUES
(1, 'Visa Debit Card', NULL, '123456789012', '12/25', '123'),
(2, 'Mastercard Credit Card', NULL, '987654321098', '12/25', '321'),
(3, 'Bank transfer', '234567890', NULL, NULL, NULL),
(4, 'Paypal', '345678901', NULL, NULL, NULL),
(5, 'Visa Credit Card', NULL, '15784522', '12/25', '123'),
(6, 'Mastercard Debit Card', NULL, '987654321098', '12/25', '321'),
(7, 'Bank transfer', '234567890', NULL, NULL, NULL),
(8, 'Mastercard Credit Card', NULL, '987654321907', '12/25', '321'),
(9, 'Bank transfer', '212367890', NULL, NULL, NULL),
(10, 'Visa Debit Card', NULL, '134567901234', '12/25', '123');

-- --------------------------------------------------------

--
-- Table structure for table `024_products`
--

DROP TABLE IF EXISTS `024_products`;
CREATE TABLE IF NOT EXISTS `024_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `supplier` varchar(100) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_products`
--

INSERT INTO `024_products` (`product_id`, `name`, `description`, `price`, `stock`, `supplier`) VALUES
(1, 'Laliga football', 'Official laliga ball', 120.00, 100, 'Supplier 1'),
(2, 'Wilson basketball', 'Official Wilson NBA game ball', 115.00, 200, 'Supplier 2'),
(3, 'Garden Goal', 'Small goal to play football outdoors', 30.00, 300, 'Supplier 3'),
(4, 'Nike sleeveless Shirt', 'Basic white sleeveless nike shirt', 40.00, 400, 'Supplier 4'),
(5, 'Spalding indoor ball', 'Spalding indoor basketball', 50.00, 500, 'Supplier 2'),
(6, 'Tennis Racket', 'Wilson Tennis Racket', 60.00, 600, 'Supplier 4'),
(7, 'Sports Socks', 'White adidas sports socks', 5.00, 700, 'Supplier 1'),
(8, 'FC Barlona Home Kit', 'Official nike Fc Barrcelona 2024/25 Home kit', 80.00, 800, 'Supplier 3'),
(9, 'LA Lakers 2024/25 city edition', 'Official 2024/25 LA Lakers Nike city edition jersey', 170.00, 900, 'Supplier 3'),
(10, 'Jordan 1 white/red', 'Nike Air Jordan 1 shoes red/white', 100.00, 1000, 'Supplier 1');

-- --------------------------------------------------------

--
-- Table structure for table `024_products_view`
--

DROP TABLE IF EXISTS `024_products_view`;
CREATE TABLE IF NOT EXISTS `024_products_view` (
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Table structure for table `024_product_category`
--

DROP TABLE IF EXISTS `024_product_category`;
CREATE TABLE IF NOT EXISTS `024_product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_product_category`
--

INSERT INTO `024_product_category` (`product_id`, `category_id`) VALUES
(1, 1),
(3, 1),
(8, 1),
(2, 2),
(5, 2),
(9, 2),
(10, 2),
(6, 3),
(4, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 5),
(3, 6);

-- --------------------------------------------------------

--
-- Stand-in structure for view `024_product_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `024_product_view`;
CREATE TABLE IF NOT EXISTS `024_product_view` (
`product_id` int(11)
,`name` varchar(200)
,`price` decimal(10,2)
,`stock` int(11)
,`category` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `024_shopping_cart`
--

DROP TABLE IF EXISTS `024_shopping_cart`;
CREATE TABLE IF NOT EXISTS `024_shopping_cart` (
  `shopping_cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`shopping_cart_id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `024_shopping_cart`
--

INSERT INTO `024_shopping_cart` (`shopping_cart_id`, `customer_id`, `product_id`, `quantity`) VALUES
(3, 1, 7, 1),
(4, 5, 2, 3),
(7, 8, 9, 7),
(8, 7, 6, 6),
(9, 4, 1, 2),
(16, 8, 9, 8),
(20, 8, 2, 2),
(22, 3, 9, 6),
(30, 4, 1, 3),
(31, 1, 7, 3),
(36, 5, 10, 6),
(38, 4, 10, 6),
(39, 1, 4, 8),
(41, 3, 6, 1),
(42, 9, 10, 3),
(44, 4, 9, 4),
(47, 1, 7, 3),
(54, 7, 5, 3),
(55, 8, 4, 6),
(60, 3, 10, 3),
(62, 9, 6, 3),
(63, 8, 9, 2),
(67, 8, 2, 3),
(70, 9, 10, 3),
(74, 4, 10, 10),
(75, 8, 1, 2),
(77, 1, 1, 1),
(81, 3, 6, 9),
(82, 8, 2, 7),
(88, 9, 6, 6),
(89, 1, 4, 9),
(91, 5, 2, 4),
(102, 1, 2, 7),
(103, 8, 10, 4),
(105, 7, 2, 7),
(107, 10, 5, 6),
(108, 4, 1, 2),
(112, 5, 7, 9),
(120, 6, 3, 3),
(121, 7, 6, 10),
(125, 6, 9, 7),
(128, 4, 1, 5),
(130, 3, 3, 9),
(131, 5, 7, 8),
(137, 6, 8, 4),
(140, 3, 3, 7),
(143, 10, 3, 8),
(144, 1, 1, 9),
(145, 1, 7, 2),
(148, 2, 8, 4),
(149, 4, 1, 1),
(150, 10, 9, 4),
(154, 1, 5, 1),
(155, 8, 9, 10),
(156, 7, 1, 3),
(158, 5, 10, 6),
(160, 2, 9, 10),
(161, 3, 3, 7),
(162, 3, 6, 9),
(163, 5, 10, 4),
(165, 7, 10, 9),
(167, 9, 8, 2),
(169, 3, 9, 8),
(171, 3, 6, 10),
(173, 4, 9, 3),
(175, 8, 2, 8),
(176, 4, 4, 10),
(177, 5, 5, 8),
(179, 7, 4, 9),
(180, 4, 2, 9),
(181, 8, 1, 9),
(183, 5, 7, 9),
(184, 5, 8, 4),
(188, 10, 1, 8),
(189, 4, 8, 5),
(191, 8, 1, 10),
(192, 5, 5, 10),
(193, 6, 10, 1),
(194, 6, 6, 1),
(195, 1, 10, 7),
(196, 5, 4, 4),
(198, 4, 6, 6),
(199, 3, 7, 6),
(200, 8, 10, 5),
(201, 5, 2, 2),
(202, 5, 9, 10),
(204, 5, 5, 8),
(205, 8, 3, 10),
(206, 10, 2, 10),
(208, 2, 2, 2),
(209, 3, 8, 1),
(210, 10, 6, 9),
(211, 9, 5, 8),
(212, 5, 10, 6),
(213, 10, 6, 1),
(215, 7, 10, 7),
(216, 6, 10, 9),
(217, 4, 4, 8),
(219, 1, 1, 1),
(220, 10, 8, 1),
(222, 8, 3, 1),
(223, 6, 7, 6),
(224, 8, 2, 5),
(225, 10, 2, 1),
(226, 6, 10, 10),
(227, 10, 9, 3),
(228, 10, 1, 3),
(229, 1, 5, 2),
(230, 5, 9, 9),
(231, 6, 3, 7),
(232, 7, 4, 6),
(233, 10, 10, 1),
(234, 4, 5, 4),
(235, 2, 10, 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `024_shopping_cart_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `024_shopping_cart_view`;
CREATE TABLE IF NOT EXISTS `024_shopping_cart_view` (
`shopping_cart_id` int(11)
,`customer_id` int(11)
,`first_name` varchar(100)
,`last_name` varchar(100)
,`product_id` int(11)
,`name` varchar(200)
,`quantity` int(11)
,`price` decimal(10,2)
,`total_price` decimal(20,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `024_total_income_per_month`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `024_total_income_per_month`;
CREATE TABLE IF NOT EXISTS `024_total_income_per_month` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `024_total_money_spent_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `024_total_money_spent_view`;
CREATE TABLE IF NOT EXISTS `024_total_money_spent_view` (
);

-- --------------------------------------------------------

--
-- Table structure for table `024_wishlist`
--

DROP TABLE IF EXISTS `024_wishlist`;
CREATE TABLE IF NOT EXISTS `024_wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`wishlist_id`,`customer_id`,`product_id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Structure for view `024_order_view`
--
DROP TABLE IF EXISTS `024_order_view`;

DROP VIEW IF EXISTS `024_order_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `024_order_view`  AS SELECT `o`.`order_number` AS `order_number`, `o`.`customer_id` AS `customer_id`, `c`.`first_name` AS `first_name`, `c`.`last_name` AS `last_name`, `o`.`product_id` AS `product_id`, `p`.`name` AS `name`, `o`.`quantity` AS `quantity`, `o`.`order_date` AS `order_date`, `p`.`price` AS `price`, `p`.`price`* `o`.`quantity` AS `total_price`, concat_ws(', ',`a`.`street`,`a`.`city`,`a`.`province`,`a`.`zip_code`) AS `delivery_adress`, `pm`.`method_name` AS `method_name` FROM ((((`024_order_table` `o` join `024_customers` `c` on(`o`.`customer_id` = `c`.`customer_id`)) join `024_products` `p` on(`o`.`product_id` = `p`.`product_id`)) join `024_adress` `a` on(`o`.`adress_id` = `a`.`adress_id`)) join `024_payment_method` `pm` on(`o`.`method_id` = `pm`.`method_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `024_product_view`
--
DROP TABLE IF EXISTS `024_product_view`;

DROP VIEW IF EXISTS `024_product_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `024_product_view`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`name` AS `name`, `p`.`price` AS `price`, `p`.`stock` AS `stock`, `c`.`name` AS `category` FROM ((`024_product_category` `pc` join `024_products` `p` on(`pc`.`product_id` = `p`.`product_id`)) join `024_category` `c` on(`pc`.`category_id` = `c`.`category_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `024_shopping_cart_view`
--
DROP TABLE IF EXISTS `024_shopping_cart_view`;

DROP VIEW IF EXISTS `024_shopping_cart_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `024_shopping_cart_view`  AS SELECT `sc`.`shopping_cart_id` AS `shopping_cart_id`, `sc`.`customer_id` AS `customer_id`, `c`.`first_name` AS `first_name`, `c`.`last_name` AS `last_name`, `sc`.`product_id` AS `product_id`, `p`.`name` AS `name`, `sc`.`quantity` AS `quantity`, `p`.`price` AS `price`, `p`.`price`* `sc`.`quantity` AS `total_price` FROM ((`024_shopping_cart` `sc` join `024_customers` `c` on(`sc`.`customer_id` = `c`.`customer_id`)) join `024_products` `p` on(`sc`.`product_id` = `p`.`product_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `024_total_income_per_month`
--
DROP TABLE IF EXISTS `024_total_income_per_month`;

DROP VIEW IF EXISTS `024_total_income_per_month`;
CREATE ALGORITHM=UNDEFINED DEFINER=`Alan`@`localhost` SQL SECURITY DEFINER VIEW `024_total_income_per_month`  AS SELECT sum(`024_order_view`.`total_price`) AS `total_income`, month(`024_order_view`.`order_date`) AS `MONTH`, year(`024_order_view`.`order_date`) AS `YEAR` FROM `024_order_view` GROUP BY year(`024_order_view`.`order_date`), month(`024_order_view`.`order_date`) ORDER BY '' ASC, '' ASC ;

-- --------------------------------------------------------

--
-- Structure for view `024_total_money_spent_view`
--
DROP TABLE IF EXISTS `024_total_money_spent_view`;

DROP VIEW IF EXISTS `024_total_money_spent_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`Alan`@`localhost` SQL SECURITY DEFINER VIEW `024_total_money_spent_view`  AS SELECT `024_order_view`.`customer_id` AS `customer_id`, `024_full_name`(`024_order_view`.`first_name`,`024_order_view`.`last_name`) AS `full_name`, sum(`024_order_view`.`total_price`) AS `total_money_spent`, year(`024_order_view`.`order_date`) AS `YEAR` FROM `024_order_view` WHERE year(`024_order_view`.`order_date`) = 2024 GROUP BY `024_order_view`.`customer_id` ORDER BY '' DESC ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `024_adress_customer`
--
ALTER TABLE `024_adress_customer`
  ADD CONSTRAINT `adress_customer_ibfk_1` FOREIGN KEY (`adress_id`) REFERENCES `024_adress` (`adress_id`),
  ADD CONSTRAINT `adress_customer_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `024_customers` (`customer_id`);

--
-- Constraints for table `024_orders_table`
--
ALTER TABLE `024_orders_table`
  ADD CONSTRAINT `order_table_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `024_products` (`product_id`),
  ADD CONSTRAINT `order_table_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `024_adress` (`adress_id`),
  ADD CONSTRAINT `order_table_ibfk_3` FOREIGN KEY (`method_id`) REFERENCES `024_payment_method` (`method_id`),
  ADD CONSTRAINT `order_table_ibfk_4` FOREIGN KEY (`customer_id`) REFERENCES `024_customers` (`customer_id`);

--
-- Constraints for table `024_payment_customer`
--
ALTER TABLE `024_payment_customer`
  ADD CONSTRAINT `payment_customer_ibfk_1` FOREIGN KEY (`method_id`) REFERENCES `024_payment_method` (`method_id`),
  ADD CONSTRAINT `payment_customer_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `024_customers` (`customer_id`);

--
-- Constraints for table `024_product_category`
--
ALTER TABLE `024_product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `024_products` (`product_id`),
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `024_category` (`category_id`);

--
-- Constraints for table `024_shopping_cart`
--
ALTER TABLE `024_shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `024_customers` (`customer_id`),
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `024_products` (`product_id`);

DELIMITER $$
--
-- Events
--
DROP EVENT IF EXISTS `024_insert_test_data_event`$$
CREATE DEFINER=`root`@`localhost` EVENT `024_insert_test_data_event` ON SCHEDULE EVERY 1 DAY STARTS '2025-03-17 15:45:48' ENDS '2025-03-21 09:00:00' ON COMPLETION PRESERVE DISABLE DO BEGIN
CALL 024_automaticOrders();
SELECT * FROM 024_order_view;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
