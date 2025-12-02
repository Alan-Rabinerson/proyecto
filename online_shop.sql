-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 02-12-2025 a las 02:01:49
-- Versión del servidor: 11.5.2-MariaDB
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `online_shop`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `024_automaticOrders`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `024_automaticOrders` ()   BEGIN
    DECLARE var_number_of_added_items INT;
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
            -- Insertar pedido CON la talla del carrito y un status aleatorio
            INSERT INTO 024_orders_table (customer_id, product_id, size, quantity, order_date, address_id, method_id, status)
            SELECT 
              customer_id, 
              product_id, 
              size,  -- talla del carrito
              quantity, 
              NOW(), 
              024_get_address(var_customer_id), 
              024_get_payment_method(var_customer_id),
              ELT(FLOOR(1 + RAND() * 4), 'DELIVERED', 'EN-ROUTE', 'PROCESSING', '') AS status
            FROM 024_shopping_cart
            WHERE customer_id = var_customer_id AND product_id = var_product_id;
            
            DELETE FROM 024_shopping_cart 
            WHERE customer_id = var_customer_id AND product_id = var_product_id;
            
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
    DECLARE var_size VARCHAR(10);
    DECLARE i INT;
    
    SET i = 1;

    WHILE i <= var_number_of_items DO
        SET var_customer_id = FLOOR(1+RAND()*10);
        SET var_product_id = FLOOR(1+RAND()*8);
        SET var_quantity = FLOOR(1+RAND()*10);
        -- Asignar talla aleatoria
        SET var_size = ELT(FLOOR(1 + RAND() * 6), 'XS', 'S', 'M', 'L', 'XL', 'XXL');
        SET i = i + 1;
        
        INSERT INTO 024_shopping_cart (customer_id, product_id, quantity, size)
        VALUES (var_customer_id, var_product_id, var_quantity, var_size)
        ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity);
    END WHILE;
END$$

--
-- Funciones
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

DROP FUNCTION IF EXISTS `024_get_random_valid_size`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `024_get_random_valid_size` (`var_product_id` INT) RETURNS VARCHAR(10) CHARSET latin1 COLLATE latin1_bin DETERMINISTIC BEGIN
    DECLARE valid_size VARCHAR(10);
    
    SELECT size INTO valid_size
    FROM 024_product_sizes
    WHERE product_id = var_product_id
    ORDER BY RAND()
    LIMIT 1;
    
    RETURN valid_size;
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

--
-- Estructura de tabla para la tabla `024_address`
--

DROP TABLE IF EXISTS `024_address`;
CREATE TABLE IF NOT EXISTS `024_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_address`
--

INSERT INTO `024_address` (`address_id`, `street`, `city`, `province`, `zip_code`) VALUES
(1, '1234 Main St', 'Mahon', 'Islas Baleares', '07701'),
(2, '5678 1st St', 'Barcelona', 'Cataluña', '08011'),
(3, '9101 2nd St', 'Madrid', 'Comunidad de Madrid', '28001'),
(4, '1123 3rd St', 'Sevilla', 'Andalucia', '41001'),
(5, '4567 4th St', 'Granada', 'Andalucia', '18001'),
(6, '8910 5th St', 'Zaragoza', 'Aragon', '50001'),
(7, '2345 6th St', 'Valencia', 'Comunidad Valenciana', '46001'),
(8, '6789 7th St', 'Barcelona', 'Cataluña', '08035'),
(9, '1012 8th St', 'Mahon', 'Islas Baleares', '07702'),
(10, '1213 9th St', 'Madrid', 'Comunidad de Madrid', '28003'),
(11, 'Avinguda Fort De Leau 32 3D', 'Mahón', 'Islas Baleares', '07701'),
(12, 'Avinguda Fort De Leau 32 3D', 'Mahón', 'Islas Baleares', '07701'),
(14, 'Avinguda Fort De Leau 32 3D', 'Mahón', 'Islas Baleares', '07701');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_address_customer`
--

DROP TABLE IF EXISTS `024_address_customer`;
CREATE TABLE IF NOT EXISTS `024_address_customer` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`,`customer_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_address_customer`
--

INSERT INTO `024_address_customer` (`address_id`, `customer_id`) VALUES
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
(10, 10),
(9, 11),
(14, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_category`
--

DROP TABLE IF EXISTS `024_category`;
CREATE TABLE IF NOT EXISTS `024_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_category`
--

INSERT INTO `024_category` (`category_id`, `name`, `description`) VALUES
(1, 'Male', 'Clothes for men'),
(2, 'Women', 'All women related clothing'),
(3, 'Sweater', 'All of rhe different sweaters'),
(4, 'Short sleeved t-shirt', 'All of the different short sleeved t-shirts'),
(5, 'Footwear', 'All footwear related products'),
(6, 'Long sleeved t-shirt', 'All of the different long sleeved tees'),
(7, 'Jackets', 'All of the different jackets'),
(8, 'Hoodies', 'Urban hoodies and sweatshirts'),
(9, 'Caps & Hats', 'Streetwear headwear collection'),
(10, 'Accessories', 'Bags, belts and street accessories'),
(11, 'Pants', 'Joggers, cargo pants and streetwear bottoms'),
(12, 'Sneakers', 'Premium streetwear sneakers');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_customers`
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
  `type` set('admin','customer') NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_customers`
--

INSERT INTO `024_customers` (`customer_id`, `first_name`, `last_name`, `email`, `username`, `password`, `phone`, `birth_date`, `type`) VALUES
(1, 'John', 'Doe', 'example@gmail.com', 'johndoe', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', '1234567891', '1965-11-25', 'customer'),
(2, 'Jane', 'Doe', 'example@hotmail.com', 'janedoe', '123456', '1234567891', '1999-06-11', 'customer'),
(3, 'John', 'Smith', 'example@outlook.com', 'johnsmith', '123456', '1234567890', '1985-03-30', 'customer'),
(4, 'Jane', 'Smith', 'janesmith@gmail.com', 'janesmith', '123456', '1234567890', '1977-11-22', 'customer'),
(5, 'John', 'Johnson', 'johnjohnson@outlook.com', 'johnjohnson', '123456', '1234567890', '1983-09-22', 'customer'),
(6, 'Jane', 'Johnson', 'janejohnson@gmail.com', 'janejohnson', '123456', '1234567890', '1980-03-09', 'customer'),
(7, 'John', 'Brown', 'johnbrown@gmail.com', 'johnbrown', '123456', '1234567890', '1999-10-06', 'customer'),
(8, 'Jane', 'Brown', 'janebrown@gmail.com', 'janebrown', '123456', '1234567890', '1998-09-26', 'customer'),
(9, 'John', 'Williams', 'johnwilliams@hotmail.com', 'johnwilliams', '123456', '1234567890', '1989-08-22', 'customer'),
(10, 'Jane', 'Williams', 'janewilliams@outlook.com', 'janewilliams', '123456', '1234567890', '2001-12-27', 'customer'),
(11, 'Alan', 'Rabinerson', 'alanrabinerson@gmail.com', 'alanR', '123456', '694480533', '2001-10-24', 'admin'),
(12, 'Enrique', 'Vizcaino', 'enrique@gmail.com', 'enrique@gmail.com', 'dwesteacher', '123456789', '1975-11-26', 'admin');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `024_customers_view`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `024_customers_view`;
CREATE TABLE IF NOT EXISTS `024_customers_view` (
`customer_id` int(11)
,`first_name` varchar(100)
,`last_name` varchar(100)
,`email` varchar(100)
,`username` varchar(100)
,`password` varchar(100)
,`phone` varchar(100)
,`birth_date` date
,`type` set('admin','customer')
,`address_id` int(11)
,`street` varchar(100)
,`city` varchar(100)
,`province` varchar(100)
,`zip_code` varchar(100)
,`method_id` int(11)
,`method_name` varchar(100)
,`account_number` varchar(100)
,`card_number` varchar(100)
,`expiration_date` varchar(100)
,`security_code` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_orders_table`
--

DROP TABLE IF EXISTS `024_orders_table`;
CREATE TABLE IF NOT EXISTS `024_orders_table` (
  `order_number` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` set('XS','S','M','L','XL','XXL') NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `order_date` datetime NOT NULL,
  `address_id` int(11) NOT NULL,
  `method_id` int(11) NOT NULL,
  `status` set('DELIVERED','EN-ROUTE','PROCESSING','') NOT NULL,
  PRIMARY KEY (`order_number`,`product_id`,`customer_id`,`order_id`) USING BTREE,
  KEY `product_id` (`product_id`),
  KEY `method_id` (`method_id`),
  KEY `customer_id` (`customer_id`),
  KEY `address_id` (`address_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_orders_table`
--

INSERT INTO `024_orders_table` (`order_number`, `order_id`, `customer_id`, `product_id`, `size`, `quantity`, `price`, `order_date`, `address_id`, `method_id`, `status`) VALUES
(1, 'A7244158999', 11, 2, 'XS', 1, 24.99, '2025-12-02 01:56:57', 9, 5, 'PROCESSING'),
(2, 'A7244158999', 11, 3, 'S', 3, 179.97, '2025-12-02 01:56:57', 9, 5, 'PROCESSING'),
(3, 'A7244158999', 11, 1, 'XS', 1, 49.99, '2025-12-02 01:56:57', 9, 5, 'PROCESSING');

--
-- Disparadores `024_orders_table`
--
DROP TRIGGER IF EXISTS `trg_orders_before_insert`;
DELIMITER $$
CREATE TRIGGER `trg_orders_before_insert` BEFORE INSERT ON `024_orders_table` FOR EACH ROW BEGIN
  DECLARE init CHAR(1);
  DECLARE minute_ts VARCHAR(16);
  DECLARE existing_order_id VARCHAR(11);

  SELECT UPPER(LEFT(first_name,1))
    INTO init
    FROM 024_customers
    WHERE customer_id = NEW.customer_id
    LIMIT 1;

  SET minute_ts = DATE_FORMAT(NEW.order_date, '%Y-%m-%d %H:%i');

  SELECT order_id
    INTO existing_order_id
    FROM 024_orders_table
    WHERE customer_id = NEW.customer_id
      AND DATE_FORMAT(order_date, '%Y-%m-%d %H:%i') = minute_ts
      AND order_id <> ''
    LIMIT 1;

  IF existing_order_id IS NOT NULL AND existing_order_id <> '' THEN
    SET NEW.order_id = existing_order_id;
  ELSE
    SET NEW.order_id = CONCAT(init, LPAD(FLOOR(RAND() * 10000000000), 10, '0'));
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `024_order_view`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `024_order_view`;
CREATE TABLE IF NOT EXISTS `024_order_view` (
`order_number` int(11)
,`order_id` varchar(11)
,`customer_id` int(11)
,`first_name` varchar(100)
,`last_name` varchar(100)
,`product_id` int(11)
,`product_name` varchar(200)
,`quantity` int(11)
,`size` set('XS','S','M','L','XL','XXL')
,`price` decimal(10,2)
,`total_price` float
,`payment_method` varchar(100)
,`payment_method_id` int(11)
,`order_date` datetime
,`delivery_address` varchar(406)
,`status` set('DELIVERED','EN-ROUTE','PROCESSING','')
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_payment_customer`
--

DROP TABLE IF EXISTS `024_payment_customer`;
CREATE TABLE IF NOT EXISTS `024_payment_customer` (
  `method_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`method_id`,`customer_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_payment_customer`
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
(10, 10),
(5, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_payment_method`
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
-- Volcado de datos para la tabla `024_payment_method`
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
-- Estructura de tabla para la tabla `024_products`
--

DROP TABLE IF EXISTS `024_products`;
CREATE TABLE IF NOT EXISTS `024_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `available_sizes` set('XS','S','M','L','XL','XXL') NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_products`
--

INSERT INTO `024_products` (`product_id`, `name`, `description`, `price`, `supplier`, `available_sizes`) VALUES
(1, 'Sudadera Urban Style', 'Sudadera con capucha de estilo urbano, tejido algodÃ³n 100%, bolsillo canguro.', 49.99, 'UrbanWear SL', 'XS,S,M,L,XL,XXL'),
(2, 'Camiseta Concrete', 'Camiseta de algodón con logo estampado, corte regular.', 24.99, 'Concrete Brands', 'XS,S,M,L,XL,XXL'),
(3, 'Pantalón Cargo Street', 'Pantalón cargo con múltiples bolsillos y tejido resistente, ajuste relajado.', 59.99, 'CargoCo', 'S,M,L,XL,XXL'),
(4, 'Zapatillas Urban', 'Zapatillas deportivas de estilo urbano con suela antideslizante.', 89.99, 'UrbanFeet', 'M,L,XL'),
(5, 'Chaqueta Bomber', 'Chaqueta bomber acolchada, cierre frontal y acabado resistente al agua.', 69.99, 'BomberFactory', 'XS,S,M,L,XL,XXL'),
(6, 'Hoodie Oversized', 'Sudadera oversize con capucha y bolsillo frontal, estilo streetwear.', 41.24, 'OversizeCorp', 'S,M,L,XL'),
(7, 'Gorra Snapback', 'Gorra snapback ajustable con logo bordado.', 23.99, 'CapHouse', 'M'),
(8, 'Ripped Jeans', 'Jeans estilo destroyed con rotos y acabado lavado.', 51.99, 'DenimMasters', 'XS,S,M,L,XL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_products_view`
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
-- Estructura de tabla para la tabla `024_product_category`
--

DROP TABLE IF EXISTS `024_product_category`;
CREATE TABLE IF NOT EXISTS `024_product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_product_category`
--

INSERT INTO `024_product_category` (`product_id`, `category_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(5, 4),
(7, 4),
(17, 5),
(18, 5),
(19, 5),
(20, 5),
(6, 6),
(8, 6),
(9, 7),
(10, 7),
(11, 7),
(12, 7),
(1, 8),
(2, 8),
(3, 8),
(4, 8),
(21, 9),
(22, 9),
(23, 10),
(24, 10),
(13, 11),
(14, 11),
(15, 11),
(16, 11),
(17, 12),
(18, 12),
(19, 12),
(20, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_product_sizes`
--

DROP TABLE IF EXISTS `024_product_sizes`;
CREATE TABLE IF NOT EXISTS `024_product_sizes` (
  `product_id` int(11) NOT NULL,
  `size` enum('XS','S','M','L','XL','XXL') NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_id`,`size`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_product_sizes`
--

INSERT INTO `024_product_sizes` (`product_id`, `size`, `stock`) VALUES
(1, 'XS', 12),
(1, 'S', 23),
(1, 'M', 18),
(1, 'L', 21),
(1, 'XL', 13),
(1, 'XXL', 19),
(2, 'XS', 8),
(2, 'S', 28),
(2, 'M', 30),
(2, 'L', 24),
(2, 'XL', 33),
(2, 'XXL', 14),
(3, 'S', 11),
(3, 'M', 14),
(3, 'L', 19),
(3, 'XL', 8),
(3, 'XXL', 8),
(4, 'M', 9),
(4, 'L', 19),
(4, 'XL', 10),
(5, 'XS', 5),
(5, 'S', 5),
(5, 'M', 5),
(5, 'L', 8),
(5, 'XL', 6),
(5, 'XXL', 3),
(6, 'S', 18),
(6, 'M', 19),
(6, 'L', 25),
(6, 'XL', 12),
(7, 'M', 108),
(8, 'XS', 3),
(8, 'S', 8),
(8, 'M', 12),
(8, 'L', 16),
(8, 'XL', 14);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `024_product_size_availability`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `024_product_size_availability`;
CREATE TABLE IF NOT EXISTS `024_product_size_availability` (
`product_id` int(11)
,`product_name` varchar(200)
,`size` enum('XS','S','M','L','XL','XXL')
,`stock` int(11)
,`availability_status` varchar(16)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `024_product_view`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `024_product_view`;
CREATE TABLE IF NOT EXISTS `024_product_view` (
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_shopping_cart`
--

DROP TABLE IF EXISTS `024_shopping_cart`;
CREATE TABLE IF NOT EXISTS `024_shopping_cart` (
  `shopping_cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` set('XS','S','M','L','XL','XXL') NOT NULL,
  PRIMARY KEY (`shopping_cart_id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=728 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `024_shopping_cart`
--

INSERT INTO `024_shopping_cart` (`shopping_cart_id`, `customer_id`, `product_id`, `quantity`, `size`) VALUES
(316, 5, 3, 4, 'S'),
(517, 7, 7, 4, 'S'),
(521, 7, 7, 9, 'S'),
(544, 2, 1, 8, 'L'),
(546, 5, 3, 4, 'M'),
(553, 8, 2, 7, 'M'),
(559, 2, 2, 3, 'XXL'),
(563, 8, 7, 7, 'M'),
(570, 8, 4, 3, 'L'),
(571, 7, 5, 9, 'L'),
(573, 8, 8, 8, 'S'),
(578, 2, 4, 8, 'XL'),
(582, 5, 6, 9, 'S'),
(584, 8, 2, 6, 'M'),
(586, 4, 8, 7, 'L'),
(589, 9, 7, 3, 'L'),
(596, 7, 3, 6, 'M'),
(597, 8, 2, 9, 'XXL'),
(602, 8, 4, 2, 'L'),
(604, 7, 5, 8, 'S'),
(605, 2, 2, 9, 'L'),
(607, 5, 3, 2, 'S'),
(608, 9, 6, 1, 'XS'),
(609, 3, 1, 4, 'L'),
(611, 6, 4, 8, 'XXL'),
(613, 7, 5, 1, 'XL'),
(614, 3, 4, 1, 'S'),
(616, 5, 4, 5, 'XS'),
(620, 8, 6, 1, 'S'),
(624, 8, 1, 2, 'L'),
(626, 9, 5, 4, 'XXL'),
(627, 10, 7, 2, 'XL'),
(630, 7, 7, 1, 'L'),
(633, 6, 4, 5, 'S'),
(634, 9, 7, 8, 'XXL'),
(637, 7, 5, 8, 'XS'),
(639, 5, 5, 5, 'L'),
(640, 6, 3, 8, 'XXL'),
(643, 3, 2, 3, 'XXL'),
(645, 9, 1, 8, 'M'),
(647, 9, 6, 1, 'M'),
(649, 8, 5, 6, 'L'),
(650, 8, 4, 9, 'XXL'),
(707, 9, 6, 7, 'L'),
(708, 6, 1, 7, 'S'),
(709, 10, 3, 5, 'L'),
(710, 4, 2, 10, 'XXL'),
(711, 1, 2, 9, 'XL'),
(712, 3, 8, 1, 'S'),
(713, 4, 7, 4, 'XXL'),
(714, 4, 7, 8, 'M'),
(715, 8, 4, 8, 'XL'),
(716, 4, 5, 8, 'XS'),
(717, 5, 8, 6, 'L'),
(718, 2, 8, 5, 'L'),
(719, 2, 4, 4, 'XL'),
(720, 8, 2, 9, 'L'),
(721, 5, 6, 9, 'XS'),
(722, 10, 3, 9, 'L'),
(723, 10, 8, 2, 'XL'),
(724, 6, 2, 4, 'XS'),
(725, 2, 7, 8, 'S'),
(726, 10, 7, 6, 'S'),
(727, 3, 5, 4, 'XL');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `024_shopping_cart_view`
-- (Véase abajo para la vista actual)
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
-- Estructura Stand-in para la vista `024_total_income_per_month`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `024_total_income_per_month`;
CREATE TABLE IF NOT EXISTS `024_total_income_per_month` (
`total_income` double
,`MONTH` int(3)
,`YEAR` int(5)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `024_total_money_spent_view`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `024_total_money_spent_view`;
CREATE TABLE IF NOT EXISTS `024_total_money_spent_view` (
`customer_id` int(11)
,`full_name` varchar(210)
,`total_money_spent` double
,`YEAR` int(5)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `024_wishlist`
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
-- Estructura para la vista `024_customers_view`
--
DROP TABLE IF EXISTS `024_customers_view`;

DROP VIEW IF EXISTS `024_customers_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `024_customers_view`  AS SELECT `c`.`customer_id` AS `customer_id`, `c`.`first_name` AS `first_name`, `c`.`last_name` AS `last_name`, `c`.`email` AS `email`, `c`.`username` AS `username`, `c`.`password` AS `password`, `c`.`phone` AS `phone`, `c`.`birth_date` AS `birth_date`, `c`.`type` AS `type`, `a`.`address_id` AS `address_id`, `a`.`street` AS `street`, `a`.`city` AS `city`, `a`.`province` AS `province`, `a`.`zip_code` AS `zip_code`, `pm`.`method_id` AS `method_id`, `pm`.`method_name` AS `method_name`, `pm`.`account_number` AS `account_number`, `pm`.`card_number` AS `card_number`, `pm`.`expiration_date` AS `expiration_date`, `pm`.`security_code` AS `security_code` FROM ((((`024_customers` `c` join `024_payment_customer` `pc` on(`c`.`customer_id` = `pc`.`customer_id`)) join `024_payment_method` `pm` on(`pc`.`method_id` = `pm`.`method_id`)) join `024_address_customer` `ac` on(`c`.`customer_id` = `ac`.`customer_id`)) join `024_address` `a` on(`ac`.`address_id` = `a`.`address_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `024_order_view`
--
DROP TABLE IF EXISTS `024_order_view`;

DROP VIEW IF EXISTS `024_order_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `024_order_view`  AS SELECT `o`.`order_number` AS `order_number`, `o`.`order_id` AS `order_id`, `o`.`customer_id` AS `customer_id`, `c`.`first_name` AS `first_name`, `c`.`last_name` AS `last_name`, `p`.`product_id` AS `product_id`, `p`.`name` AS `product_name`, `o`.`quantity` AS `quantity`, `o`.`size` AS `size`, `p`.`price` AS `price`, `o`.`price` AS `total_price`, `pm`.`method_name` AS `payment_method`, `o`.`method_id` AS `payment_method_id`, `o`.`order_date` AS `order_date`, concat_ws(', ',`a`.`street`,`a`.`city`,`a`.`province`,`a`.`zip_code`) AS `delivery_address`, `o`.`status` AS `status` FROM ((((`024_orders_table` `o` join `024_customers` `c` on(`o`.`customer_id` = `c`.`customer_id`)) join `024_address` `a` on(`o`.`address_id` = `a`.`address_id`)) join `024_products` `p` on(`o`.`product_id` = `p`.`product_id`)) join `024_payment_method` `pm` on(`o`.`method_id` = `pm`.`method_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `024_product_size_availability`
--
DROP TABLE IF EXISTS `024_product_size_availability`;

DROP VIEW IF EXISTS `024_product_size_availability`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `024_product_size_availability`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`name` AS `product_name`, `ps`.`size` AS `size`, `ps`.`stock` AS `stock`, CASE WHEN `ps`.`stock` > 10 THEN 'En Stock' WHEN `ps`.`stock` > 0 THEN 'Últimas Unidades' ELSE 'Agotado' END AS `availability_status` FROM (`024_products` `p` join `024_product_sizes` `ps` on(`p`.`product_id` = `ps`.`product_id`)) ORDER BY `p`.`product_id` ASC, field(`ps`.`size`,'XS','S','M','L','XL','XXL') ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `024_product_view`
--
DROP TABLE IF EXISTS `024_product_view`;

DROP VIEW IF EXISTS `024_product_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `024_product_view`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`name` AS `name`, `p`.`price` AS `price`, `p`.`stock` AS `stock`, `c`.`name` AS `category` FROM ((`024_product_category` `pc` join `024_products` `p` on(`pc`.`product_id` = `p`.`product_id`)) join `024_category` `c` on(`pc`.`category_id` = `c`.`category_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `024_shopping_cart_view`
--
DROP TABLE IF EXISTS `024_shopping_cart_view`;

DROP VIEW IF EXISTS `024_shopping_cart_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `024_shopping_cart_view`  AS SELECT `sc`.`shopping_cart_id` AS `shopping_cart_id`, `sc`.`customer_id` AS `customer_id`, `c`.`first_name` AS `first_name`, `c`.`last_name` AS `last_name`, `sc`.`product_id` AS `product_id`, `p`.`name` AS `name`, `sc`.`quantity` AS `quantity`, `p`.`price` AS `price`, `p`.`price`* `sc`.`quantity` AS `total_price` FROM ((`024_shopping_cart` `sc` join `024_customers` `c` on(`sc`.`customer_id` = `c`.`customer_id`)) join `024_products` `p` on(`sc`.`product_id` = `p`.`product_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `024_total_income_per_month`
--
DROP TABLE IF EXISTS `024_total_income_per_month`;

DROP VIEW IF EXISTS `024_total_income_per_month`;
CREATE ALGORITHM=UNDEFINED DEFINER=`Alan`@`localhost` SQL SECURITY DEFINER VIEW `024_total_income_per_month`  AS SELECT sum(`024_order_view`.`total_price`) AS `total_income`, month(`024_order_view`.`order_date`) AS `MONTH`, year(`024_order_view`.`order_date`) AS `YEAR` FROM `024_order_view` GROUP BY year(`024_order_view`.`order_date`), month(`024_order_view`.`order_date`) ORDER BY '' ASC, '' ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `024_total_money_spent_view`
--
DROP TABLE IF EXISTS `024_total_money_spent_view`;

DROP VIEW IF EXISTS `024_total_money_spent_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`Alan`@`localhost` SQL SECURITY DEFINER VIEW `024_total_money_spent_view`  AS SELECT `024_order_view`.`customer_id` AS `customer_id`, `024_full_name`(`024_order_view`.`first_name`,`024_order_view`.`last_name`) AS `full_name`, sum(`024_order_view`.`total_price`) AS `total_money_spent`, year(`024_order_view`.`order_date`) AS `YEAR` FROM `024_order_view` WHERE year(`024_order_view`.`order_date`) = 2024 GROUP BY `024_order_view`.`customer_id` ORDER BY '' DESC ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `024_address_customer`
--
ALTER TABLE `024_address_customer`
  ADD CONSTRAINT `adress_customer_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `024_address` (`address_id`),
  ADD CONSTRAINT `adress_customer_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `024_customers` (`customer_id`);

--
-- Filtros para la tabla `024_orders_table`
--
ALTER TABLE `024_orders_table`
  ADD CONSTRAINT `order_table_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `024_products` (`product_id`),
  ADD CONSTRAINT `order_table_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `024_address` (`address_id`),
  ADD CONSTRAINT `order_table_ibfk_3` FOREIGN KEY (`method_id`) REFERENCES `024_payment_method` (`method_id`),
  ADD CONSTRAINT `order_table_ibfk_4` FOREIGN KEY (`customer_id`) REFERENCES `024_customers` (`customer_id`);

--
-- Filtros para la tabla `024_payment_customer`
--
ALTER TABLE `024_payment_customer`
  ADD CONSTRAINT `payment_customer_ibfk_1` FOREIGN KEY (`method_id`) REFERENCES `024_payment_method` (`method_id`),
  ADD CONSTRAINT `payment_customer_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `024_customers` (`customer_id`);

--
-- Filtros para la tabla `024_product_category`
--
ALTER TABLE `024_product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `024_products` (`product_id`),
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `024_category` (`category_id`);

--
-- Filtros para la tabla `024_product_sizes`
--
ALTER TABLE `024_product_sizes`
  ADD CONSTRAINT `024_product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `024_products` (`product_id`);

--
-- Filtros para la tabla `024_shopping_cart`
--
ALTER TABLE `024_shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `024_customers` (`customer_id`),
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `024_products` (`product_id`);

DELIMITER $$
--
-- Eventos
--
DROP EVENT IF EXISTS `024_insert_test_data_event`$$
CREATE DEFINER=`root`@`localhost` EVENT `024_insert_test_data_event` ON SCHEDULE EVERY 2 SECOND STARTS '2025-11-17 17:22:45' ENDS '2025-11-18 17:22:45' ON COMPLETION PRESERVE DISABLE DO BEGIN
CALL 024_automaticOrders();
SELECT * FROM 024_order_view;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
