-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 24, 2017 lúc 07:17 PM
-- Phiên bản máy phục vụ: 10.1.22-MariaDB
-- Phiên bản PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `vitinh`
--

DELIMITER $$
--
-- Thủ tục
--
DROP PROCEDURE IF EXISTS `pro_getArticle`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getArticle` (IN `keyword` VARCHAR(255), IN `strCategoryArticleID` VARCHAR(255))  begin
SELECT
    0 AS is_checked
    ,n.id
    ,n.fullname
    ,n.title
    ,n.alias        
    ,n.image
    ,n.intro
    ,n.content
    ,n.description
    ,n.meta_keyword
    ,n.meta_description
    ,n.sort_order
    ,n.status
    ,n.created_at
    ,n.updated_at
	 FROM 
    `article` n
    LEFT JOIN `article_category` ac ON n.id = ac.article_id
    LEFT JOIN `category_article` cate ON ac.category_article_id = cate.id
    WHERE
    (keyword ='' OR trim(lower(n.fullname)) LIKE CONCAT('%',keyword,'%'))
    AND ( ac.category_article_id is null or INSTR(strCategoryArticleID,'#'+ac.category_article_id+'#') > 0)
     GROUP BY 
    n.id
    ,n.fullname
    ,n.title
    ,n.alias        
    ,n.image
    ,n.intro
    ,n.content
    ,n.description
    ,n.meta_keyword
    ,n.meta_description
    ,n.sort_order
    ,n.status
    ,n.created_at
    ,n.updated_at
    ORDER BY n.sort_order ASC;
end$$

DROP PROCEDURE IF EXISTS `pro_getArticleFrontend`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getArticleFrontend` (IN `keyword` VARCHAR(255), IN `category_id` VARCHAR(255))  SELECT
    0 AS is_checked
    ,n.id
    ,n.fullname
	 FROM 
    `article` n
    LEFT JOIN `article_category` ac ON n.id = ac.article_id
    WHERE
    (keyword ='' OR TRIM(LOWER(n.fullname)) LIKE CONCAT('%',keyword,'%'))
    AND (category_id = '#0#' OR INSTR(category_id,'#'+ac.category_article_id+'#') > 0)    
    and n.status=1
     GROUP BY 
    n.id
    ,n.fullname
    ORDER BY n.sort_order ASC$$

DROP PROCEDURE IF EXISTS `pro_getArticleFrontendLimit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getArticleFrontendLimit` (IN `keyword` VARCHAR(255), IN `category_id` VARCHAR(255), IN `position` INT(11), IN `totalItemsPerPage` INT(11))  SELECT
    0 AS is_checked
    ,n.id
    ,n.fullname
    ,n.title
    ,n.alias        
    ,n.image
    ,n.intro
    ,n.content
    ,n.description
    ,n.meta_keyword
    ,n.meta_description
    ,n.sort_order
    ,n.status
    ,n.created_at
    ,n.updated_at
	 FROM 
    `article` n
    LEFT JOIN `article_category` ac ON n.id = ac.article_id
    LEFT JOIN `category_article` cate ON ac.category_article_id = cate.id
    WHERE
    (keyword ='' OR TRIM(LOWER(n.fullname)) LIKE CONCAT('%',keyword,'%'))
    AND (category_id = '#0#' OR INSTR(category_id,'#'+ac.category_article_id+'#') > 0)    
    AND n.status=1
     GROUP BY 
    n.id
    ,n.fullname
    ,n.title
    ,n.alias        
    ,n.image
    ,n.intro
    ,n.content
    ,n.description
    ,n.meta_keyword
    ,n.meta_description
    ,n.sort_order
    ,n.status
    ,n.created_at
    ,n.updated_at
    ORDER BY n.sort_order ASC
    LIMIT `position` , `totalItemsPerPage`$$

DROP PROCEDURE IF EXISTS `pro_getBanner`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getBanner` (IN `keyword` VARCHAR(255) charset utf8)  BEGIN
SELECT 
	0 AS  is_checked
	,n.id
	,n.fullname
	,n.alias
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
	 FROM 
    `banner` n
    WHERE
    (keyword ='' OR LOWER(n.fullname) LIKE CONCAT('%', LOWER(keyword) ,'%'))    
    GROUP BY
	n.id
    	,n.fullname
    	,n.alias
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
    ORDER BY n.sort_order ASC;
    END$$

DROP PROCEDURE IF EXISTS `pro_getCategoryArticle`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getCategoryArticle` (IN `keyword` VARCHAR(255))  BEGIN	
    SELECT
    0 AS is_checked,
	n.id,
	n.fullname,
	n.alias,
	n.parent_id,
	a.fullname AS parent_fullname,
	n.image,
	n.sort_order,
	n.status,
	n.created_at,
	n.updated_at
	FROM 
    `category_article` n
    LEFT JOIN `category_article` a ON n.parent_id = a.id
    WHERE
    ( keyword='' OR  LOWER(n.fullname) LIKE CONCAT('%',keyword,'%')  ) 
    group by
    n.id,
	n.fullname,
	n.alias,
	n.parent_id,
	a.fullname ,
	n.image,
	n.sort_order,
	n.status,
	n.created_at,
	n.updated_at
    ORDER BY n.sort_order ASC       
    ;
END$$

DROP PROCEDURE IF EXISTS `pro_getCategoryArticleLimit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getCategoryArticleLimit` (IN `keyword` VARCHAR(255), IN `position` INT(11), IN `totalItemsPerPage` INT(11))  SELECT 
	0 AS is_checked,
	n.id,
	n.fullname,
	n.alias,
	n.parent_id,
	a.fullname AS parent_fullname,
	n.image,
	n.sort_order,
	n.status,
	n.created_at,
	n.updated_at
	 FROM 
    `category_article` n
    LEFT JOIN `category_article` a ON n.parent_id = a.id
    WHERE
    ( keyword='' OR  LOWER(n.fullname) LIKE CONCAT('%',keyword,'%')  ) 
    group by
    n.id,
	n.fullname,
	n.alias,
	n.parent_id,
	a.fullname,
	n.image,
	n.sort_order,
	n.status,
	n.created_at,
	n.updated_at
    ORDER BY n.sort_order ASC
    LIMIT `position` , totalItemsPerPage$$

DROP PROCEDURE IF EXISTS `pro_getCategoryProduct`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getCategoryProduct` (IN `keyword` VARCHAR(255) CHARSET utf8)  BEGIN
SELECT
    0 AS is_checked,
	n.id,
	n.fullname,
	n.alias,
	n.parent_id,
	a.fullname AS parent_fullname,
	n.image,
	n.sort_order,
	n.status,
	n.created_at,
	n.updated_at
	FROM 
    `category_product` n
    LEFT JOIN `category_product` a ON n.parent_id = a.id
    WHERE
    ( keyword='' OR  LOWER(n.fullname) LIKE CONCAT('%',keyword,'%')  ) 
    group by
    n.id,
	n.fullname,
	n.alias,
	n.parent_id,
	a.fullname,
	n.image,
	n.sort_order,
	n.status,
	n.created_at,
	n.updated_at
    ORDER BY n.sort_order ASC;
END$$

DROP PROCEDURE IF EXISTS `pro_getCategoryProductLimit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getCategoryProductLimit` (IN `keyword` VARCHAR(255) CHARSET utf8, IN `position` INT(11), IN `totalItemsPerPage` INT(11))  SELECT 
	0 AS is_checked,
	n.id,
	n.fullname,
	n.alias,
	n.parent_id,
	a.fullname AS parent_fullname,
	n.image,
	n.sort_order,
	n.status,
	n.created_at,
	n.updated_at
	 FROM 
    `category_product` n
    LEFT JOIN `category_product` a ON n.parent_id = a.id
    WHERE
    ( keyword='' OR  LOWER(n.fullname) LIKE CONCAT('%',keyword,'%')  ) 
    GROUP BY
    n.id,
	n.fullname,
	n.alias,
	n.parent_id,
	a.fullname,
	n.image,
	n.sort_order,
	n.status,
	n.created_at,
	n.updated_at
    ORDER BY n.sort_order ASC
    LIMIT `position` , totalItemsPerPage$$

DROP PROCEDURE IF EXISTS `pro_getCustomer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getCustomer` (IN `keyword` VARCHAR(255) CHARSET utf8)  NO SQL
SELECT
    0 AS is_checked,
	n.id,
	n.username,
	n.password,
	n.email,	
	n.fullname,
    n.address,
    n.phone,
    n.mobilephone,
    n.fax,
    n.status,
    n.sort_order,
	n.created_at,
	n.updated_at
	FROM 
    `customer` n
    WHERE
    ( (keyword='') OR ( LOWER(n.fullname) LIKE CONCAT('%',LOWER(keyword),'%')  ) )
    ORDER BY n.sort_order ASC$$

DROP PROCEDURE IF EXISTS `pro_getGroupMember`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getGroupMember` (IN `keyword` VARCHAR(255))  NO SQL
SELECT
	0 as is_checked
	,n.id
	,n.fullname
	,n.sort_order
	,n.created_at
	,n.updated_at
     FROM 
    `group_member` n
    WHERE
    (keyword ='' OR LOWER(n.fullname) LIKE CONCAT('%', LOWER(keyword) ,'%'))    
    group by
    n.id
	,n.fullname
	,n.sort_order
	,n.created_at
	,n.updated_at
    ORDER BY n.sort_order ASC$$

DROP PROCEDURE IF EXISTS `pro_getInvoice`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getInvoice` (IN `keyword` VARCHAR(255) CHARSET utf8)  NO SQL
SELECT
    0 AS is_checked,
	n.id,
	n.code,
	n.username,
	n.email,	
	n.fullname,
    n.address,
    n.phone,
    n.mobilephone,
    n.fax,
    n.quantity,
    n.total_price,
    n.status,
    n.sort_order,
	n.created_at,
	n.updated_at
	FROM 
    `invoice` n
    WHERE
    ( (keyword='') OR ( LOWER(n.fullname) LIKE CONCAT('%',LOWER(keyword),'%')  ) )
    ORDER BY n.sort_order ASC$$

DROP PROCEDURE IF EXISTS `pro_getMenu`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getMenu` (IN `keyword` VARCHAR(255), IN `menu_type_id` INT(11))  BEGIN
SELECT 
0 AS is_checked
	,n.id
	,n.fullname
	
	,n.site_link
	,n.parent_id
	,a.fullname AS parent_fullname
	,n.menu_type_id
	,n.level
	,n.sort_order
	,n.status
	,n.created_at
	,n.updated_at
	 FROM 
    `menu` n
    LEFT JOIN `menu` a ON n.parent_id = a.id
    WHERE
   ( keyword='' OR  LOWER(n.fullname) LIKE CONCAT('%',keyword,'%')  ) 
    AND (menu_type_id = '' OR n.menu_type_id = menu_type_id)
    group by
    n.id
	,n.fullname
	
	,n.site_link
	,n.parent_id
	,a.fullname 
	,n.menu_type_id
	,n.level
	,n.sort_order
	,n.status
	,n.created_at
	,n.updated_at
    ORDER BY n.sort_order ASC    ;
    END$$

DROP PROCEDURE IF EXISTS `pro_getMenuLimit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getMenuLimit` (IN `keyword` VARCHAR(255), IN `position` INT(11), IN `totalItemsPerPage` INT(11), IN `menu_type_id` INT(11))  SELECT 
	0 AS is_checked,
	n.id
	,n.fullname
	,n.site_link
	,n.parent_id
	,a.fullname AS parent_fullname
	,n.menu_type_id
	,n.level
	,n.sort_order
	,n.status
	,n.created_at
	,n.updated_at
	 FROM 
    `menu` n
    LEFT JOIN `menu` a ON n.parent_id = a.id
    WHERE
    ( keyword='' OR  LOWER(n.fullname) LIKE CONCAT('%',keyword,'%')  ) 
    AND (menu_type_id = 0 OR n.menu_type_id = menu_type_id)
    GROUP BY
    n.id
	,n.fullname
	
	,n.site_link
	,n.parent_id
	,a.fullname 
	,n.menu_type_id
	,n.level
	,n.sort_order
	,n.status
	,n.created_at
	,n.updated_at
    ORDER BY n.sort_order ASC
    LIMIT `position` , totalItemsPerPage$$

DROP PROCEDURE IF EXISTS `pro_getMenuType`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getMenuType` (IN `keyword` VARCHAR(255))  BEGIN
	SELECT 
	0 AS is_checked
	,n.id
	,n.fullname
	,n.theme_location
	,n.sort_order
	,n.created_at
	,n.updated_at
	 FROM 
    `menu_type` n
    WHERE
    (keyword ='' OR LOWER(n.fullname) LIKE CONCAT('%', LOWER(keyword) ,'%'))    
    ORDER BY n.sort_order ASC
    ;
END$$

DROP PROCEDURE IF EXISTS `pro_getModuleArticle`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getModuleArticle` (IN `keyword` VARCHAR(255))  NO SQL
SELECT 
	0 AS  is_checked
	,n.id
	,n.fullname
	,n.article_id
	,n.position
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
	 FROM 
    `module_article` n
    WHERE
    (keyword ='' OR LOWER(n.fullname) LIKE CONCAT('%', LOWER(keyword) ,'%'))    
    GROUP BY
	n.id
    	,n.fullname
	,n.article_id
	,n.position
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
    ORDER BY n.sort_order ASC$$

DROP PROCEDURE IF EXISTS `pro_getModuleItem`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getModuleItem` (IN `keyword` VARCHAR(255))  BEGIN
SELECT 
	0 AS  is_checked
	,n.id
	,n.fullname
	,n.item_id
	,n.position
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
	 FROM 
    `module_item` n
    WHERE
    (keyword ='' OR LOWER(n.fullname) LIKE CONCAT('%', LOWER(keyword) ,'%'))    
    GROUP BY
	n.id
    	,n.fullname
	,n.item_id
	,n.position
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
    ORDER BY n.sort_order ASC;
    END$$

DROP PROCEDURE IF EXISTS `pro_getModuleMenu`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getModuleMenu` (IN `keyword` VARCHAR(255))  SELECT 
	0 as  is_checked
	,n.id
	,n.fullname
	,n.menu_type_id
	,n.position
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
	 FROM 
    `module_menu` n
    WHERE
    (keyword ='' OR LOWER(n.fullname) LIKE CONCAT('%', LOWER(keyword) ,'%'))    
    group by
	n.id
    	,n.fullname
	,n.menu_type_id
	,n.position
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
    ORDER BY n.sort_order ASC$$

DROP PROCEDURE IF EXISTS `pro_getPaymentMethod`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getPaymentMethod` (IN `keyword` VARCHAR(255) charset utf8)  BEGIN
SELECT 
	0 AS  is_checked
	,n.id
	,n.fullname
	,n.alias
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
	 FROM 
    `payment_method` n
    WHERE
    (keyword ='' OR LOWER(n.fullname) LIKE CONCAT('%', LOWER(keyword) ,'%'))    
    GROUP BY
	n.id
    	,n.fullname
    	,n.alias
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
    ORDER BY n.sort_order ASC;
    END$$

DROP PROCEDURE IF EXISTS `pro_getPrivilege`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getPrivilege` (IN `keyword` VARCHAR(255) CHARSET utf8)  NO SQL
SELECT
    0 AS is_checked,
	n.id,
	n.fullname,
	n.controller,
	n.action,	
	n.sort_order,
	n.created_at,
	n.updated_at
	FROM 
    `privilege` n
  
    WHERE
    ( (keyword='') OR ( LOWER(n.fullname) LIKE CONCAT('%',LOWER(keyword),'%')  ) )
    ORDER BY n.controller ASC , n.sort_order ASC$$

DROP PROCEDURE IF EXISTS `pro_getProduct`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getProduct` (IN `keyword` VARCHAR(255), IN `strCategoryProductID` VARCHAR(255))  begin
SELECT
    0 AS is_checked
    ,n.id
    ,n.code
    ,n.fullname
    ,n.alias   
    ,n.image
    ,n.status
    ,n.child_image
    ,n.price
    ,n.detail
    ,n.sort_order
    ,n.created_at    
    ,n.updated_at
	 FROM 
    `product` n
    LEFT JOIN `product_category` ac ON n.id = ac.product_id
    LEFT JOIN `category_product` cate ON ac.category_product_id = cate.id
    WHERE
    (keyword ='' OR trim(lower(n.fullname))  LIKE CONCAT('%',keyword,'%'))
    AND ( ac.category_product_id is null or INSTR(strCategoryProductID,'#'+ac.category_product_id+'#') > 0)
     GROUP BY 
    n.id
    ,n.code
    ,n.fullname
    ,n.alias   
    ,n.image
    ,n.status
    ,n.child_image
    ,n.price
    ,n.detail
    ,n.sort_order
    ,n.created_at    
    ,n.updated_at
    ORDER BY n.sort_order ASC;
end$$

DROP PROCEDURE IF EXISTS `pro_getProductFrontend`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getProductFrontend` (IN `keyword` VARCHAR(255), IN `category_id` VARCHAR(255))  SELECT
    0 AS is_checked
    ,n.id
    ,n.fullname
	 FROM 
    `product` n
    LEFT JOIN `product_category` ac ON n.id = ac.product_id
    WHERE
    (keyword ='' OR TRIM(LOWER(n.fullname)) LIKE CONCAT('%',keyword,'%'))
    AND (category_id = '#0#' OR INSTR(category_id,'#'+ac.category_product_id+'#') > 0)    
    and n.status=1
     GROUP BY 
    n.id
    ,n.fullname
    ORDER BY n.sort_order ASC$$

DROP PROCEDURE IF EXISTS `pro_getProductFrontendLimit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getProductFrontendLimit` (IN `keyword` VARCHAR(255), IN `category_id` VARCHAR(255), IN `position` INT(11), IN `totalItemsPerPage` INT(11))  SELECT
    0 AS is_checked
    ,n.id
    ,n.code
    ,n.fullname
    ,n.alias   
    ,n.image
    ,n.status
    ,n.child_image
    ,n.price
    ,n.sale_price
    ,n.detail
    ,n.sort_order
    ,n.created_at    
    ,n.updated_at
	 FROM 
    `product` n
    LEFT JOIN `product_category` ac ON n.id = ac.product_id
    LEFT JOIN `category_product` cate ON ac.category_product_id = cate.id
    WHERE
    (keyword ='' OR TRIM(LOWER(n.fullname)) LIKE CONCAT('%',keyword,'%'))
    AND (category_id = '#0#' OR INSTR(category_id,'#'+ac.category_product_id+'#') > 0)  
    AND n.status=1
     GROUP BY 
    n.id
    ,n.code
    ,n.fullname
    ,n.alias   
    ,n.image
    ,n.status
    ,n.child_image
    ,n.price
    ,n.sale_price
    ,n.detail
    ,n.sort_order
    ,n.created_at    
    ,n.updated_at
    ORDER BY n.sort_order ASC
    LIMIT `position` , `totalItemsPerPage`$$

DROP PROCEDURE IF EXISTS `pro_getSettingSystem`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getSettingSystem` (IN `keyword` VARCHAR(255) charset utf8)  BEGIN
SELECT 
	0 AS  is_checked
	,n.id
	,n.fullname
	,n.alias
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
	 FROM 
    `setting_system` n
    WHERE
    (keyword ='' OR LOWER(n.fullname) LIKE CONCAT('%', LOWER(keyword) ,'%'))    
    GROUP BY
	n.id
    	,n.fullname
    	,n.alias
	,n.status
	,n.sort_order
	,n.created_at
	,n.updated_at
    ORDER BY n.sort_order ASC;
    END$$

DROP PROCEDURE IF EXISTS `pro_getUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_getUser` (IN `keyword` VARCHAR(255), IN `group_member_id` INT)  NO SQL
SELECT 
    0 as is_checked
    ,n.id
    ,n.username
    ,n.email
    ,n.password
    ,n.status
    ,n.fullname
    ,n.group_member_id
    ,g.fullname as group_member_name
    ,n.sort_order
    ,n.created_at
    ,n.updated_at
    FROM 
    `users` n 
    left join group_member g on n.group_member_id = g.id
    WHERE
    (keyword ='' OR LOWER(n.fullname) LIKE CONCAT('%', LOWER(keyword) ,'%'))    
    AND (group_member_id = 0 OR n.group_member_id = group_member_id)
    ORDER BY n.sort_order ASC$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `activations`
--

DROP TABLE IF EXISTS `activations`;
CREATE TABLE `activations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'ilPOiDhmKqsxtUpi7ZgWe5vDYjt2ICJK', 1, '2017-11-12 06:15:56', '2017-11-12 06:15:55', '2017-11-12 06:15:56'),
(2, 1, 'rcp04qHne8oATtrTCwKl9FuckJEarSCb', 1, '2017-11-12 06:20:02', '2017-11-12 06:20:02', '2017-11-12 06:20:02'),
(3, 1, 'AHbwHv4BMq4Z5b7nkdvOlvcOvXnPqMk0', 1, '2017-11-12 06:24:14', '2017-11-12 06:24:14', '2017-11-12 06:24:14'),
(4, 1, 'JqmoT6nwuNXt0D5jape2qCQsEVQgWEqA', 1, '2017-11-12 06:26:26', '2017-11-12 06:26:26', '2017-11-12 06:26:26'),
(5, 1, '1TnyfEnFLs7gdNZXKP2r35tc1hBvcnPg', 1, '2017-11-12 07:22:52', '2017-11-12 07:22:52', '2017-11-12 07:22:52'),
(6, 1, 'QlzbRQWzVJgg01NkGUVewoQhT4qPKTMZ', 1, '2017-11-12 07:23:56', '2017-11-12 07:23:56', '2017-11-12 07:23:56'),
(10, 6, 'kMUYlsNzxftRUN0Rzfx2a41fvT61Eezp', 1, '2017-11-15 09:45:46', '2017-11-15 09:45:46', '2017-11-15 09:45:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `album`
--

DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `id` bigint(20) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `album`
--

INSERT INTO `album` (`id`, `fullname`, `alias`, `parent_id`, `image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Du lịch Tà pao', 'du-lich-ta-pao', NULL, 'i4tveyphj1oxa63s.jpg', 1, 1, '2017-05-16 15:30:23', '2017-05-20 10:52:06'),
(2, 'Tắm biển', 'tam-bien', 1, 'yugh5bcj9qmftdns.jpg', 2, 1, '2017-05-16 15:37:40', '2017-05-20 10:52:06'),
(3, 'Mũi né', 'mui-ne', 1, 'iave2lz7q6gbr0jm.png', 1, 1, '2017-05-16 15:39:11', '2017-05-20 11:26:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` bigint(20) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` longtext COLLATE utf8_unicode_ci,
  `content` longtext COLLATE utf8_unicode_ci,
  `page_url` text COLLATE utf8_unicode_ci,
  `description` longtext COLLATE utf8_unicode_ci,
  `meta_keyword` text COLLATE utf8_unicode_ci,
  `meta_description` text COLLATE utf8_unicode_ci,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `article`
--

INSERT INTO `article` (`id`, `fullname`, `title`, `alias`, `image`, `intro`, `content`, `page_url`, `description`, `meta_keyword`, `meta_description`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hoàng Mạnh Hùng', 'đang cập nhật', 'hoang-manh-hung', 'khach-hang-4.png', 'Căn hộ cao cấp Rocity', '<p style=\"text-align:center\">Ch&uacute;ng t&ocirc;i c&ocirc;ng t&aacute;c nước ngo&agrave;i, việc mua nội thất v&agrave; sửa nh&agrave; anh giao lại hết cho t&ocirc;i, cảm ơn sự chu đ&aacute;o nhiệt t&igrave;nh của c&aacute;c bạn. T&ocirc;i rất h&agrave;i l&ograve;ng với sản phẩm c&aacute;c bạn cung cấp.</p>', NULL, '', '', '', 8, 1, '2017-11-14 10:10:59', '2017-11-21 14:20:00'),
(4, 'Nguyễn Văn Nguyễn', 'tiêu đề nguyễn văn nguyễn', 'nguyen-van-nguyen', 'khach-hang-2.png', 'Căn hộ tập thể Giảng Võ', '<p style=\"text-align:center\">Khi chuyển đến căn hộ n&agrave;y t&ocirc;i c&oacute; nhu cầu thiết kế, chuyển đổi một số nội thất, t&ocirc;i đ&atilde; nhờ tới Megashop nhờ vậy t&ocirc;i c&oacute; một căn hộ xinh xắn những đầy ắp tiện nghị.</p>', NULL, 'mô tả nguyễn văn nguyễn', 'metakeyword nguyễn văn nguyễn', 'metadescription nguyễn văn nguyễn', 11, 1, '2017-11-14 10:19:25', '2017-11-21 14:20:00'),
(5, 'Hoàng Thái Hậu', '', 'hoang-thai-hau', 'khach-hang-3.png', 'Nhà liên cư Cổ Nhuế', '<p style=\"text-align:center\">Việc bố tr&iacute; từ tầng 1 l&ecirc;n tầng 5 nh&agrave; t&ocirc;i mới mua như thế n&agrave;o cho hợp l&yacute; khiến t&ocirc;i thật sự lung t&uacute;ng. Megashop qu&aacute; chuy&ecirc;n nghiệp từ khi t&ocirc;i gặp gỡ v&agrave; triển khai ho&agrave;n thiện, cảm ơn !</p>', NULL, '', '', '', 9, 1, '2017-11-14 10:21:05', '2017-11-21 14:20:00'),
(6, 'Nguyễn Trọng Hiếu', '', 'nguyen-trong-hieu', 'khach-hang-1.png', 'Chung cư Timecy', '<p style=\"text-align:center\">Khi mua căn hộ mới, t&ocirc;i đ&atilde; li&ecirc;n hệ v&agrave; t&igrave;m đơn vị thi c&ocirc;ng c&ugrave;ng cung cấp nội thất hỗ trợ. Thật may khi t&igrave;m được Megashop, c&aacute;c bạn l&agrave;m việc nhiệt t&igrave;nh, sản phẩm cung cấp t&ocirc;i rất ưng.</p>', NULL, '', '', '', 10, 1, '2017-11-14 10:21:57', '2017-11-21 14:20:00'),
(7, 'Siêu dự bị tỏa sáng Man Utd thắng sít sao Tottenham', '', 'sieu-du-bi-toa-sang-man-utd-thang-sit-sao-tottenham', 'sang-trong-1.png', 'Martial chỉ mất hơn 10 phút để ghi bàn duy nhất, giúp đội chủ sân Old Trafford có chiến thắng 1-0 trước đối thủ cạnh tranh ngôi vô địch.', '<p style=\"text-align:justify\">Anthony Martial chứng tỏ c&aacute;i duy&ecirc;n của một si&ecirc;u dự bị. Ch&acirc;n s&uacute;t người Ph&aacute;p khiến nhiều CĐV Man Utd nhớ đến huyền thoại Ole Gunnar Solskjaer dưới thời Alex Ferguson. Cựu cầu thủ AS Monaco c&oacute; bốn b&agrave;n tại Ngoại hạng Anh từ đầu m&ugrave;a, v&agrave; tất cả đều đến sau khi anh v&agrave;o s&acirc;n thay người.</p>\n\n<p style=\"text-align:justify\">Trong cuộc tiếp đ&oacute;n Tottenham, Martial chỉ cần hơn 10 ph&uacute;t để khai hỏa. Anh dứt điểm ho&agrave;n hảo, sau pha tấn c&ocirc;ng chớp nho&aacute;ng chỉ bằng hai đường chuyền từ phần s&acirc;n nh&agrave;.</p>\n\n<p style=\"text-align:justify\">Sự ổn định của Martial gi&uacute;p Jose Mourinho c&oacute; th&ecirc;m lựa chọn chiến thuật, sau khi ch&acirc;n s&uacute;t chủ lực Romelu Lukaku c&oacute; dấu hiệu đi xuống về phong độ, v&agrave; chưa cải thiện được hiệu suất ghi b&agrave;n mỗi khi đối đầu với c&aacute;c đối thủ trong nh&oacute;m đội mạnh, gồm Arsenal, Chelsea, Liverpool, Man City, Tottenham.</p>\n\n<p style=\"text-align:justify\">Ba điểm trước &quot;G&agrave; trống&quot; cũng đập tan suy luận, rằng thầy tr&ograve; Mourinho chỉ chơi hay trước c&aacute;c đội b&oacute;ng yếu hơn. Đ&acirc;y cũng l&agrave; năm thứ tư li&ecirc;n tiếp, Man Utd vượt qua đội b&oacute;ng th&agrave;nh London tr&ecirc;n s&acirc;n nh&agrave; Old Trafford, trong khu&ocirc;n khổ Ngoại hạng Anh.</p>\n\n<p style=\"text-align:justify\">Quan trọng hơn, trận thắng Tottenham gi&uacute;p Man Utd tiếp tục cuộc đua song m&atilde; với Man City, v&agrave; tạm thời r&uacute;t ngắn khoảng c&aacute;ch xuống c&ograve;n hai điểm.<br />\nDuy tr&igrave; mạch thắng trước Tottenham, nhưng ba điểm đến kh&ocirc;ng dễ d&agrave;ng với Man Utd. Với t&acirc;m l&yacute; cẩn trọng của cả hai đội, 45 ph&uacute;t đầu ti&ecirc;n diễn ra kh&aacute; tẻ nhạt. Đội chủ nh&agrave; chơi tốt hơn trong khoảng 10 ph&uacute;t đầu khi thực hiện pressing tầm cao kh&aacute; tốt, v&agrave; c&oacute; một v&agrave;i t&igrave;nh huống x&acirc;m nhập v&ograve;ng cấm của Hugo Lloris.</p>\n\n<p style=\"text-align:justify\">Tottenham ngược lại, nhỉnh hơn trong khoảng 15 ph&uacute;t cuối. Sự cơ động của Eric Dier, dấu ấn chiến thuật của Mauricio Pochettino trong trận n&agrave;y, thường xuy&ecirc;n tổ chức ph&aacute;t động tấn c&ocirc;ng từ s&acirc;n nh&agrave;, hoặc đột ngột x&acirc;m nhập v&ograve;ng cấm đội b&oacute;ng &aacute;o đỏ.</p>\n\n<p style=\"text-align:justify\">Cơ hội nguy hiểm nhất trong hiệp một đến từ pha phối hợp thiếu ăn &yacute; của David De Gea v&agrave; Phil Jones. Thủ th&agrave;nh người T&acirc;y Ban Nha bắt b&oacute;ng c&oacute; phần chủ quan, để b&oacute;ng bật ra. Moussa Sissoko c&oacute; cơ hội ra ch&acirc;n ngay r&igrave;a v&ograve;ng cấm, nhưng anh dứt điểm qu&aacute; thiếu ch&iacute;nh x&aacute;c.<br />\nMan Utd bất ngờ tăng tốc đầu hiệp hai, bởi nếu h&ograve;a, đội chủ s&acirc;n Old Trafford c&oacute; khả năng k&eacute;m đối thủ c&ugrave;ng th&agrave;nh phố bảy điểm sau v&ograve;ng n&agrave;y. Những t&igrave;nh huống nguy hiểm bắt đầu xuất hiện. Đ&aacute;ng kể nhất l&agrave; pha x&acirc;m nhập của Marcus Rashford ở ph&uacute;t 54, sau nỗ lực đi b&oacute;ng của Henrik Mkhitaryan, nhưng ch&acirc;n s&uacute;t người Anh chậm hơn Ben Davies một nhịp.</p>\n\n<p style=\"text-align:justify\">Ph&uacute;t 65, Antonio Valencia thiếu ch&uacute;t nữa t&aacute;i hiện pha ghi b&agrave;n đẹp mắt, giống như anh từng l&agrave;m v&agrave;o lưới Everton khi s&uacute;t b&oacute;ng nửa nẩy r&igrave;a v&ograve;ng cấm. T&aacute;m ph&uacute;t sau, tới lượt Romelu Lukaku l&ecirc;n tiếng với một pha ra ch&acirc;n căng từ g&oacute;c hẹp, buộc Hugo Lloris bay người hết cỡ.</p>\n\n<p style=\"text-align:justify\">Sự cởi mở của đội chủ nh&agrave; gi&uacute;p Tottenham đến gần hơn khung th&agrave;nh của De Gea. Ph&uacute;t 77, Christian Eriksen chọc khe bổng cho Dele Alli băng v&agrave;o v&ograve;ng 5m50. Đ&aacute;ng tiếc cho đội kh&aacute;ch, từ khoảng c&aacute;ch chưa đầy 5 met, tiền vệ người Anh lại ch&iacute;ch b&oacute;ng ra ngo&agrave;i.<br />\nTottenham lộ điểm yếu thể lực trong hơn 10 ph&uacute;t cuối trận, v&agrave; đ&acirc;y cũng l&agrave; khoảng thời gian Man Utd li&ecirc;n tiếp tạo ra những t&igrave;nh huống s&oacute;ng gi&oacute;. Ph&uacute;t 79, thiếu ch&uacute;t nữa Lukaku đ&atilde; ghi t&ecirc;n l&ecirc;n bảng điện tử khi đ&aacute;nh đầu hiểm h&oacute;c, đưa b&oacute;ng chạm cột dọc, sau đường treo b&oacute;ng bổng của Valencia.</p>\n\n<p style=\"text-align:justify\">Nhưng kh&aacute;n giả tại Old Trafford cũng kh&ocirc;ng phải nuối tiếc qu&aacute; l&acirc;u, bởi chỉ hai ph&uacute;t sau, Martial đ&atilde; lập c&ocirc;ng. Bắt nguồn từ pha ph&aacute;t b&oacute;ng b&ecirc;n phần s&acirc;n nh&agrave; của De Gea, Lukaku bật cao đ&aacute;nh đầu chuyền b&oacute;ng cho ch&acirc;n s&uacute;t người Ph&aacute;p d&ugrave;ng tốc độ tho&aacute;t xuống. Cựu cầu thủ AS Monaco dứt điểm tinh tế trong pha đối mặt, l&agrave;m tung lưới Lloris.</p>\n\n<p style=\"text-align:justify\">Man Utd lẽ ra đ&atilde; thắng đậm hơn, nếu một cầu thủ dự bị kh&aacute;c l&agrave; Jesse Lingard c&oacute; th&ecirc;m tốc độ để thoải m&aacute;i hơn trong pha dứt điểm ở ph&uacute;t 90, khi một m&igrave;nh một b&oacute;ng tho&aacute;t xuống. D&ugrave; vậy, chiến thắng 1-0 l&agrave; qu&aacute; đủ để &quot;Quỷ đỏ&quot; giữ vững vị tr&iacute; thứ hai tr&ecirc;n bảng điểm.</p>\n\n<p style=\"text-align:justify\">Đội h&igrave;nh thi đấu</p>\n\n<p style=\"text-align:justify\">Man Utd: De Gea, Valencia, Smalling, Jones, Bailly, Young (Darmian 90&#39;+2), Matic, Mkhitaryan (Lingard 65&#39;), Herrera, Lukaku, Rashford (Martial 70&#39;)</p>\n\n<p style=\"text-align:justify\">Dự bị kh&ocirc;ng sử dụng: Romero, Blind, Mata, McTominay</p>\n\n<p style=\"text-align:justify\">Tottenham: Lloris, Vertonghen, Alderweireld, Aurier, Davies, Sissoko (Dembele 62&#39;), Eriksen, Alli, Dier, Winks, Heung-Min (Llorente 62&#39;)</p>\n\n<p style=\"text-align:justify\">Dự bị kh&ocirc;ng sử dụng: Vorm, Sanchez, Nkoudou, Trippier, Rose</p>', NULL, '', '', '', 1, 1, '2017-11-14 10:54:19', '2017-11-15 03:46:38'),
(8, 'PSG đi tiếp trong ngày hậu vệ trái lập hattrick', '', 'psg-di-tiep-trong-ngay-hau-ve-trai-lap-hattrick', 'sang-trong-2.png', 'Đội chủ sân Parc des Princes tiếp tục toàn thắng và không thủng lưới tại vòng bảng Champions League, sau khi hạ Anderlecht 5-0.', '<p style=\"text-align:justify\">PSG tạo cảm gi&aacute;c họ kết liễu đối thủ m&agrave; chẳng cần b&oacute;p c&ograve;. Kylian Mbappe v&agrave; Edinson Cavani kh&ocirc;ng đạt phong độ tốt nhất, nhưng b&agrave;n thắng hiếm hoi của Verratti v&agrave; hat-trick đến từ hậu vệ tr&aacute;i Layvin Kurzawa gi&uacute;p chủ nh&agrave; duy tr&igrave; th&agrave;nh t&iacute;ch cao tại Champions League. Qua bốn lượt trận v&ograve;ng bảng, PSG đang sở hữu h&agrave;ng c&ocirc;ng mạnh nhất với 17 b&agrave;n, cũng l&agrave; đội duy nhất chưa thủng lưới.</p>\n\n<p style=\"text-align:justify\">Tỷ số c&oacute; phần quen thuộc với PSG tr&ecirc;n s&acirc;n nh&agrave;, nhưng trận đấu th&igrave; diễn tiến lạ kỳ. Verratti chỉ ghi t&aacute;m b&agrave;n trong sự nghiệp, lại mở điểm cho chủ nh&agrave;. Ph&uacute;t 30, anh được Mbappe dọn cỗ trong v&ograve;ng cấm. Được biến đến với độ lười dứt điểm, nhưng trong t&igrave;nh thế thuận lợi hơn đồng đội, tiền vệ người Italy khống chế kh&eacute;o l&eacute;o v&agrave; s&uacute;t về g&oacute;c xa. Thủ m&ocirc;n Frank Boeckx như chết lặng v&agrave; Verratti cũng ngỡ ng&agrave;ng kh&ocirc;ng k&eacute;m. Tiền vệ 24 tuổi kh&ocirc;ng l&agrave;m g&igrave; sau b&agrave;n thắng, chờ đồng đội đến chia vui.</p>\n\n<p style=\"text-align:justify\">Sức mạnh của PSG &aacute;t v&iacute;a to&agrave;n diện so với đối thủ, Anderlecht kh&ocirc;ng d&aacute;m đẩy cao đội h&igrave;nh, t&igrave;m b&agrave;n gỡ. Trước đối thủ chỉ nằm im chịu trận, c&aacute;c học tr&ograve; của HLV Unai Emery thay nhau bắn ph&aacute; cầu m&ocirc;n. Trước khi hiệp một kết th&uacute;c, Neymar dẫn b&oacute;ng cắt ngang khung th&agrave;nh v&agrave; s&uacute;t xa nh&acirc;n đ&ocirc;i c&aacute;ch biệt.</p>\n\n<p style=\"text-align:justify\">Hiệp hai l&agrave; s&acirc;n khấu cho Kurzawa tỏa s&aacute;ng, với hat-trick trong 25 ph&uacute;t. Cả ba b&agrave;n đều đến từ những pha dứt điểm trong v&ograve;ng cấm, khi hậu vệ tr&aacute;i n&agrave;y d&acirc;ng cao ở t&igrave;nh huống b&oacute;ng sống. Đầu ti&ecirc;n l&agrave; c&uacute; đ&aacute; bồi ở ph&uacute;t 53, sau khi Neymar s&uacute;t phạt tr&uacute;ng cột dọc. Sau đ&oacute;, tuyển thủ Ph&aacute;p bay người đ&aacute;nh đầu ở cự ly chưa đến năm m&eacute;t, trong thế kh&ocirc;ng bị ai k&egrave;m. Ph&uacute;t 78, anh ấn định thắng lợi 5-0 với c&uacute; s&uacute;t ch&igrave;m về g&oacute;c xa.</p>\n\n<p style=\"text-align:justify\">&quot;Hat-trick đầu ti&ecirc;n trong sự nghiệp gi&uacute;p t&ocirc;i vui sướng tột độ. PSG chơi thăng hoa suốt trận đấu, khiến kh&aacute;n giả vui mừng l&acirc;y. T&ocirc;i đ&atilde; ghi b&agrave;n trước đ&oacute;, nhưng ba b&agrave;n l&agrave; qu&aacute; nhiều với hậu vệ như t&ocirc;i. C&ocirc;ng sức thuộc về c&aacute;c đồng đội v&igrave; nếu họ kh&ocirc;ng ở đ&oacute;, t&ocirc;i đ&atilde; kh&ocirc;ng lập c&ocirc;ng nhiều đến vậy&quot;, Kurzawa chia sẻ cảm x&uacute;c sau trận.</p>\n\n<p style=\"text-align:justify\">PSG gi&agrave;nh quyền v&agrave;o v&ograve;ng 1/8 do Celtic thua Bayern Munich tr&ecirc;n s&acirc;n nh&agrave; trong trận đấu c&ugrave;ng giờ. &ldquo;H&ugrave;m x&aacute;m&rdquo; xứ Bavaria cũng c&oacute; v&eacute; theo ch&acirc;n PSG đi tiếp, d&ugrave; bảng B vẫn c&ograve;n hai lượt trận chưa đấu.</p>\n\n<p style=\"text-align:justify\">Đội h&igrave;nh thi đấu:</p>\n\n<p style=\"text-align:justify\">PSG (4-3-3): Areola; Dani Alves, Marquinhos, Thiago Silva, Kurzawa; Verratti (Lo Celso 65), Rabiot (Pastore 75), Draxler; Mbappe (Di Maria 65), Cavani, Neymar</p>\n\n<p style=\"text-align:justify\">Anderlecht (4-3-3): Boeckx; Appiah, Mbodji, Spajic (Josue 46), Obradovic; Kums, Dendoncker, Trebel; Gerkens, Onyekuru (Stanciu 79), Hanni (Teodorczyk 60)</p>', NULL, '', '', '', 9, 1, '2017-11-14 10:56:23', '2017-11-22 15:42:24'),
(9, 'Cựu HLV thể lực Man Utd hé lộ những bài tập kì lạ của Ronaldo', '', 'cuu-hlv-the-luc-man-utd-he-lo-nhung-bai-tap-ki-la-cua-ronaldo', 'sang-trong-3.png', 'Nhiều cầu thủ muốn trở thành Cristiano Ronaldo, nhưng rất ít người biết anh đã nỗ lực như thế nào để có thành công như hôm nay.', '<p style=\"text-align:justify\">T&aacute;c giả Paulo Condo vừa ra mắt cuốn s&aacute;ch &quot;Duellists&quot; (Kỳ ph&ugrave;ng địch thủ), trong đ&oacute; c&oacute; những trang n&oacute;i về Ronaldo. Condo dẫn lại c&acirc;u chuyện về những b&agrave;i tập ngo&agrave;i giờ của CR7 khi anh c&ograve;n l&agrave; cầu thủ Man Utd, qua lời kể của Walter Di Salvio - cựu HLV thể lực Man Utd. Di Salvio l&agrave;m việc rất ăn &yacute; với Ronaldo, n&ecirc;n về sau, khi sang Real Madrid, hai người vẫn tiếp tục hợp t&aacute;c.</p>\n\n<p style=\"text-align:justify\">&quot;Walter một lần kể với t&ocirc;i về những b&agrave;i tập th&ecirc;m của Ronaldo, đ&oacute; kh&ocirc;ng phải những buổi r&egrave;n cơ bắp trong ph&ograve;ng gym, m&agrave; l&agrave; b&agrave;i tập ri&ecirc;ng sau mỗi buổi tập ở khu huấn luyện Carrington&quot;, s&aacute;ch của Condo c&oacute; đoạn.</p>\n\n<p style=\"text-align:justify\">&quot;Trong khi c&aacute;c cầu thủ Man Utd kh&aacute;c đ&atilde; đi tắm, Ronaldo quay trở lại khu huấn luyện, ở khu vực c&oacute; nhiều c&acirc;y xanh để luyện kỹ năng kiểm so&aacute;t b&oacute;ng&quot;, Condo kể tiếp. &quot;Khu vực n&agrave;y c&oacute; bề mặt mấp m&ocirc;, đầy những rễ c&acirc;y nh&ocirc; l&ecirc;n mặt đất. Ronaldo s&uacute;t b&oacute;ng thật mạnh v&agrave;o v&ugrave;ng n&agrave;y rồi chạy theo b&oacute;ng. Cậu ấy muốn luyện phản xạ kiểm so&aacute;t b&oacute;ng, dưới những t&aacute;c động kh&ocirc;ng thể đo&aacute;n trước&quot;.<br />\nT&aacute;c giả Condo kh&acirc;m phục &yacute; ch&iacute; vươn l&ecirc;n của Ronaldo, để trở th&agrave;nh kỳ ph&ugrave;ng địch thủ với một cầu thủ t&agrave;i năng xuất ch&uacute;ng như Lionel Messi. &quot;Nếu Messi l&agrave; Mozart, Ronaldo kh&ocirc;ng phải l&agrave; Salieri (nh&agrave; soạn nhạc cổ điển lừng danh người Italy ở thế kỷ 19)&quot;. Anh ấy c&oacute; nhiều hơn như thế&quot;, t&aacute;c giả cuốn s&aacute;ch viết.</p>\n\n<p style=\"text-align:justify\">Condo sau đ&oacute; ph&acirc;n t&iacute;ch s&acirc;u hơn về nh&acirc;n vật: &quot;Sự vĩ đại thật sự của Ronaldo l&agrave; th&aacute;i độ kh&ocirc;ng bao giờ đầu h&agrave;ng khi đối diện với những trở ngại tưởng chừng kh&ocirc;ng thể lay động. Ronaldo c&oacute; thừa quyết t&acirc;m để nỗ lực tiến bộ mỗi ng&agrave;y, v&agrave; đ&oacute; ch&iacute;nh x&aacute;c l&agrave; điều biến anh trở th&agrave;nh nh&agrave; v&ocirc; địch vĩ đại&quot;.</p>\n\n<p style=\"text-align:justify\">&quot;Kh&ocirc;ng ai m&ocirc; tả sự kh&aacute;c biệt giữa Ronaldo v&agrave; phần c&ograve;n lại tốt hơn c&aacute;ch Gianluca Vialli từng n&oacute;i: Mọi người n&oacute;i với bạn rằng họ c&oacute; &yacute; ch&iacute; mạnh mẽ để chiến thắng, v&agrave; sự thật l&agrave; như thế. Nhưng những người c&oacute; &yacute; ch&iacute; luyện tập để gi&agrave;nh chiến thắng mới l&agrave; người tạo n&ecirc;n sự kh&aacute;c biệt&quot;, t&aacute;c giả Condo kết luận.<br />\nNăm 2012, Messi l&ecirc;n đỉnh thế giới khi gi&agrave;nh Quả B&oacute;ng V&agrave;ng thứ tư. L&uacute;c ấy, &nbsp;Ronaldo chỉ mới một lần nhận vinh quang n&agrave;y. Nhưng đến năm 2016, Ronaldo bứt ph&aacute; đoạt bốn Quả B&oacute;ng V&agrave;ng, chỉ c&ograve;n k&eacute;m một so với ng&ocirc;i sao Argentina. Nhiều khả năng trong &iacute;t tuần tới, Ronaldo sẽ c&acirc;n bằng th&agrave;nh t&iacute;ch gi&agrave;nh Quả B&oacute;ng V&agrave;ng với Messi, khi c&oacute; kết quả bầu chọn giải thưởng n&agrave;y năm 2017.</p>', NULL, '', '', '', 3, 1, '2017-11-14 10:57:45', '2017-11-22 07:38:40'),
(10, 'Cố vấn của Neymar dự đoán Barca sắp tới hồi suy tàn', '', 'co-van-cua-neymar-du-doan-barca-sap-toi-hoi-suy-tan', 'sang-trong-1.png', 'Ông Wagner Ribeiro cho rằng quyết định độc lập của xứ Catalonia sẽ đẩy Barca vào con đường diệt vong trên bản đồ bóng đá đỉnh cao.', '<p style=\"text-align:justify\">Xứ Catalonia đang g&acirc;y sức &eacute;p l&ecirc;n ch&iacute;nh quyền Madrid để đ&ograve;i độc lập v&agrave; tiến th&ecirc;m một bước d&agrave;i trong tuần n&agrave;y. Nghị viện khu vực Catalonia vừa th&ocirc;ng qua nghị quyết tuy&ecirc;n bố độc lập khỏi T&acirc;y Ban Nha v&agrave; trở th&agrave;nh một nước cộng h&ograve;a.</p>\n\n<p style=\"text-align:justify\">Điều n&agrave;y khiến tương lai của Barca trở n&ecirc;n bất định. Ban tổ chức La Liga từng tuy&ecirc;n bố loại mọi đội b&oacute;ng của xứ Catalonia ra khỏi giải, nếu v&ugrave;ng l&atilde;nh thổ n&agrave;y &nbsp;trở th&agrave;nh nước độc lập.<br />\n&quot;Xứ Catalonia rồi sẽ như Luxembourg. Sau đ&oacute;, tới lượt Barca sẽ chết&quot;, cố vấn của Neymar l&agrave; Wagner Ribeiro viết tr&ecirc;n Twitter v&agrave; đăng k&egrave;m bức ảnh một cậu b&eacute; cổ động vi&ecirc;n của Barca bật kh&oacute;c.</p>\n\n<p style=\"text-align:justify\">Ribeiro được xem l&agrave; một trong những đạo diễn ch&iacute;nh đưa Neymar rời Barca v&agrave;o m&ugrave;a h&egrave; vừa qua. Nh&agrave; m&ocirc;i giới người Brazil c&oacute; quan hệ th&acirc;n thiết với Chủ tịch Real Florentino Perez, v&agrave; từng định đưa Neymar tới s&acirc;n Bernabeu khi ng&ocirc;i sao n&agrave;y c&ograve;n chơi cho Santos.</p>\n\n<p style=\"text-align:justify\">Luxembourg l&agrave; một quốc gia nhỏ ở ch&acirc;u &Acirc;u vốn rất gi&agrave;u c&oacute; nhờ ng&agrave;nh t&agrave;i ch&iacute;nh, nhưng nền b&oacute;ng đ&aacute; nước n&agrave;y kh&ocirc;ng mấy tự h&agrave;o. Đội tuyển quốc gia Luxembourg gồm nhiều cầu thủ nghiệp dư v&agrave; thường xuy&ecirc;n l&oacute;t đường tại s&acirc;n chơi ch&acirc;u &Acirc;u.</p>', NULL, '', '', '', 2, 1, '2017-11-14 10:58:58', '2017-11-22 15:42:40'),
(11, 'Mourinho chế giễu người chỉ trích sau khi thắng Tottenham', '', 'mourinho-che-gieu-nguoi-chi-trich-sau-khi-thang-tottenham', 'tin-tuc-1.png', 'HLV người Bồ Đào Nha khuyên những người chỉ trích ông nên bình tĩnh và thư giãn sau khi chứng kiến Man Utd chiến thắng.', '<p style=\"text-align:justify\">Pha lập c&ocirc;ng của cầu thủ dự bị Anthony Martial v&agrave;o cuối trận gi&uacute;p Man Utd đ&aacute;nh bại đối thủ cạnh tranh trực tiếp cho vị tr&iacute; số hai l&agrave; Tottenham. Chiến thắng n&agrave;y một lần nữa cho thấy t&agrave;i dụng binh của Mourinho, đặc biệt trong những thời khắc cần sự thay đổi.</p>\n\n<p style=\"text-align:justify\">&quot;B&igrave;nh tĩnh v&agrave; thư gi&atilde;n một ch&uacute;t. Đừng qu&aacute; hồi hộp m&agrave; h&atilde;y thư gi&atilde;n&quot;, Mourinho giải th&iacute;ch v&igrave; sao ra dấu im lặng sau khi đội b&oacute;ng chiến thắng.&nbsp;<br />\n&quot;T&ocirc;i kh&ocirc;ng hiểu v&igrave; sao c&oacute; người lại hỏi ch&uacute;ng t&ocirc;i chơi kh&ocirc;ng giống &#39;Quỷ Đỏ&#39; ng&agrave;y h&ocirc;m nay. Hai tiền đạo của ch&uacute;ng t&ocirc;i đ&atilde; phải đối đầu h&agrave;ng thủ cực tốt, thậm ch&iacute; h&agrave;ng đầu ch&acirc;u &Acirc;u v&agrave;o l&uacute;c n&agrave;y&quot;, chiến lược gia của Man Utd tỏ ra bực bội trước phản ứng của một số cổ động vi&ecirc;n.</p>\n\n<p style=\"text-align:justify\">Chiến thắng trước Tottenham gi&uacute;p Man Utd bứt l&ecirc;n tr&ecirc;n đối thủ v&agrave; tiếp tục duy tr&igrave; cuộc đua với Man City. Đội b&oacute;ng của Mourinho đang c&oacute; 23 điểm, hơn Tottenham ba điểm v&agrave; k&eacute;m Man City tới năm điểm.</p>\n\n<p style=\"text-align:justify\">Trong trận tiếp đ&oacute;n Tottenham, Mourinho kh&ocirc;ng bố tr&iacute; đội h&igrave;nh với h&agrave;ng tấn c&ocirc;ng gồm mũi đinh ba quen thuộc m&agrave; cho Mkhitaryan đ&aacute; dưới cặp tiền đạo Rashford v&agrave; Lukaku. Sự xuất hiện của Martial từ ghế dự bị đ&atilde; tạo n&ecirc;n đột biến khi c&aacute;c hậu vệ Tottenham thấm mệt.</p>\n\n<p style=\"text-align:justify\">&quot;Martial v&agrave;o chơi đ&uacute;ng vị tr&iacute; Rashford để lại, nhưng c&oacute; xu hướng chớp thời cơ v&agrave; đi b&oacute;ng nhiều hơn. T&ocirc;i đ&atilde; bảo cậu ấy chơi như vậy để kết hợp với Lukaku. Kh&ocirc;ng dễ g&igrave; cho Martial khi đối mặt ba hậu vệ, nhưng đ&oacute; l&agrave; thời điểm họ chơi suốt 70 ph&uacute;t. D&ugrave; c&uacute; đ&aacute; của Martial c&oacute; phần may mắn, n&oacute; gi&uacute;p mang về th&ecirc;m hai điểm so với nếu h&ograve;a 0-0&quot;, Mourinho chia sẻ.</p>', NULL, '', '', '', 16, 1, '2017-11-14 11:00:55', '2017-11-22 15:42:49'),
(12, 'Arsenal thắng ngược trận thứ 800 của Wenger ở Ngoại hạng Anh', '', 'arsenal-thang-nguoc-tran-thu-800-cua-wenger-o-ngoai-hang-anh', 'tin-tuc-2.png', 'Bị dẫn bàn trước, nhưng Arsenal đã thi đấu khởi sắc trong hiệp hai và ngược dòng giành chiến thắng 2-1 trước Swansea City ở vòng 10 giải Ngoại hạng Anh.', '<p style=\"text-align:justify\">Kh&ocirc;ng phải Alexis Sanchez hay Mesut Ozil, Sead Kolasinac l&agrave; người h&ugrave;ng của Arsenal trận n&agrave;y. Hậu vệ c&aacute;nh người Bosnia ghi b&agrave;n gỡ ho&agrave; 1-1 kh&ocirc;ng l&acirc;u sau khi hiệp hai bắt đầu, trước khi kiến tạo cho Aaron Ramsey ấn định tỷ số 2-1. Trước đ&oacute;, đội chủ s&acirc;n Emirates bất ngờ Sam Clucas chọc thủng lưới ở giữa hiệp một.</p>\n\n<p style=\"text-align:justify\">Chiến thắng n&agrave;y đồng nghĩa với việc Arsenal to&agrave;n thắng 5 trận tr&ecirc;n s&acirc;n Emirates ở Ngoại hạng Anh m&ugrave;a n&agrave;y, để leo l&ecirc;n thứ tư với 19 điểm sau 10 v&ograve;ng. Nếu cải thiện được phong độ s&acirc;n kh&aacute;ch, thầy tr&ograve; HLV Arsene Wenger c&oacute; thể c&ograve;n c&oacute; được vị tr&iacute; tốt hơn. Hiện tại họ &iacute;t hơn đ&uacute;ng một điểm so với đội đứng ngay tr&ecirc;n l&agrave; Tottenham, nhưng k&eacute;m đội đầu bảng Man City tới ch&iacute;n điểm.<br />\nĐược thi đấu tr&ecirc;n s&acirc;n nh&agrave; gặp đội b&oacute;ng đang đứng ở nh&oacute;m cầm đ&egrave;n đỏ, nhưng HLV Wenger sử dụng đội h&igrave;nh mạnh nhất với việc Sanchez, Ozil hay Alexandre Lacazette... đ&aacute; ch&iacute;nh. Đ&acirc;y vốn l&agrave; đội h&igrave;nh đ&atilde; ngược d&ograve;ng đ&aacute;nh bại Everton 5-2 ở v&ograve;ng trước. Ch&iacute;nh v&igrave; vậy, Arsenal kh&ocirc;ng mấy kh&oacute; khăn để kiểm so&aacute;t thế trận. Thậm ch&iacute;, c&oacute; l&uacute;c đạt đến 76% thời lượng cầm giữ b&oacute;ng. Tuy nhi&ecirc;n, số cơ hội m&agrave; họ tạo ra kh&ocirc;ng nhiều.</p>\n\n<p style=\"text-align:justify\">Sơ đồ 5-3-2 của Swansea tỏ ra kh&aacute; k&iacute;n kẽ. Trong 45 ph&uacute;t đầu ti&ecirc;n, cơ hội tốt nhất m&agrave; đội chủ nh&agrave; tạo ra l&agrave; c&uacute; dứt điểm của Sanchez, nhưng kh&ocirc;ng qua khỏi đ&ocirc;i tay của Lukas Fabianski. Ngo&agrave;i ra l&agrave; c&uacute; đ&aacute;nh đầu của Per Metersacker đưa b&oacute;ng hướng đ&uacute;ng vị tr&iacute; của cựu thủ th&agrave;nh Arsenal.&nbsp;</p>\n\n<p style=\"text-align:justify\">Tr&aacute;i lại, sự vượt trội về thế trận c&oacute; vẻ như khiến hệ thống ph&ograve;ng ngự của Arsenal thi đấu lỏng ch&acirc;n. V&agrave; hệ quả l&agrave; họ phải nhận b&agrave;n thua bất ngờ ở ph&uacute;t 22. Trong t&igrave;nh huống n&agrave;y, số lượng cầu thủ chủ nh&agrave; nhiều hơn hẳn, nhưng tỏ ra thiếu quyết liệt để Sam Clucas tho&aacute;t xuống đ&oacute;n đường chuyền tuyệt đỉnh của Tammy Abraham rồi tỉa b&oacute;ng qua khe giữa hai ch&acirc;n của thủ th&agrave;nh Petr Cech th&agrave;nh b&agrave;n. Nếu kh&ocirc;ng c&oacute; phản xạ của Cech sau đ&oacute;, khống chế th&agrave;nh c&ocirc;ng pha dứt điểm của Jordan Ayew trong cấm địa. Nếu c&aacute;ch biệt l&uacute;c đ&oacute; được nh&acirc;n đ&ocirc;i cho Swansea, kh&ocirc;ng biết chừng thế trận đ&atilde; được l&aacute;i theo hướng kh&aacute;c.<br />\nThực tế th&igrave; kh&aacute;c. Đầu hiệp hai Arsenal tiếp tục duy tr&igrave; sức &eacute;p, với sự năng nổ của Sanchez v&agrave; Ramsey, c&ugrave;ng những pha phối hợp b&oacute;ng ngắn quen thuộc với sự l&ecirc;n xuống nhịp nh&agrave;ng của Hector Bellerin v&agrave; Kolasinac từ hai c&aacute;nh. V&agrave; cuối c&ugrave;ng, những pha b&oacute;ng ấy cũng cắt n&aacute;t được h&agrave;ng thủ Swansea ph&uacute;t 51. Kolasinac đ&atilde; rất nhanh nhẹn băng l&ecirc;n dứt điểm quyết đo&aacute;n bằng ch&acirc;n tr&aacute;i đưa b&oacute;ng về g&oacute;c xa khung th&agrave;nh Swansea, khi b&oacute;ng bật ra từ những pha dứt điểm li&ecirc;n tiếp của đồng đội.</p>\n\n<p style=\"text-align:justify\">Như tr&uacute;t bỏ được g&aacute;nh nặng, Arsenal thi đấu dữ đội hơn những ph&uacute;t sau đ&oacute;. Một điểm l&agrave; điều kh&ocirc;ng thể chấp nhận với họ l&uacute;c n&agrave;y. V&agrave; chừng bẩy ph&uacute;t sau b&agrave;n gỡ, họ c&oacute; được b&agrave;n thắng để vượt l&ecirc;n dẫn trước. Tiếp tục l&agrave; Kolasinac để lại dấu ấn, với pha tho&aacute;t xuống b&ecirc;n c&aacute;nh tr&aacute;i rồi chuyền l&ecirc;n như đặt cho Ramsey đệm l&ograve;ng ch&acirc;n tr&aacute;i g&oacute;c gần th&agrave;nh b&agrave;n.&nbsp;</p>\n\n<p style=\"text-align:justify\">Nếu Bellerin kh&ocirc;ng bị x&agrave; ngang từ chối với dứt điểm tinh tế sau đ&oacute;, c&aacute;ch biệt c&oacute; thể được gia tăng cho Arsenal v&agrave; gi&uacute;p họ những ph&uacute;t c&ograve;n lại thảnh thơi hơn. Dẫu vậy, 2-1 vẫn l&agrave; tỷ số đủ đẹp với Arsenal, nhất l&agrave; khi n&oacute; gi&uacute;p đội cải thiện được vị tr&iacute; v&agrave; HLV Wenger c&oacute; một cột mốc đẹp để kỷ niệm trận thứ 800 c&ugrave;ng Arsenal ở Ngoại hạng.</p>', NULL, '', '', '', 5, 1, '2017-11-14 11:01:52', '2017-11-21 14:20:00'),
(13, 'Thủ môn bị đuổi vì đi tiểu cạnh khung thành', '', 'thu-mon-bi-duoi-vi-di-tieu-canh-khung-thanh', 'tin-tuc-4.png', 'Crocombe của đội Salford nhận thẻ đỏ trực tiếp vì hành động bị coi là thô tục trong thời gian thi đấu.', '<p style=\"text-align:justify\">Người g&aacute;c đền đội Salford City nhận chiếc thẻ đỏ kỳ lạ nhất sự nghiệp h&ocirc;m 28/10, trong trận đấu với Bradford Park Avenue tại National League North, giải đấu hạng s&aacute;u của b&oacute;ng đ&aacute; Anh.</p>\n\n<p style=\"text-align:justify\">Max Crocombe đi tiểu trong l&uacute;c b&oacute;ng lăn, v&agrave;o những ph&uacute;t cuối trận đấu. Ngay khi tổ trọng t&agrave;i điều khiển trận đấu ph&aacute;t hiện ra điều n&agrave;y, thủ m&ocirc;n người New Zealand đ&atilde; bị truất quyền thi đấu.<br />\nNgười h&acirc;m mộ cũng như đội b&oacute;ng chủ quản Salford City kh&ocirc;ng hiểu v&igrave; sao thủ th&agrave;nh của họ phải nhận thẻ. đỏ. Trong th&ocirc;ng b&aacute;o tr&ecirc;n mạng x&atilde; hội Twitter, đội b&oacute;ng n&agrave;y viết: &quot;Thẻ đỏ! Crocombe bị đuổi v&igrave; chuyện g&igrave; đ&oacute; ngo&agrave;i diễn biến tr&ecirc;n s&acirc;n. Kh&ocirc;ng ai c&oacute; đầu mối g&igrave; về điều vừa xảy ra&quot;.</p>\n\n<p style=\"text-align:justify\">Người h&acirc;m mộ Salford chung mối bận t&acirc;m n&agrave;y. Họ đăng đ&agrave;n tr&ecirc;n mạng x&atilde; hội v&agrave; c&acirc;u chuyện kỳ b&iacute; về chiếc thẻ đỏ của Crocombe r&acirc;m ran khắp s&acirc;n b&oacute;ng.</p>\n\n<p style=\"text-align:justify\">Khi đối thủ Bradford cung cấp th&ocirc;ng tin về việc truất quyền thi đấu của thủ m&ocirc;n 24 tuổi, mọi việc mới s&aacute;ng tỏ. &quot;Ch&uacute;ng t&ocirc;i x&aacute;c nhận, rằng Crocombe bị đuổi v&igrave; đi tiểu ngay tr&ecirc;n s&acirc;n. Ch&uacute;ng t&ocirc;i kh&ocirc;ng hề n&oacute;i đ&ugrave;a&quot;, bộ phận kỹ thuật của Bradford th&ocirc;ng b&aacute;o.</p>\n\n<p style=\"text-align:justify\">D&ugrave; kh&ocirc;ng c&oacute; sự phục vụ của thủ m&ocirc;n ch&iacute;nh v&agrave; chơi thiếu người trong khoảng hơn năm ph&uacute;t cuối trận, Salford bảo vệ th&agrave;nh c&ocirc;ng chiến thắng s&iacute;t sao 2-1 trước đối thủ.</p>', NULL, '', '', '', 6, 1, '2017-11-14 11:02:57', '2017-11-21 14:20:00'),
(14, 'Man City thắng sát nút, tái lập cách biệt năm điểm với Man Utd', '', 'man-city-thang-sat-nut-tai-lap-cach-biet-nam-diem-voi-man-utd', 'tin-tuc-5.png', 'Vượt qua đối thủ với tỷ số 3-2 tại sân Hawthorns, thầy trò Pep Guardiola nối dài chuỗi thắng lên bảy trận.', '<p style=\"text-align:justify\">Man City bước v&agrave;o trận đấu với t&acirc;m l&yacute; hứng khởi, điều m&agrave; họ duy tr&igrave; trong nhiều tuần qua, v&agrave; họ c&oacute; b&agrave;n mở tỷ số sớm do c&ocirc;ng của Leroy Sane. D&ugrave; Jay Rodriguez gỡ h&ograve;a cho West Brom sau đ&oacute; ba ph&uacute;t, Fernandinho nhanh ch&oacute;ng lấy lại lợi thế dẫn trước cho đội kh&aacute;ch.</p>\n\n<p style=\"text-align:justify\">B&agrave;n thắng của Raheem Sterling trong hiệp hai đảm bảo chiến thắng cho Man City nhưng pha r&uacute;t ngắn tỷ số trong thời gian b&ugrave; giờ của Matthew Phillips khiến CĐV của đội đầu bảng sống trong những ph&uacute;t lo lắng để rồi vỡ &ograve;a trong sung sướng. Đ&acirc;y l&agrave; trận thứ t&aacute;m kh&ocirc;ng biết m&ugrave;i chiến thắng của West Brom tr&ecirc;n tất cả c&aacute;c đấu trường.&nbsp;</p>\n\n<p style=\"text-align:justify\">C&oacute; thể thấy r&otilde; sự tự tin của c&aacute;c cầu thủ Man City trong những pha xử l&yacute; quyết đo&aacute;n ở b&agrave;n mở tỷ số. Fernandinho tung một đường chuyền vừa tầm để Sane dứt điểm đưa b&oacute;ng đi qua giữa hai ch&acirc;n của Allan Nyom rồi v&agrave;o lưới.</p>\n\n<p style=\"text-align:justify\">West Brom gỡ h&ograve;a nhờ một pha mở b&oacute;ng đầy tinh tế của Gareth Barry. Rodriguez t&acirc;ng b&oacute;ng qua tầm với của Ederson tr&ecirc;n đ&agrave; băng xuống dưới sự đeo b&aacute;m trong bất lực của John Stones. Ở t&igrave;nh huống n&agrave;y, Rondon ở thế việc vị. Anh kh&ocirc;ng chạm b&oacute;ng nhưng trọng t&agrave;i c&oacute; thể phạt tiền đạo của West Brom v&igrave; t&aacute;c động v&agrave;o pha b&oacute;ng.</p>\n\n<p style=\"text-align:justify\">Tuy nhi&ecirc;n, Man City lập tức t&aacute;i lập thế dẫn b&agrave;n. C&uacute; đ&aacute; từ ngo&agrave;i v&ograve;ng cấm của Fernandinho đập ch&acirc;n một cầu thủ West Brom, dội cột dọc v&agrave; đi v&agrave;o lưới. Đội kh&aacute;ch tạo ra nhiều cơ hội ăn b&agrave;n trong những ph&uacute;t sau đ&oacute; nhưng kh&ocirc;ng thể tận dụng.</p>\n\n<p style=\"text-align:justify\">Phải đến khi hiệp hai tr&ocirc;i qua gần 20 ph&uacute;t, Man City mới c&oacute; b&agrave;n tiếp theo do c&ocirc;ng Raheem Sterling. Man City d&ugrave;ng vũ kh&iacute; sở trường để kết liễu đối thủ. Đ&oacute; l&agrave; những đường chuyền ngắn với tốc độ cao v&agrave; một pha căng ngang loại h&agrave;ng hậu vệ đối phương của Kyle Walker, khiến nhiệm vụ ghi b&agrave;n của đồng đội trở n&ecirc;n dễ d&agrave;ng.</p>\n\n<p style=\"text-align:justify\">Ở ph&uacute;t b&ugrave; giờ thứ hai của hiệp hai, West Brom r&uacute;t ngắn tỷ số nhờ sai lầm của Nicolas Otamendi. Đường chuyền về của trung vệ người Argentina qu&aacute; bất cẩn, tạo điều kiện cho Phillips dứt điểm.&nbsp;</p>\n\n<p style=\"text-align:justify\">D&ugrave; thua s&aacute;t n&uacute;t, West Brom ho&agrave;n to&agrave;n bị &eacute;p vế ở trận đấu n&agrave;y v&agrave; chưa bao giờ cho ra cảm gi&aacute;c sẽ việc họ sẽ thực hiện m&agrave;n ngược d&ograve;ng. Man City đ&aacute;ng ra c&oacute; thể thắng đậm hơn nhiều nếu tận dụng tốt những cơ hội.&nbsp;</p>', NULL, '', '', '', 7, 1, '2017-11-14 11:04:14', '2017-11-21 14:20:00'),
(15, 'Vivaki Super', '', 'vivaki-super', 'vivaki.png', '', '', NULL, '', '', '', 12, 1, '2017-11-14 11:07:32', '2017-11-21 14:20:00'),
(16, 'Group m', '', 'group-m', 'groupm.png', '', '', NULL, '', '', '', 13, 1, '2017-11-14 11:07:57', '2017-11-21 14:20:00'),
(17, 'Cedixis', '', 'cedixis', 'cedexis.png', '', '', NULL, '', '', '', 14, 1, '2017-11-14 11:08:22', '2017-11-21 14:20:00'),
(18, 'Vivaki', '', 'vivaki', 'vivaki-2.png', '', '', NULL, '', '', '', 15, 1, '2017-11-14 11:08:48', '2017-11-21 14:20:00'),
(19, 'Figaro', '', 'figaro', 'groupm.png', '', '', NULL, '', '', '', 16, 1, '2017-11-14 11:10:11', '2017-11-21 14:20:00'),
(20, 'Alas', '', 'alas', 'atlas.png', '', '', NULL, '', '', '', 17, 1, '2017-11-14 11:10:29', '2017-11-21 14:20:00'),
(21, 'Bản quyền', '', 'ban-quyen', NULL, '', '<p style=\"text-align:center\">&copy; Bản quyền thuộc về <strong>DienKim</strong> Team | Cung cấp bởi DienKim</p>', NULL, '', '', '', 1, 1, '2017-11-14 19:22:03', '2017-11-23 14:31:37'),
(23, 'Giới thiệu', 'Giới thiệu', 'gioi-thieu', 'benzema.jpg', 'Tiền đạo người Pháp từng tức giận trước sự so sánh thiếu tôn trọng từ Jose Mourinho thời ông thầy cũ còn làm việc ở Real Madrid.', '<p style=\"text-align:justify\">Trong một buổi phỏng vấn gần đ&acirc;y với k&ecirc;nh Canal +, Karim Benzema tiết lộ nguy&ecirc;n nh&acirc;n dẫn đến sự bất h&ograve;a giữa anh v&agrave; Jose Mourinho tại Real. Ch&acirc;n s&uacute;t 29 n&oacute;i rằng anh cảm thấy kh&ocirc;ng được t&ocirc;n trọng khi bị HLV so s&aacute;nh với m&egrave;o. Khi ấy, Mourinho n&oacute;i rằng c&oacute; Benzema trong đội h&igrave;nh như &quot;đi săn với một ch&uacute; m&egrave;o thay v&igrave; một ch&uacute; ch&oacute;&quot;.<br />\n&quot;Ch&uacute;ng t&ocirc;i c&oacute; quan hệ tốt cho đến khi &ocirc;ng ta d&ugrave;ng những cụm từ v&agrave; những nhận x&eacute;t qu&aacute; đ&aacute;ng. T&ocirc;i c&oacute; cảm gi&aacute;c l&agrave; &ocirc;ng ấy thấy vui với những c&acirc;u n&oacute;i đ&oacute;, v&agrave; mặc d&ugrave; từng rất t&ocirc;n trọng &ocirc;ng ấy, t&ocirc;i bắt đầu ph&aacute;t c&aacute;u&quot;, Benzema n&oacute;i.</p>\n\n<p style=\"text-align:justify\">&quot;T&ocirc;i n&oacute;i với &ocirc;ng ấy l&agrave; ch&uacute;ng t&ocirc;i cần n&oacute;i chuyện rồi ch&uacute;ng t&ocirc;i c&oacute; một buổi họp trong một tiếng. T&ocirc;i n&oacute;i với &ocirc;ng ấy: &#39;T&ocirc;i l&agrave; cầu thủ, &ocirc;ng l&agrave; HLV của t&ocirc;i v&agrave; t&ocirc;i t&ocirc;n trọng &ocirc;ng nhưng &ocirc;ng cũng cần phải t&ocirc;n trọng t&ocirc;i&#39;&quot;, anh cho biết th&ecirc;m. &quot;Từ sau đ&oacute;, kh&ocirc;ng c&ograve;n c&acirc;u chuyện n&agrave;o về ch&oacute;, m&egrave;o hay bất kỳ thứ g&igrave; kh&aacute;c xuất hiện nữa. T&ocirc;i c&oacute; thể l&agrave; người nh&uacute;t nh&aacute;t, nhưng nếu ai đ&oacute; cười v&agrave;o mặt t&ocirc;i, t&ocirc;i sẽ phản ứng lại. Khi bạn n&oacute;i chuyện thẳng thắn, mọi thứ sẽ tốt hơn&quot;.</p>\n\n<p style=\"text-align:justify\">Sự việc Mourinho so s&aacute;nh Benzema với m&egrave;o, &aacute;m chỉ việc tiền đạo n&agrave;y lười di chuyển, diễn ra trong một buổi họp b&aacute;o v&agrave;o năm 2011. Nh&agrave; cầm qu&acirc;n 54 tuổi bị Real sa thải hai năm sau đ&oacute;.</p>', NULL, '', 'metakeyword giới thiệu', 'metadescription giới thiệu', 9, 1, '2017-11-15 03:28:13', '2017-11-22 15:41:59'),
(25, 'Banner chính 1', '', 'banner-chinh-1', 'megashop-banner-1.jpg', '', '', NULL, '', '', '', 1, 1, '2017-11-21 15:05:25', '2017-11-21 15:05:25'),
(26, 'Banner chính 2', '', 'banner-chinh-2', 'megashop-banner-2.jpg', '', '', NULL, '', '', '', 2, 1, '2017-11-21 15:05:48', '2017-11-22 08:10:23'),
(27, 'Nội thất sang trọng', '', 'banner-trai', 'noi-that-sang-trong.jpg', '', '', 'http://noithatgialai.net/', '', '', '', 8, 1, '2017-11-21 15:14:07', '2017-11-23 11:56:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `article_category`
--

DROP TABLE IF EXISTS `article_category`;
CREATE TABLE `article_category` (
  `id` bigint(20) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `category_article_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `article_category`
--

INSERT INTO `article_category` (`id`, `article_id`, `category_article_id`, `created_at`, `updated_at`) VALUES
(50, 7, 2, '2017-11-14 10:54:19', '2017-11-14 10:54:19'),
(51, 8, 2, '2017-11-14 10:56:23', '2017-11-14 10:56:23'),
(52, 9, 2, '2017-11-14 10:57:45', '2017-11-14 10:57:45'),
(54, 11, 2, '2017-11-14 11:00:55', '2017-11-14 11:00:55'),
(55, 12, 2, '2017-11-14 11:01:52', '2017-11-14 11:01:52'),
(56, 13, 2, '2017-11-14 11:02:57', '2017-11-14 11:02:57'),
(57, 14, 2, '2017-11-14 11:04:14', '2017-11-14 11:04:14'),
(58, 1, 5, '2017-11-14 11:05:10', '2017-11-14 11:05:10'),
(59, 5, 5, '2017-11-14 11:05:29', '2017-11-14 11:05:29'),
(60, 6, 5, '2017-11-14 11:05:38', '2017-11-14 11:05:38'),
(61, 4, 5, '2017-11-14 11:05:54', '2017-11-14 11:05:54'),
(62, 15, 1, '2017-11-14 11:07:32', '2017-11-14 11:07:32'),
(63, 16, 1, '2017-11-14 11:07:57', '2017-11-14 11:07:57'),
(64, 17, 1, '2017-11-14 11:08:22', '2017-11-14 11:08:22'),
(65, 18, 1, '2017-11-14 11:08:48', '2017-11-14 11:08:48'),
(66, 19, 1, '2017-11-14 11:10:11', '2017-11-14 11:10:11'),
(67, 20, 1, '2017-11-14 11:10:29', '2017-11-14 11:10:29'),
(69, 10, 2, '2017-11-14 17:15:35', '2017-11-14 17:15:35'),
(78, 23, 0, '2017-11-15 03:34:33', '2017-11-15 03:34:33'),
(80, 25, 7, '2017-11-21 15:05:25', '2017-11-21 15:05:25'),
(81, 26, 7, '2017-11-21 15:05:49', '2017-11-21 15:05:49'),
(82, 27, 8, '2017-11-21 15:14:07', '2017-11-21 15:14:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `banner`
--

INSERT INTO `banner` (`id`, `fullname`, `alias`, `image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Banner1', 'banner-1', 'megashop-banner-1.jpg', 1, 1, '2017-11-10 19:20:58', '2017-11-13 17:19:09'),
(2, 'Banner2', 'banner-2', 'megashop-banner-2.jpg', 2, 1, '2017-11-13 17:19:24', '2017-11-13 17:19:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_article`
--

DROP TABLE IF EXISTS `category_article`;
CREATE TABLE `category_article` (
  `id` bigint(20) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `meta_keyword` text COLLATE utf8_unicode_ci,
  `meta_description` text COLLATE utf8_unicode_ci,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category_article`
--

INSERT INTO `category_article` (`id`, `fullname`, `title`, `meta_keyword`, `meta_description`, `alias`, `parent_id`, `image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Đối tác', NULL, NULL, NULL, 'doi-tac', 0, NULL, 1, 1, '2017-11-14 10:07:40', '2017-11-14 10:09:06'),
(2, 'Mẹo hay nhà bếp', 'tiêu đề mẹo hay nhà bếp', 'metakeyword mẹo hay nhà bếp', 'metadescription mẹo hay nhà bếp', 'meo-hay-nha-bep', 0, NULL, 3, 1, '2017-11-14 10:40:55', '2017-11-23 14:34:06'),
(3, 'Sống khỏe', NULL, NULL, NULL, 'song-khoe', 0, NULL, 4, 1, '2017-11-14 10:41:25', '2017-11-14 11:05:00'),
(4, 'Thực phẩm sạch', NULL, NULL, NULL, 'thuc-pham-sach', 0, NULL, 5, 1, '2017-11-14 10:41:41', '2017-11-14 11:05:00'),
(5, 'Khách hàng', NULL, NULL, NULL, 'khach-hang', 0, NULL, 2, 1, '2017-11-14 11:04:53', '2017-11-14 11:05:00'),
(7, 'Banner chính', 'Banner chính', '', '', 'banner-chinh', 0, NULL, 6, 1, '2017-11-21 15:04:24', '2017-11-21 15:04:30'),
(8, 'Banner trái', '', '', '', 'banner-trai', 0, NULL, 7, 1, '2017-11-21 15:12:33', '2017-11-21 15:12:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_product`
--

DROP TABLE IF EXISTS `category_product`;
CREATE TABLE `category_product` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `meta_keyword` text COLLATE utf8_unicode_ci,
  `meta_description` text COLLATE utf8_unicode_ci,
  `alias` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `category_product`
--

INSERT INTO `category_product` (`id`, `fullname`, `title`, `meta_keyword`, `meta_description`, `alias`, `image`, `status`, `parent_id`, `sort_order`, `created_at`, `updated_at`) VALUES
(10, 'Phòng khách', NULL, NULL, NULL, 'phong-khach', NULL, 1, 0, 1, '2017-10-05 15:08:13', '2017-11-14 06:57:51'),
(11, 'Phòng ngủ', NULL, NULL, NULL, 'phong-ngu', 'category-product-7.png', 1, 0, 2, '2017-10-05 15:08:25', '2017-11-13 18:00:34'),
(12, 'Sofa', 'Tiêu đề sofa', 'metakeyword sofa', 'metadescription sofa', 'sofa', 'category-product-1.png', 1, 0, 3, '2017-10-05 15:08:38', '2017-11-23 14:34:55'),
(13, 'Phòng bếp', NULL, NULL, NULL, 'phong-bep', 'category-product-5.png', 1, 0, 4, '2017-10-05 15:08:57', '2017-11-20 14:33:16'),
(14, 'Phòng trẻ em', NULL, NULL, NULL, 'phong-tre-em', 'category-product-2.png', 1, 0, 5, '2017-10-05 15:09:11', '2017-11-13 18:02:41'),
(15, 'Thiết bị bếp', NULL, NULL, NULL, 'thiet-bi-bep', 'category-product-9.png', 1, 0, 6, '2017-10-05 15:09:45', '2017-11-13 18:03:10'),
(16, 'Thiết bị vệ sinh', NULL, NULL, NULL, 'thiet-bi-ve-sinh', 'category-product-8.png', 1, 0, 7, '2017-10-05 15:09:57', '2017-11-13 18:02:41'),
(17, 'Đồ trang trí', NULL, NULL, NULL, 'do-trang-tri', 'category-product-10.png', 1, 0, 8, '2017-10-05 15:10:07', '2017-11-13 18:02:41'),
(18, 'Phụ kiện bếp', NULL, NULL, NULL, 'phu-kien-bep', 'phu-kien-bep.png', 1, 0, 9, '2017-10-05 15:10:24', '2017-11-13 18:05:49'),
(19, 'Nhà thông minh', NULL, NULL, NULL, 'nha-thong-minh', 'category-product-3.png', 1, 0, 10, '2017-10-05 15:10:50', '2017-11-13 18:02:41'),
(21, 'Bàn ghế gỗ', NULL, NULL, NULL, 'ban-ghe-go', NULL, 1, 10, 1, '2017-11-13 18:06:56', '2017-11-21 14:46:20'),
(22, 'Sofa - phòng khách', NULL, NULL, NULL, 'sofa-phong-khach', NULL, 1, 10, 2, '2017-11-13 18:07:25', '2017-11-20 14:32:12'),
(23, 'Tủ để giày', NULL, NULL, NULL, 'tu-de-giay', NULL, 1, 10, 3, '2017-11-13 18:07:49', '2017-11-20 14:32:12'),
(24, 'Tủ rượu', NULL, NULL, NULL, 'tu-ruou', NULL, 1, 10, 4, '2017-11-13 18:08:05', '2017-11-20 14:32:12'),
(25, 'Vách ngăn', NULL, NULL, NULL, 'vach-ngan', NULL, 1, 10, 5, '2017-11-13 18:08:21', '2017-11-20 14:32:12'),
(26, 'Bàn làm việc', NULL, NULL, NULL, 'ban-lam-viec', NULL, 1, 11, 5, '2017-11-13 18:08:55', '2017-11-20 14:29:02'),
(27, 'Bàn trang điểm', NULL, NULL, NULL, 'ban-trang-diem', NULL, 1, 11, 1, '2017-11-13 18:09:15', '2017-11-20 14:29:02'),
(28, 'Giường ngủ', NULL, NULL, NULL, 'giuong-ngu', NULL, 1, 11, 2, '2017-11-13 18:09:47', '2017-11-20 14:29:02'),
(29, 'Kệ tivi', NULL, NULL, NULL, 'ke-tivi', NULL, 1, 11, 3, '2017-11-13 18:10:08', '2017-11-20 14:29:02'),
(30, 'Quần áo', NULL, NULL, NULL, 'quan-ao', NULL, 1, 11, 4, '2017-11-13 18:10:24', '2017-11-20 14:29:02'),
(31, 'Sofa cafe', NULL, NULL, NULL, 'sofa-cafe', NULL, 1, 12, 1, '2017-11-13 18:10:52', '2017-11-13 18:10:52'),
(32, 'Sofa da', NULL, NULL, NULL, 'sofa-da', NULL, 1, 12, 2, '2017-11-13 18:11:05', '2017-11-13 18:11:05'),
(33, 'Sofa giường', NULL, NULL, NULL, 'sofa-giuong', NULL, 1, 12, 3, '2017-11-13 18:11:22', '2017-11-13 18:11:22'),
(34, 'Sofa nghỉ', NULL, NULL, NULL, 'sofa-nghi', NULL, 1, 12, 4, '2017-11-13 18:11:39', '2017-11-13 18:11:39'),
(35, 'Bàn ghế ăn', NULL, NULL, NULL, 'ban-ghe-an', NULL, 1, 13, 1, '2017-11-13 18:12:08', '2017-11-13 18:12:08'),
(36, 'Quầy bar', NULL, NULL, NULL, 'quay-bar', NULL, 1, 13, 2, '2017-11-13 18:12:45', '2017-11-13 18:12:45'),
(37, 'Tủ bếp', NULL, NULL, NULL, 'tu-bep', NULL, 1, 13, 3, '2017-11-13 18:13:00', '2017-11-13 18:13:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `mobilephone` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fax` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`id`, `username`, `password`, `email`, `fullname`, `address`, `phone`, `mobilephone`, `fax`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'dienit02', 'e10adc3949ba59abbe56e057f20f883e', 'dienit02@gmail.com', 'Nguyễn Kim Điền', '11 Tân Canh , P.1 , Q. Tân Phú , TP. Hồ Chí Minh', '0889715690', '0988162753', '1781378878', 1, 10, '2017-05-12 16:41:57', '2017-05-26 11:22:44'),
(2, 'sanghv', 'e10adc3949ba59abbe56e057f20f883e', 'sanghv@gmail.com', 'Huỳnh Văn Sang', '234 Gò Vấp', '0889715691', '0988162751', '9731738124', 1, 9, '2017-05-13 04:12:55', '2017-05-20 10:51:48'),
(3, 'cuongtt', 'e10adc3949ba59abbe56e057f20f883e', 'cuongtt@ttcgroup.vn', 'Trương Trí Cường', '24 Nguyễn Trọng Tuyển', '0889715692', '0988162752', '8727821812', 1, 8, '2017-05-13 04:17:02', '2017-05-20 10:51:48'),
(4, 'trietnk01', 'e10adc3949ba59abbe56e057f20f883e', 'trietnk01@gmail.com', 'Nguyễn Kim Triết', '538/27 Lý Thường Kiệt', '0889715693', '0988162756', '8728748188', 1, 7, '2017-05-13 04:25:11', '2017-05-20 10:51:48'),
(5, 'tailm', 'e10adc3949ba59abbe56e057f20f883e', 'tailm@gmail.com', 'Lê Minh Tài', '781 Hoàng Văn Thụ', '0889715612', '0988953215', '8238778843', 1, 6, '2017-05-13 04:29:15', '2017-05-20 10:51:48'),
(6, 'chauttn', 'e10adc3949ba59abbe56e057f20f883e', 'chautt@gmail.com', 'Từ Thị Ngọc Châu', '76 Lý Thái Tổ', '0812345678', '0988123456', '2222233333', 1, 5, '2017-05-13 04:33:51', '2017-05-20 10:51:48'),
(7, 'duyla', 'e10adc3949ba59abbe56e057f20f883e', 'duyla@ttcgroup.vn', 'Lý Anh Duy', '28 Trần Huy Liệu', '0872732772', '0988956123', '8787238728', 1, 4, '2017-05-13 09:22:00', '2017-11-17 05:16:02'),
(8, 'chauvn', 'e10adc3949ba59abbe56e057f20f883e', 'chauvn@ttcgroup.vn', 'Võ Ngọc Châu', '70 Trương Quốc Dung', '88113322', '0988111222', '99887711', 1, 3, '2017-05-13 09:28:01', '2017-05-20 10:51:48'),
(9, 'thangnc', 'e10adc3949ba59abbe56e057f20f883e', 'thangnc@ttcgroup.vn', 'Nguyễn Chí Thăng', '83 Nguyễn Trọng Tuyển', '3322116677', '0988666222', '4888221111', 1, 2, '2017-05-13 09:29:29', '2017-11-16 19:09:28'),
(10, 'thaihst', 'e10adc3949ba59abbe56e057f20f883e', 'thaihst@ttcgroup.vn', 'Hồ Sỹ Thiên Thai', '16 Nguyễn Văn Trỗi', '0811111111', '0911111111', '1111111111', 1, 1, '2017-05-14 10:05:55', '2017-11-11 19:20:26'),
(11, 'lantv_123', '25f9e794323b453885f5181f1b624d0b', 'lantv@gmail.com', 'Trần Văn Lân', '11 Nguyễn Bỉnh Khiêm , P.1 , Q. Tân Bình , TP. Hồ Chí Minh', '0828671243', '0988152783', '8825995434', 1, 11, '2017-11-16 11:55:57', '2017-11-16 14:44:32'),
(12, 'datnv_123', 'e10adc3949ba59abbe56e057f20f883e', 'datnv@gmail.com', 'Nguyễn Văn Đạt', '12 Nguyễn Bỉnh Khiêm , P.1 , Q. Tân Bình , TP. Hồ Chí Minh', '0832489985', '0982398892', '8894838953', 1, 1, '2017-11-16 15:22:44', '2017-11-21 11:29:53'),
(13, 'hantbao', 'e10adc3949ba59abbe56e057f20f883e', 'hantbao@gmail.com', 'Trần Bảo Hân', '12 Lý Chính Thắng', '083727872883', '0988162789', '78875834883', 1, 1, '2017-11-16 19:11:05', '2017-11-22 00:41:47'),
(14, 'tuthanhha', 'e10adc3949ba59abbe56e057f20f883e', 'tuthanhha@gmail.com', 'Hà Thanh Tú', '34 Nguyễn Diệu', '8928589923', '0988123456', '8775848378', 1, 1, '2017-11-16 19:12:49', '2017-11-16 19:12:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `group_member`
--

DROP TABLE IF EXISTS `group_member`;
CREATE TABLE `group_member` (
  `id` bigint(20) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `group_member`
--

INSERT INTO `group_member` (`id`, `fullname`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 3, '2016-12-17 05:05:18', '2017-10-07 19:06:51'),
(2, 'Bài viết', 2, '2016-12-17 05:05:41', '2017-10-07 19:06:35'),
(4, 'Hệ thống', 1, '2016-12-17 05:26:59', '2017-10-07 19:06:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `group_privilege`
--

DROP TABLE IF EXISTS `group_privilege`;
CREATE TABLE `group_privilege` (
  `id` int(11) NOT NULL,
  `group_member_id` int(11) DEFAULT NULL,
  `privilege_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `mobilephone` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fax` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_method_id` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `invoice`
--

INSERT INTO `invoice` (`id`, `code`, `customer_id`, `username`, `email`, `fullname`, `address`, `phone`, `mobilephone`, `fax`, `quantity`, `total_price`, `payment_method_id`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'jsytcxn4mzq20flia653', 7, 'duyla', 'duyla@ttcgroup.vn', 'Lý Anh Duy', '28 Trần Huy Liệu', '0872732772', '0988956123', '8787238728', 1, '4000000.00', 3, 0, 1, '2017-11-17 06:43:05', '2017-11-17 06:43:05'),
(2, '96i3k57vnacbqemu0fzw', 12, 'datnv_123', 'datnv@gmail.com', 'Nguyễn Văn Đạt', '12 Nguyễn Bỉnh Khiêm , P.1 , Q. Tân Bình , TP. Hồ Chí Minh', '0832489985', '0982398892', '8894838953', 1, '4000000.00', 2, 0, 1, '2017-11-21 11:49:11', '2017-11-21 11:49:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice_detail`
--

DROP TABLE IF EXISTS `invoice_detail`;
CREATE TABLE `invoice_detail` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `product_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `product_image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_total_price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `invoice_detail`
--

INSERT INTO `invoice_detail` (`id`, `invoice_id`, `product_id`, `product_code`, `product_name`, `product_image`, `product_price`, `product_quantity`, `product_total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '123456789', 'Sofa 1', 'sofa-1.png', '4000000.00', 1, '4000000.00', '2017-11-17 06:43:05', '2017-11-17 06:43:05'),
(2, 2, 7, '123456789', 'Sofa 1', 'sofa-1.png', '4000000.00', 1, '4000000.00', '2017-11-21 11:49:11', '2017-11-21 11:49:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` bigint(20) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `site_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_type_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `menu`
--

INSERT INTO `menu` (`id`, `fullname`, `alias`, `site_link`, `parent_id`, `menu_type_id`, `level`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Trang chủ', 'trang-chu', '', 0, 1, 0, 1, 1, '2017-11-13 04:31:34', '2017-11-15 04:54:37'),
(6, 'Giới thiệu', 'gioi-thieu', '/bai-viet/gioi-thieu', 0, 1, 0, 2, 1, '2017-11-13 04:36:20', '2017-11-23 18:15:18'),
(7, 'Tin tức', 'tin-tuc', '/chu-de/meo-hay-nha-bep', 0, 1, 0, 3, 1, '2017-11-13 04:36:41', '2017-11-15 10:42:16'),
(8, 'Sản phẩm', 'san-pham', '/loai-san-pham/sofa', 0, 1, 0, 4, 1, '2017-11-13 04:37:00', '2017-11-16 04:45:49'),
(9, 'Phòng khách', 'phong-khach', '/loai-san-pham/phong-khach', 8, 1, 1, 1, 1, '2017-11-13 04:37:45', '2017-11-13 04:37:45'),
(10, 'Phòng ngủ', 'phong-phu', '/loai-san-pham/phong-ngu', 8, 1, 1, 2, 1, '2017-11-13 04:38:12', '2017-11-13 04:38:19'),
(11, 'Sofa', 'sofa', '/loai-san-pham/sofa', 8, 1, 1, 3, 1, '2017-11-13 04:38:44', '2017-11-13 04:38:44'),
(12, 'Phòng bếp', 'phong-bep', '/loai-san-pham/phong-bep', 8, 1, 1, 4, 1, '2017-11-13 04:39:09', '2017-11-13 04:39:09'),
(13, 'Phòng trẻ em', 'phong-tre-em', '/loai-san-pham/phong-tre-em', 8, 1, 1, 5, 1, '2017-11-13 04:39:34', '2017-11-13 04:39:34'),
(14, 'Phòng khách', 'phong-khach', '/loai-san-pham/phong-khach', 0, 2, 0, 1, 1, '2017-11-13 18:18:44', '2017-11-13 18:18:44'),
(15, 'Phòng ngủ', 'phong-ngu', '/loai-san-pham/phong-ngu', 0, 2, 0, 2, 1, '2017-11-13 18:20:32', '2017-11-13 18:20:32'),
(16, 'Sofa', 'sofa', '/loai-san-pham/sofa', 0, 2, 0, 3, 1, '2017-11-13 18:20:53', '2017-11-13 18:20:53'),
(17, 'Phòng bếp', 'phong-bep', '/loai-san-pham/phong-bep', 0, 2, 0, 4, 1, '2017-11-13 18:21:24', '2017-11-13 18:21:24'),
(18, 'Phòng trẻ em', 'phong-tre-em', '/loai-san-pham/phong-tre-em', 0, 2, 0, 5, 1, '2017-11-13 18:21:54', '2017-11-13 18:21:54'),
(19, 'Thiết bị bếp', 'thiet-bi-bep', '/loai-san-pham/thiet-bi-bep', 0, 2, 0, 6, 1, '2017-11-13 18:22:23', '2017-11-13 18:22:23'),
(20, 'Thiết bị vệ sinh', 'thiet-bi-ve-sinh', '/loai-san-pham/thiet-bi-ve-sinh', 0, 2, 0, 7, 1, '2017-11-13 18:22:47', '2017-11-13 18:22:47'),
(21, 'Đồ trang trí', 'do-trang-tri', '/loai-san-pham/do-trang-tri', 0, 2, 0, 8, 1, '2017-11-13 18:23:13', '2017-11-13 18:23:17'),
(22, 'Phụ kiện bếp', 'phu-kien-bep', '/loai-san-pham/phu-kien-bep', 0, 2, 0, 9, 1, '2017-11-13 18:23:41', '2017-11-13 18:23:41'),
(23, 'Nhà thông minh', 'nha-thong-minh', '/loai-san-pham/nha-thong-minh', 0, 2, 0, 10, 1, '2017-11-13 18:24:08', '2017-11-13 18:24:08'),
(24, 'Bàn ghế gỗ', 'ban-ghe-go', '/loai-san-pham/ban-ghe-go', 14, 2, 1, 1, 1, '2017-11-13 18:24:41', '2017-11-13 18:24:41'),
(25, 'Sofa phòng khách', 'sofa-phong-khach', '/loai-san-pham/sofa-phong-khach', 14, 2, 1, 2, 1, '2017-11-13 18:25:10', '2017-11-13 18:25:10'),
(26, 'Tủ để giày', 'tu-de-giay', '/loai-san-pham/tu-de-giay', 14, 2, 1, 3, 1, '2017-11-13 18:25:38', '2017-11-13 18:25:38'),
(27, 'Tủ rượu', 'tu-ruou', '/loai-san-pham/tu-ruou', 14, 2, 1, 4, 1, '2017-11-13 18:26:00', '2017-11-13 18:26:00'),
(28, 'Vách ngăn', 'vach-ngan', '/loai-san-pham/vach-ngan', 14, 2, 1, 5, 1, '2017-11-13 18:26:41', '2017-11-13 18:26:41'),
(29, 'Bàn làm việc', 'ban-lam-viec', '/loai-san-pham/ban-lam-viec', 15, 2, 1, 1, 1, '2017-11-13 18:27:20', '2017-11-13 18:27:20'),
(30, 'Bàn trang điểm', 'ban-trang-diem', '/loai-san-pham/ban-trang-diem', 15, 2, 1, 2, 1, '2017-11-13 18:27:51', '2017-11-13 18:27:51'),
(31, 'Giường ngủ', 'giuong-ngu', '/loai-san-pham/giuong-ngu', 15, 2, 1, 3, 1, '2017-11-13 18:28:20', '2017-11-13 18:28:20'),
(32, 'Kệ tivi', 'ke-tivi', '/loai-san-pham/ke-tivi', 15, 2, 1, 4, 1, '2017-11-13 18:28:51', '2017-11-13 18:28:51'),
(33, 'Tủ quần áo', 'tu-quan-ao', '/loai-san-pham/quan-ao', 15, 2, 1, 5, 1, '2017-11-13 18:29:25', '2017-11-13 18:29:25'),
(34, 'Sofa cafe', 'sofa-cafe', '1', 16, 2, 1, 1, 1, '2017-11-13 18:29:52', '2017-11-13 18:29:52'),
(35, 'Sofa da', 'sofa-da', '/loai-san-pham/sofa-da', 16, 2, 1, 2, 1, '2017-11-13 18:30:11', '2017-11-13 18:30:11'),
(36, 'Sofa giường', 'sofa-giuong', '/loai-san-pham/sofa-giuong', 16, 2, 1, 2, 1, '2017-11-13 18:30:35', '2017-11-13 18:30:35'),
(37, 'Sofa nghỉ', 'sofa-nghi', '/loai-san-pham/sofa-nghi', 16, 2, 1, 4, 1, '2017-11-13 18:30:59', '2017-11-13 18:30:59'),
(38, 'Bàn ghế ăn', 'ban-ghe-an', '/loai-san-pham/ban-ghe-an', 17, 2, 1, 1, 1, '2017-11-13 18:31:34', '2017-11-13 18:31:34'),
(39, 'Quầy bar', 'quay-bar', '/loai-san-pham/quay-bar', 17, 2, 1, 2, 1, '2017-11-13 18:32:20', '2017-11-13 18:32:30'),
(40, 'Tủ bếp', 'tu-bep', '/loai-san-pham/tu-bep', 17, 2, 1, 3, 1, '2017-11-13 18:32:55', '2017-11-13 18:32:55'),
(41, 'Trang chủ', 'trang-chu', '/trang-chu', 0, 3, 0, 1, 1, '2017-11-14 17:49:56', '2017-11-14 17:49:56'),
(42, 'Giới thiệu', 'gioi-thieu', '/bai-viet/gioi-thieu', 0, 3, 0, 2, 1, '2017-11-14 17:52:28', '2017-11-14 17:52:28'),
(43, 'Tin tức', 'tin-tuc', '/tin-tuc', 0, 3, 0, 3, 1, '2017-11-14 17:53:18', '2017-11-14 17:53:18'),
(44, 'Sản phẩm', 'san-pham', '/san-pham', 0, 3, 0, 4, 1, '2017-11-14 17:53:35', '2017-11-14 17:53:35'),
(45, 'Liên hệ', 'lien-he', '/lien-he', 0, 3, 0, 5, 1, '2017-11-14 17:53:47', '2017-11-14 17:53:47'),
(46, 'Tìm kiếm', 'tim-kiem', '/tim-kiem', 0, 4, 0, 1, 1, '2017-11-14 18:12:42', '2017-11-14 18:12:42'),
(47, 'Tư vấn thiết kế', 'tu-van-thiet-ke', '/bai-viet/tu-van-thiet-ke', 0, 4, 0, 4, 1, '2017-11-14 18:13:05', '2017-11-14 18:14:01'),
(48, 'Chăm sóc khách hàng', 'cham-soc-khach-hang', '/bai-viet/cham-soc-khach-hang', 0, 4, 0, 2, 1, '2017-11-14 18:13:26', '2017-11-14 18:14:01'),
(49, 'Kiểm tra đơn hàng', 'kiem-tra-don-hang', '/bai-viet/kiem-tra-don-hang', 0, 4, 0, 3, 1, '2017-11-14 18:13:50', '2017-11-14 18:14:01'),
(50, 'Hướng dẫn mua hàng', 'huong-dan-mua-hang', '/bai-viet/huong-dan-mua-hang', 0, 5, 0, 1, 1, '2017-11-14 18:15:10', '2017-11-14 18:15:10'),
(51, 'Giao nhận và thanh toán', 'giao-nhan-va-thanh-toan', '/bai-viet/giao-nhan-va-thanh-toan', 0, 5, 0, 4, 1, '2017-11-14 18:15:36', '2017-11-15 04:53:36'),
(52, 'Đổi trả và bảo hành', 'doi-tra-va-bao-hanh', '/bai-viet/doi-tra-va-bao-hanh', 0, 5, 0, 2, 1, '2017-11-14 18:15:59', '2017-11-14 18:16:31'),
(53, 'Đăng ký thành viên', 'dang-ky-thanh-vien', '/bai-viet/dang-ky-thanh-vien', 0, 5, 0, 3, 1, '2017-11-14 18:16:20', '2017-11-14 18:16:31'),
(54, 'Chính sách thanh toán', 'chinh-sach-thanh-toan', '/bai-viet/chinh-sach-thanh-toan', 0, 6, 0, 1, 1, '2017-11-14 18:17:22', '2017-11-14 18:17:22'),
(55, 'Chính sách vận chuyển', 'chinh-sach-van-chuyen', '/bai-viet/chinh-sach-van-chuyen', 0, 6, 0, 2, 1, '2017-11-14 18:17:46', '2017-11-14 18:21:47'),
(56, 'Chính sách đổi trả', 'chinh-sach-doi-tra', '/bai-viet/chinh-sach-doi-tra', 0, 6, 0, 3, 1, '2017-11-14 18:18:05', '2017-11-14 18:21:47'),
(57, 'Chính sách bảo hành', 'chinh-sach-bao-hanh', '/bai-viet/chinh-sach-bao-hanh', 0, 6, 0, 4, 1, '2017-11-14 18:18:26', '2017-11-14 18:21:47'),
(58, 'Đội ngũ chuyên nghiệp', 'doi-ngu-chuyen-nghiep', '/bai-viet/doi-ngu-chuyen-nghiep', 0, 7, 0, 1, 1, '2017-11-14 18:19:20', '2017-11-14 18:19:20'),
(59, 'Giá cả hợp lý', 'gia-ca-hop-ly', '/bai-viet/gia-ca-hop-ly', 0, 7, 0, 2, 1, '2017-11-14 18:19:38', '2017-11-14 18:20:42'),
(60, 'Kinh nghiệm trên 20 năm', 'kinh-nghiem-tren-20-nam', '/bai-viet/kinh-nghiem-tren-20-nam', 0, 7, 0, 3, 1, '2017-11-14 18:20:05', '2017-11-14 18:20:42'),
(61, 'Đảm bảo tiến độ', 'dam-bao-tien-do', '/bai-viet/dam-bao-tien-do', 0, 7, 0, 4, 1, '2017-11-14 18:20:34', '2017-11-14 18:20:42'),
(62, 'Mẹo hay nhà bếp', 'meo-hay-nha-bep', '/chu-de/meo-hay-nha-bep', 0, 8, 0, 1, 1, '2017-11-15 04:29:10', '2017-11-15 04:29:10'),
(63, 'Sống khỏe', 'song-khoe', '/chu-de/song-khoe', 0, 8, 0, 2, 1, '2017-11-15 04:29:53', '2017-11-15 04:29:53'),
(64, 'Thực phẩm sạch', 'thuc-pham-sach', '/chu-de/thuc-pham-sach', 0, 8, 0, 3, 1, '2017-11-15 04:30:23', '2017-11-15 04:30:23'),
(65, 'Phòng khách', 'phong-khach', '/loai-san-pham/phong-khach', 0, 9, 0, 1, 1, '2017-11-15 17:56:21', '2017-11-15 17:56:21'),
(66, 'Phòng ngủ', 'phong-ngu', '/loai-san-pham/phong-ngu', 0, 9, 0, 2, 1, '2017-11-15 17:56:45', '2017-11-15 17:56:45'),
(67, 'Sofa', 'sofa', '/loai-san-pham/sofa', 0, 9, 0, 3, 1, '2017-11-15 17:57:02', '2017-11-15 17:57:02'),
(68, 'Phòng bếp', 'phong-bep', '/loai-san-pham/phong-bep', 0, 9, 0, 4, 1, '2017-11-15 17:57:21', '2017-11-15 17:57:21'),
(69, 'Phòng trẻ em', 'phong-tre-em', '/loai-san-pham/phong-tre-em', 0, 9, 0, 5, 1, '2017-11-15 17:57:44', '2017-11-15 17:57:44'),
(70, 'Liên hệ', 'lien-he', '/lien-he', 0, 1, 0, 5, 1, '2017-11-24 16:41:32', '2017-11-24 16:42:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu_type`
--

DROP TABLE IF EXISTS `menu_type`;
CREATE TABLE `menu_type` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `theme_location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `menu_type`
--

INSERT INTO `menu_type` (`id`, `fullname`, `theme_location`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'MainMenu', 'main-menu', 1, '2017-11-13 04:27:56', '2017-11-13 04:55:08'),
(2, 'CategoryProductHome', 'category-product-home', 2, '2017-11-13 18:14:33', '2017-11-14 18:21:19'),
(3, 'MenuBottomContent', 'menu-bottom-content', 3, '2017-11-14 17:48:19', '2017-11-14 18:21:19'),
(4, 'Hỗ trợ', 'support', 4, '2017-11-14 18:12:18', '2017-11-14 18:21:19'),
(5, 'Hướng dẫn mua hàng', 'direction', 5, '2017-11-14 18:14:44', '2017-11-14 18:21:19'),
(6, 'Chính sách thanh toán', 'policy', 6, '2017-11-14 18:16:57', '2017-11-14 18:21:19'),
(7, 'Tại sao chọn chúng tôi', 'about-us', 7, '2017-11-14 18:18:49', '2017-11-14 18:21:19'),
(8, 'Danh mục bài viết', 'category-article', 8, '2017-11-15 04:13:57', '2017-11-15 04:28:27'),
(9, 'Danh mục sản phẩm', 'category-product', 9, '2017-11-15 17:55:23', '2017-11-15 18:16:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_07_02_230147_migration_cartalyst_sentinel', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `module_article`
--

DROP TABLE IF EXISTS `module_article`;
CREATE TABLE `module_article` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `article_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `module_article`
--

INSERT INTO `module_article` (`id`, `fullname`, `article_id`, `position`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'module article 3', '7,8,9', 'position-3', 0, 3, '2017-10-08 18:52:22', '2017-10-08 18:56:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `module_item`
--

DROP TABLE IF EXISTS `module_item`;
CREATE TABLE `module_item` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_id` text COLLATE utf8_unicode_ci,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `component` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `module_item`
--

INSERT INTO `module_item` (`id`, `fullname`, `item_id`, `position`, `component`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Featured product', '[{\"id\":7,\"sort_order\":\"1\"},{\"id\":8,\"sort_order\":\"2\"},{\"id\":9,\"sort_order\":\"3\"},{\"id\":10,\"sort_order\":\"4\"},{\"id\":11,\"sort_order\":\"5\"},{\"id\":12,\"sort_order\":\"6\"},{\"id\":13,\"sort_order\":\"7\"},{\"id\":14,\"sort_order\":\"8\"}]', 'featured-product', 'product', 1, 1, '2017-11-10 11:24:02', '2017-11-23 11:22:26'),
(2, 'Toilet equipment', '[{\"id\":7,\"sort_order\":\"1\"},{\"id\":8,\"sort_order\":\"2\"},{\"id\":9,\"sort_order\":\"3\"},{\"id\":10,\"sort_order\":\"4\"},{\"id\":11,\"sort_order\":\"5\"},{\"id\":12,\"sort_order\":\"6\"},{\"id\":13,\"sort_order\":\"7\"},{\"id\":14,\"sort_order\":\"8\"}]', 'toilet-equipment', 'product', 1, 10, '2017-11-14 08:51:21', '2017-11-23 11:04:41'),
(3, 'Chicken equipment', '[{\"id\":7,\"sort_order\":\"1\"},{\"id\":8,\"sort_order\":\"2\"},{\"id\":9,\"sort_order\":\"3\"},{\"id\":10,\"sort_order\":\"4\"},{\"id\":11,\"sort_order\":\"5\"},{\"id\":12,\"sort_order\":\"6\"},{\"id\":13,\"sort_order\":\"7\"},{\"id\":14,\"sort_order\":\"8\"}]', 'chicken-equipment', 'product', 1, 34, '2017-11-14 08:51:53', '2017-11-23 11:26:13'),
(4, 'Clever house', '[{\"id\":7,\"sort_order\":\"1\"},{\"id\":8,\"sort_order\":\"2\"},{\"id\":9,\"sort_order\":\"3\"},{\"id\":10,\"sort_order\":\"4\"},{\"id\":11,\"sort_order\":\"5\"},{\"id\":12,\"sort_order\":\"6\"},{\"id\":13,\"sort_order\":\"7\"},{\"id\":14,\"sort_order\":\"8\"}]', 'clever-house', 'product', 1, 3, '2017-11-14 08:52:39', '2017-11-23 11:26:59'),
(5, 'Customer', '[{\"id\":1,\"sort_order\":\"1\"},{\"id\":4,\"sort_order\":\"2\"},{\"id\":5,\"sort_order\":\"3\"},{\"id\":6,\"sort_order\":\"4\"}]', 'customer', 'article', 1, 4, '2017-11-14 10:25:39', '2017-11-23 11:30:42'),
(6, 'Tin mới', '[{\"id\":7,\"sort_order\":\"1\"},{\"id\":9,\"sort_order\":\"2\"},{\"id\":10,\"sort_order\":\"3\"},{\"id\":14,\"sort_order\":\"4\"}]', 'hot-article', 'article', 1, 5, '2017-11-14 17:18:39', '2017-11-23 12:29:40'),
(7, 'Partner', '[{\"id\":15,\"sort_order\":\"1\"},{\"id\":16,\"sort_order\":\"2\"},{\"id\":17,\"sort_order\":\"3\"},{\"id\":18,\"sort_order\":\"4\"},{\"id\":19,\"sort_order\":\"5\"},{\"id\":20,\"sort_order\":\"6\"}]', 'partner', 'article', 1, 6, '2017-11-14 17:26:58', '2017-11-23 11:29:15'),
(8, 'Bản quyền', '[{\"id\":21,\"sort_order\":\"1\"}]', 'copyright', 'article', 1, 7, '2017-11-14 19:26:42', '2017-11-23 11:30:04'),
(9, 'Bài viết nổi bật', NULL, 'featured-article-leftside', NULL, 1, 8, '2017-11-15 04:41:06', '2017-11-21 15:08:06'),
(10, 'Sản phẩm nổi bật', NULL, 'featured-product-leftside', NULL, 1, 9, '2017-11-15 18:20:20', '2017-11-21 15:08:06'),
(11, 'Slideshow', '[{\"id\":25,\"sort_order\":\"1\"},{\"id\":26,\"sort_order\":\"2\"}]', 'slideshow', 'article', 1, 2, '2017-11-21 15:07:49', '2017-11-23 11:24:51'),
(12, 'Nội thất sang trọng', '[{\"id\":27,\"sort_order\":\"1\"}]', 'noi-that-sang-trong', 'article', 1, 1, '2017-11-21 15:21:54', '2017-11-23 11:37:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `module_menu`
--

DROP TABLE IF EXISTS `module_menu`;
CREATE TABLE `module_menu` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_type_id` int(11) DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `module_menu`
--

INSERT INTO `module_menu` (`id`, `fullname`, `menu_type_id`, `position`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'module menu 2', 14, 'position-2', 1, 2, '2017-10-08 18:51:08', '2017-10-08 18:51:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mod_menu_type`
--

DROP TABLE IF EXISTS `mod_menu_type`;
CREATE TABLE `mod_menu_type` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `module_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mod_menu_type`
--

INSERT INTO `mod_menu_type` (`id`, `menu_id`, `module_id`, `module_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'module-item', '2017-11-14 08:11:12', '2017-11-14 08:11:12'),
(4, 1, 4, 'module-item', '2017-11-14 08:52:39', '2017-11-14 08:52:39'),
(7, 1, 2, 'module-item', '2017-11-14 09:36:06', '2017-11-14 09:36:06'),
(8, 1, 3, 'module-item', '2017-11-14 09:45:36', '2017-11-14 09:45:36'),
(9, 1, 5, 'module-item', '2017-11-14 10:25:39', '2017-11-14 10:25:39'),
(11, 1, 6, 'module-item', '2017-11-14 17:18:54', '2017-11-14 17:18:54'),
(12, 1, 7, 'module-item', '2017-11-14 17:26:58', '2017-11-14 17:26:58'),
(13, 1, 8, 'module-item', '2017-11-14 19:26:42', '2017-11-14 19:26:42'),
(14, 0, 9, 'module-item', '2017-11-15 04:41:06', '2017-11-15 04:41:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `content` text,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `payment_method`
--

INSERT INTO `payment_method` (`id`, `fullname`, `alias`, `content`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Chuyển khoản bằng tiền mặt', 'chuyen-khoan-bang-tien-mat', '<p style=\"text-align:justify\">Cờ vua Việt Nam từng sở hữu nhiều kỳ thủ v&ocirc; địch thế giới c&aacute;c cấp độ trẻ. Ti&ecirc;n phong l&agrave; Đ&agrave;o Thi&ecirc;n Hải &ndash; người thầy hiện tại của Anh Kh&ocirc;i. Thi&ecirc;n Hải học đ&aacute;nh cờ khi mới năm tuổi, sớm bộc lộ năng khiếu v&agrave; được dạy dỗ bởi &ocirc;ng Đặng Tất Thắng - từng c&oacute; c&ocirc;ng mang cờ vua về Việt Nam.</p>', 1, 1, '2017-11-10 18:10:47', '2017-11-11 19:33:27'),
(2, 'Chuyển khoản qua ngân hàng', 'chuyen-khoan-qua-ngan-hang', '<p style=\"text-align:justify\">Nhưng trong nh&oacute;m n&agrave;y chỉ c&oacute; Quang Li&ecirc;m đang tiến dần đến nh&oacute;m kỳ thủ h&agrave;ng đầu thế giới. Với Elo 2737 v&agrave; thứ 24 thế giới, kỳ thủ sinh năm 1991 trở th&agrave;nh niềm tự h&agrave;o l&agrave;ng cờ Việt. Quang Li&ecirc;m từng v&ocirc; địch cờ chớp thế giới, c&ugrave;ng những giải mở uy t&iacute;n như Aeroflot, SPICE Cup v&agrave; HDBank Cup&ndash; giải cờ quốc tế của Việt Nam. B&ecirc;n cạnh những yếu tố nội lực, si&ecirc;u đại kiện tướng duy nhất của Đ&ocirc;ng Nam &Aacute; tiến xa hơn cả nhờ được đầu tư, tập luyện c&ugrave;ng chuy&ecirc;n gia ngoại. Alexander Khalifman - thầy của Quang Li&ecirc;m, từng v&ocirc; địch thế giới do FIDE tổ chức.</p>', 2, 1, '2017-11-11 19:34:03', '2017-11-11 19:34:03'),
(3, 'Thanh toán qua paypal', 'paypal', '<p style=\"text-align:justify\">Gia đ&igrave;nh Anh Kh&ocirc;i cũng sẵn s&agrave;ng theo bước kỳ thủ sinh năm 2002, ở cả kh&iacute;a cạnh tinh thần v&agrave; t&agrave;i ch&iacute;nh. &ldquo;Mỗi c&acirc;y mỗi hoa, mỗi nh&agrave; mỗi cảnh. Kh&ocirc;ng phải gia đ&igrave;nh n&agrave;o cũng c&oacute; điều kiện giống nhau. Nhưng nếu Anh Kh&ocirc;i thực sự c&oacute; đam m&ecirc; v&agrave; quyết t&acirc;m, gia đ&igrave;nh sẽ quyết t&acirc;m hỗ trợ con&rdquo;, mẹ Anh Kh&ocirc;i chia sẻ</p>', 3, 1, '2017-11-11 19:44:25', '2017-11-11 19:44:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `persistences`
--

DROP TABLE IF EXISTS `persistences`;
CREATE TABLE `persistences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(6, 1, 'WphP2gHqBbRpGKp2WcZb6APTYCNo1onf', '2017-11-12 08:12:08', '2017-11-12 08:12:08'),
(12, 1, 'HMMWMPpBDgdUbv54tKOldPvWyvcaeDCp', '2017-11-12 08:20:55', '2017-11-12 08:20:55'),
(20, 1, 'F4bWDfEvllT0fTv4EzWDp3NWpLxGo4n5', '2017-11-12 08:44:06', '2017-11-12 08:44:06'),
(27, 1, 'f7VCzyYASPW5vTVgTfv3Ji50sxy2ckIt', '2017-11-12 10:14:09', '2017-11-12 10:14:09'),
(35, 1, 'Zlbi5ja6c9Z7no06i5MvPsa8kZI3oLEZ', '2017-11-12 10:41:59', '2017-11-12 10:41:59'),
(43, 3, 'ZsvbfzLh4A4k34VMpmZCqIO2KIDk9pzP', '2017-11-12 10:51:37', '2017-11-12 10:51:37'),
(45, 3, '61CQHzrI8v42ppzJ35HclGUgzulYNwKD', '2017-11-12 10:51:57', '2017-11-12 10:51:57'),
(48, 4, 'M1VbjAgWRrVuXhVCqqvWAQHP287e5fuk', '2017-11-12 11:00:38', '2017-11-12 11:00:38'),
(52, 4, 'zWj9obfujhk7L1DEKOcSOMTi49HvkeVo', '2017-11-12 11:04:17', '2017-11-12 11:04:17'),
(64, 4, 'sGcmm3lmMPLTUyFeagebRe9YiPjWxHn0', '2017-11-12 11:20:36', '2017-11-12 11:20:36'),
(68, 4, 'DsgzaC5yhMG3miJpNrQFeWCpBwqfsMuO', '2017-11-12 11:21:48', '2017-11-12 11:21:48'),
(71, 4, 'aFa63uj6gzLcV0mZtU0nYvVinHZnvyAi', '2017-11-12 11:22:33', '2017-11-12 11:22:33'),
(73, 4, 'P672dGDcBqxGazfRAzJtUxPwSjTq9N4K', '2017-11-12 11:22:59', '2017-11-12 11:22:59'),
(74, 4, 'm0D8Z9mVczUYgqkSJXAwGQi8S9EaqrSg', '2017-11-12 11:23:03', '2017-11-12 11:23:03'),
(94, 1, 'W1uglu6PzKaOfwxa766IOJ33NDdulIri', '2017-11-12 13:01:17', '2017-11-12 13:01:17'),
(105, 4, 'lpP9axx2fJB8SUi7t2NlNMHasH10fl9N', '2017-11-12 19:31:42', '2017-11-12 19:31:42'),
(106, 4, '1PNxpqM3E2RYNr5CT1NzPzCOlNu4xILB', '2017-11-12 19:31:45', '2017-11-12 19:31:45'),
(107, 4, 'IJleJPrQEduTCpRbolCVqNbD3vzzhqXH', '2017-11-12 19:31:51', '2017-11-12 19:31:51'),
(110, 4, 'RyU6rnrEVVwusqJpB1boWgpODKNKthib', '2017-11-12 19:32:50', '2017-11-12 19:32:50'),
(113, 4, '2iWGSejY4rkJdkY2iK65Na0UV05uJEZ3', '2017-11-12 19:34:34', '2017-11-12 19:34:34'),
(115, 1, 'WQkHX9pd7HnW6Fwd58b6FNwURcoRYyK6', '2017-11-12 19:36:57', '2017-11-12 19:36:57'),
(119, 4, 'FGLu6nkqZkVigimI5Chx4mNmXgdi22qe', '2017-11-12 19:44:50', '2017-11-12 19:44:50'),
(124, 1, '1kZXCQqSfCEwmILvBACrUaHl5MpzQWXX', '2017-11-12 20:47:34', '2017-11-12 20:47:34'),
(125, 1, 'XJfqJ7pZakt8xtLNkULZUElD7jHOCtKt', '2017-11-13 17:44:28', '2017-11-13 17:44:28'),
(129, 1, 'JtMzzU4e61U2GRbOedwzutyNWAHHRHKp', '2017-11-13 23:43:59', '2017-11-13 23:43:59'),
(134, 1, 'zTVEKL7zcc4kvYk80AuKHQkn17d1TX0d', '2017-11-14 07:10:53', '2017-11-14 07:10:53'),
(135, 1, 'ZxzpfDpxrMTx7dRhvd1IQs0KoAyp8beZ', '2017-11-14 10:00:40', '2017-11-14 10:00:40'),
(138, 1, 'M9zXqXyMOTprNqZQI4LEpKqNogmDZiCE', '2017-11-14 20:35:29', '2017-11-14 20:35:29'),
(139, 1, 'CDF73h1lqr864dh5T5BQdTRf0hcrS45y', '2017-11-15 01:20:36', '2017-11-15 01:20:36'),
(143, 1, '50Hrxr02Q6CqKUF4p0G0bpP6PhcrLaNG', '2017-11-15 10:34:05', '2017-11-15 10:34:05'),
(145, 1, 'LRlBDrPFH3sF0WLHAUBGdJuLn5beDkqb', '2017-11-15 10:45:25', '2017-11-15 10:45:25'),
(149, 1, 'zV2fdfnD6X5jTDrXbKtgm2BQ4I4CN0vP', '2017-11-15 21:20:42', '2017-11-15 21:20:42'),
(154, 1, 'VbajMvJtRtkXTmUREmO1x8SnojOzoNy4', '2017-11-16 12:09:09', '2017-11-16 12:09:09'),
(155, 1, 'EN255XIbrvzjbXm2TdeuHOJnjAHBKhm0', '2017-11-16 19:00:45', '2017-11-16 19:00:45'),
(156, 1, 'a2STqoxCKAdKjJBxt5RxyBo23j196SqS', '2017-11-17 01:55:13', '2017-11-17 01:55:13'),
(157, 1, 'bWYcBrGX0pTubrxZ2Gz8mOrpfZh4d3R5', '2017-11-17 03:54:15', '2017-11-17 03:54:15'),
(158, 1, 'rOqRgZyRXdpE2wPQxm60VZEi4MVsaHwd', '2017-11-17 09:26:45', '2017-11-17 09:26:45'),
(159, 1, 'MUi9tluQQy8AhsadOL4sMuRSRaMPY2Vi', '2017-11-17 21:05:41', '2017-11-17 21:05:41'),
(162, 1, '0fsBWGHy3uFkICDp4rgusPKisYenbUr5', '2017-11-18 08:03:50', '2017-11-18 08:03:50'),
(163, 1, 'z2MidVz3A5SfcQtc9CjF83lbB9Ncxw4c', '2017-11-19 05:53:59', '2017-11-19 05:53:59'),
(164, 1, 'C3NrRRgDRZQLTrZraBO9IGEl2wXobUup', '2017-11-20 05:47:41', '2017-11-20 05:47:41'),
(165, 1, 'wgjWLdlRLP6Cireh1mZswQnOOTXG8z8O', '2017-11-21 03:33:18', '2017-11-21 03:33:18'),
(166, 1, 'OHI8P6DtqZVW9K4VlZ1mw5gI0IuJYPH1', '2017-11-21 04:17:05', '2017-11-21 04:17:05'),
(167, 1, 'qNdOfppeTTO8yQemqSZtz0s9qjIu8bSY', '2017-11-21 17:39:32', '2017-11-21 17:39:32'),
(168, 1, 'UJbhn9QwAcZUUXnVDtSStqNCq5akR4Lw', '2017-11-21 23:49:19', '2017-11-21 23:49:19'),
(169, 1, 'eo5eQNRwtkvZlv0DmXfze6JymlS0wylC', '2017-11-22 18:21:12', '2017-11-22 18:21:12'),
(173, 1, 'IulV4jEfAVovdnn5YGOTprw3kkvFe8NP', '2017-11-23 05:15:58', '2017-11-23 05:15:58'),
(174, 1, 'Awg5gkMADLkjPbiVitjCzS9ad5sCN9eF', '2017-11-23 18:51:55', '2017-11-23 18:51:55'),
(175, 1, 'STmoiFXISPPMkYZ46mHVd1FgZleRFPma', '2017-11-24 01:23:33', '2017-11-24 01:23:33'),
(176, 1, 'DS9Yw83Zm2blL1F2azbyCcQ4v2ktYX5H', '2017-11-24 02:11:20', '2017-11-24 02:11:20'),
(177, 1, 'e1ZyuWKHR7HQaQSkQEv4J6YMwpFFLXeC', '2017-11-24 06:39:38', '2017-11-24 06:39:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `alias` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `photo`
--

INSERT INTO `photo` (`id`, `fullname`, `alias`, `album_id`, `image`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'photo 1', 'photo-1', 2, 'w734cxfqmi502yt1.jpg', 1, 3, '2017-05-16 16:16:18', '2017-05-20 10:51:59'),
(2, 'photo 2', 'photo-2', 3, '9ximzjobdl0g762c.jpg', 1, 4, '2017-05-16 16:17:33', '2017-05-20 10:51:59'),
(3, 'photo 4', 'photo-4', 2, 'fpexy647nzagu13l.jpg', 1, 1, '2017-05-16 16:19:30', '2017-05-20 10:51:59'),
(4, 'photo 3', 'photo-3', 2, '963r7kl0hidmfx2b.png', 1, 2, '2017-05-16 17:17:24', '2017-05-20 11:26:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `privilege`
--

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
  `id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `controller` varchar(45) NOT NULL,
  `action` varchar(45) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `privilege`
--

INSERT INTO `privilege` (`id`, `fullname`, `controller`, `action`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'category-article-list', 'category-article', 'list', 1, '2017-05-18 06:49:30', '2017-05-19 17:26:33'),
(2, 'category-article-form', 'category-article', 'form', 1, '2017-05-18 06:50:32', '2017-05-19 17:26:44'),
(3, 'category-article-trash', 'category-article', 'trash', 1, '2017-05-18 06:51:27', '2017-05-19 17:26:54'),
(4, 'article-list', 'article', 'list', 1, '2017-05-18 08:34:41', '2017-05-19 18:11:35'),
(5, 'article-form', 'article', 'form', 2, '2017-05-18 08:35:17', '2017-05-19 17:24:54'),
(6, 'article-trash', 'article', 'trash', 3, '2017-05-18 08:35:54', '2017-05-19 18:11:35'),
(7, 'module-menu-list', 'module-menu', 'list', 3, '2017-05-19 03:42:58', '2017-05-19 17:38:02'),
(8, 'module-menu-form', 'module-menu', 'form', 3, '2017-05-19 03:44:16', '2017-05-19 17:38:14'),
(9, 'module-menu-trash', 'module-menu', 'trash', 3, '2017-05-19 03:44:35', '2017-05-19 17:38:25'),
(10, 'module-custom-list', 'module-custom', 'list', 4, '2017-05-19 03:45:27', '2017-05-19 17:34:38'),
(11, 'module-custom-form', 'module-custom', 'form', 4, '2017-05-19 03:46:10', '2017-05-19 17:34:53'),
(12, 'module-custom-trash', 'module-custom', 'trash', 4, '2017-05-19 03:46:31', '2017-05-19 17:35:04'),
(13, 'module-article-list', 'module-article', 'list', 5, '2017-05-19 03:47:14', '2017-05-19 17:31:22'),
(14, 'module-article-form', 'module-article', 'form', 5, '2017-05-19 03:50:20', '2017-05-19 17:31:43'),
(15, 'module-article-trash', 'module-article', 'trash', 5, '2017-05-19 03:51:00', '2017-05-19 17:31:57'),
(16, 'category-article-status', 'category-article', 'status', 1, '2017-05-19 08:23:46', '2017-05-19 17:27:04'),
(17, 'category-article-delete', 'category-article', 'delete', 1, '2017-05-19 08:25:14', '2017-05-19 17:27:16'),
(18, 'privilege-list', 'privilege', 'list', 6, NULL, '2017-05-19 17:38:47'),
(19, 'privilege-form', 'privilege', 'form', 6, NULL, '2017-05-19 17:38:55'),
(20, 'privilege-trash', 'privilege', 'trash', 6, '2017-05-19 11:57:04', '2017-05-19 17:39:02'),
(21, 'privilege-status', 'privilege', 'status', 6, '2017-05-19 11:57:33', '2017-05-19 17:39:14'),
(22, 'privilege-delete', 'privilege', 'delete', 6, '2017-05-19 11:57:49', '2017-05-19 17:39:25'),
(23, 'privilege-ordering', 'privilege', 'ordering', 6, '2017-05-19 11:58:10', '2017-05-19 17:39:33'),
(24, 'group-member-list', 'group-member', 'list', 7, '2017-05-19 11:59:40', '2017-05-19 17:27:44'),
(25, 'group-member-form', 'group-member', 'form', 7, '2017-05-19 12:00:09', '2017-05-19 17:27:55'),
(26, 'group-member-trash', 'group-member', 'trash', 7, '2017-05-19 12:00:56', '2017-05-19 17:28:06'),
(27, 'group-member-ordering', 'group-member', 'ordering', 7, '2017-05-19 12:01:20', '2017-05-19 17:28:17'),
(28, 'group-member-delete', 'group-member', 'delete', 7, '2017-05-19 12:01:48', '2017-05-19 17:28:28'),
(29, 'group-member-status', 'group-member', 'status', 7, '2017-05-19 12:02:27', '2017-05-19 17:28:39'),
(30, 'article-delete', 'article', 'delete', 4, '2017-05-19 17:22:05', '2017-05-19 18:11:35'),
(31, 'article-ordering', 'article', 'ordering', 6, '2017-05-19 17:22:53', '2017-05-19 18:11:35'),
(32, 'article-status', 'article', 'status', 5, '2017-05-19 17:23:34', '2017-05-19 18:11:35'),
(33, 'category-article-ordering', 'category-article', 'ordering', 1, '2017-05-19 17:29:14', '2017-05-19 17:29:14'),
(34, 'module-article-delete', 'module-article', 'delete', 5, '2017-05-19 17:33:19', '2017-05-19 17:33:19'),
(35, 'module-article-status', 'module-article', 'status', 5, '2017-05-19 17:33:42', '2017-05-19 17:33:42'),
(36, 'module-article-ordering', 'module-article', 'ordering', 5, '2017-05-19 17:33:59', '2017-05-19 17:33:59'),
(37, 'module-custom-delete', 'module-custom', 'delete', 4, '2017-05-19 17:36:07', '2017-05-19 17:36:23'),
(38, 'module-custom-status', 'module-custom', 'status', 4, '2017-05-19 17:36:49', '2017-05-19 17:36:55'),
(39, 'module-custom-ordering', 'module-custom', 'ordering', 4, '2017-05-19 17:37:27', '2017-05-19 17:37:27'),
(40, 'module-menu-delete', 'module-menu', 'delete', 3, '2017-05-19 17:40:29', '2017-05-19 17:40:36'),
(41, 'module-menu-status', 'module-menu', 'status', 3, '2017-05-19 17:40:55', '2017-05-19 17:40:55'),
(42, 'module-menu-ordering', 'module-menu', 'ordering', 3, '2017-05-19 17:41:14', '2017-05-19 17:41:14'),
(43, 'user-list', 'user', 'list', 8, '2017-05-19 17:45:27', '2017-05-19 17:45:27'),
(44, 'user-form', 'user', 'form', 8, '2017-05-19 17:45:57', '2017-05-19 17:45:57'),
(45, 'user-trash', 'user', 'trash', 8, '2017-05-19 17:46:22', '2017-05-19 17:46:22'),
(46, 'user-status', 'user', 'status', 8, '2017-05-19 17:46:51', '2017-05-19 17:46:51'),
(47, 'user-delete', 'user', 'delete', 8, '2017-05-19 17:47:13', '2017-05-19 17:47:13'),
(48, 'user-ordering', 'user', 'ordering', 8, '2017-05-19 17:47:32', '2017-05-19 17:47:32'),
(49, 'menu-type-list', 'menu-type', 'list', 9, '2017-05-19 17:49:35', '2017-05-19 17:49:35'),
(50, 'menu-type-form', 'menu-type', 'form', 9, '2017-05-19 17:49:53', '2017-05-19 17:49:53'),
(51, 'menu-type-trash', 'menu-type', 'trash', 9, '2017-05-19 17:50:07', '2017-05-19 17:50:07'),
(52, 'menu-type-delete', 'menu-type', 'delete', 9, '2017-05-19 17:50:29', '2017-05-19 17:50:29'),
(53, 'menu-type-status', 'menu-type', 'status', 9, '2017-05-19 17:50:43', '2017-05-19 17:50:43'),
(54, 'menu-type-ordering', 'menu-type', 'ordering', 9, '2017-05-19 17:50:55', '2017-05-19 17:50:55'),
(55, 'menu-list', 'menu', 'list', 10, '2017-05-19 18:01:20', '2017-05-19 18:01:20'),
(56, 'menu-form', 'menu', 'form', 10, '2017-05-19 18:01:38', '2017-05-19 18:01:38'),
(57, 'menu-trash', 'menu', 'trash', 10, '2017-05-19 18:01:52', '2017-05-19 18:01:52'),
(58, 'menu-delete', 'menu', 'delete', 10, '2017-05-19 18:02:17', '2017-05-19 18:02:17'),
(59, 'menu-status', 'menu', 'status', 10, '2017-05-19 18:02:31', '2017-05-19 18:02:31'),
(60, 'menu-ordering', 'menu', 'ordering', 10, '2017-05-19 18:02:50', '2017-05-19 18:02:50'),
(61, 'media-list', 'media', 'list', 11, '2017-05-19 18:05:47', '2017-05-19 18:05:47'),
(62, 'media-form', 'media', 'form', 11, '2017-05-19 18:06:05', '2017-05-19 18:06:05'),
(63, 'media-trash', 'media', 'trash', 11, '2017-05-19 18:06:22', '2017-05-19 18:06:22'),
(64, 'media-delete', 'media', 'delete', 11, '2017-05-19 18:06:49', '2017-05-19 18:06:49'),
(65, 'media-status', 'media', 'status', 11, '2017-05-19 18:07:37', '2017-05-19 18:07:37'),
(66, 'media-ordering', 'media', 'ordering', 11, '2017-05-19 18:07:51', '2017-05-19 18:07:51'),
(67, 'product-list', 'product', 'list', 12, '2017-05-19 18:09:08', '2017-05-19 18:09:08'),
(68, 'product-form', 'product', 'form', 12, '2017-05-19 18:09:20', '2017-05-19 18:09:20'),
(69, 'product-trash', 'product', 'trash', 12, '2017-05-19 18:09:30', '2017-05-19 18:09:30'),
(70, 'product-delete', 'product', 'delete', 12, '2017-05-19 18:09:42', '2017-05-19 18:09:42'),
(71, 'product-ordering', 'product', 'ordering', 12, '2017-05-19 18:09:56', '2017-05-19 18:09:56'),
(72, 'product-status', 'product', 'status', 12, '2017-05-19 18:10:26', '2017-05-19 18:10:26'),
(73, 'category-list', 'category', 'list', 13, '2017-05-19 18:12:13', '2017-05-19 18:12:13'),
(74, 'category-form', 'category', 'form', 13, '2017-05-19 18:12:25', '2017-05-19 18:12:25'),
(75, 'category-trash', 'category', 'trash', 13, '2017-05-19 18:12:40', '2017-05-19 18:12:40'),
(76, 'category-delete', 'category', 'delete', 13, '2017-05-19 18:12:59', '2017-05-19 18:12:59'),
(77, 'category-status', 'category', 'status', 13, '2017-05-19 18:13:12', '2017-05-19 18:13:12'),
(78, 'category-ordering', 'category', 'ordering', 13, '2017-05-19 18:13:25', '2017-05-19 18:13:25'),
(79, 'invoice-list', 'invoice', 'list', 14, '2017-05-19 18:14:02', '2017-05-19 18:14:02'),
(80, 'invoice-form', 'invoice', 'form', 14, '2017-05-19 18:14:30', '2017-05-19 18:14:30'),
(81, 'invoice-trash', 'invoice', 'trash', 14, '2017-05-19 18:14:44', '2017-05-19 18:14:44'),
(82, 'invoice-delete', 'invoice', 'delete', 14, '2017-05-19 18:14:58', '2017-05-19 18:14:58'),
(83, 'invoice-status', 'invoice', 'status', 14, '2017-05-19 18:15:11', '2017-05-19 18:15:11'),
(84, 'invoice-ordering', 'invoice', 'ordering', 14, '2017-05-19 18:15:39', '2017-05-19 18:15:39'),
(85, 'customer-list', 'customer', 'list', 15, '2017-05-19 18:16:10', '2017-05-19 18:16:10'),
(86, 'customer-form', 'customer', 'form', 15, '2017-05-19 18:16:33', '2017-05-19 18:16:33'),
(87, 'customer-trash', 'customer', 'trash', 15, '2017-05-19 18:16:47', '2017-05-19 18:16:47'),
(88, 'customer-delete', 'customer', 'delete', 15, '2017-05-19 18:17:02', '2017-05-19 18:17:02'),
(89, 'customer-status', 'customer', 'status', 15, '2017-05-19 18:17:38', '2017-05-19 18:17:38'),
(90, 'customer-ordering', 'customer', 'ordering', 15, '2017-05-19 18:17:51', '2017-05-19 18:17:51'),
(91, 'album-list', 'album', 'list', 16, '2017-05-19 18:19:21', '2017-05-19 18:19:21'),
(92, 'album-form', 'album', 'form', 16, '2017-05-19 18:19:54', '2017-10-08 16:46:24'),
(93, 'album-trash', 'album', 'trash', 16, '2017-05-19 18:20:10', '2017-05-19 18:20:10'),
(94, 'album-delete', 'album', 'delete', 16, '2017-05-19 18:20:34', '2017-05-19 18:20:34'),
(95, 'album-status', 'album', 'status', 16, '2017-05-19 18:21:08', '2017-05-19 18:21:08'),
(96, 'album-ordering', 'album', 'ordering', 16, '2017-05-19 18:21:27', '2017-05-19 18:21:27'),
(97, 'photo-list', 'photo', 'list', 17, '2017-05-19 18:22:22', '2017-05-19 18:22:22'),
(98, 'photo-form', 'photo', 'form', 17, '2017-05-19 18:22:43', '2017-05-19 18:22:43'),
(99, 'photo-trash', 'photo', 'trash', 17, '2017-05-19 18:22:59', '2017-05-19 18:22:59'),
(100, 'photo-delete', 'photo', 'delete', 17, '2017-05-19 18:23:22', '2017-05-19 18:23:22'),
(101, 'photo-status', 'photo', 'status', 17, '2017-05-19 18:23:48', '2017-05-19 18:23:48'),
(102, 'photo-ordering', 'photo', 'ordering', 17, '2017-05-19 18:24:06', '2017-05-19 18:24:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `meta_keyword` text COLLATE utf8_unicode_ci,
  `meta_description` text COLLATE utf8_unicode_ci,
  `alias` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `child_image` text CHARACTER SET utf8,
  `price` decimal(11,2) DEFAULT NULL,
  `sale_price` decimal(11,2) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `detail` text CHARACTER SET utf8,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `code`, `fullname`, `title`, `meta_keyword`, `meta_description`, `alias`, `image`, `status`, `child_image`, `price`, `sale_price`, `intro`, `detail`, `sort_order`, `created_at`, `updated_at`) VALUES
(7, '123456789', 'Sofa 1', NULL, NULL, NULL, 'sofa-1', 'sofa-1.png', 1, '[\"sofa-2.png\",\"sofa-3.png\",\"sofa-4.png\",\"sofa-5.png\",\"sofa-6.png\"]', '5000000.00', '4000000.00', 'Trung vệ của Chelsea gây khó hiểu khi khựng người lại, để El Shaarawy thoát xuống và ghi bàn ở Champions League tối 31/10.', '<p style=\"text-align:justify\">&ldquo;B&agrave;n thua thứ hai thật thiếu may mắn với ch&uacute;ng t&ocirc;i&rdquo;, Thibaut Courtois giải th&iacute;ch sau thất bại 0-3 ở lượt trận thứ tư. &ldquo;Đ&oacute; l&agrave; t&igrave;nh huống b&oacute;ng d&agrave;i. T&ocirc;i thấy El Shaarawy ở đằng sau Antonio Rudiger n&ecirc;n h&eacute;t l&ecirc;n: &lsquo;Away&rsquo;. C&oacute; thể anh ấy đ&atilde; hiểu theo nghĩa kh&aacute;c. Kh&ocirc;ng kh&iacute; tr&ecirc;n s&acirc;n l&uacute;c đ&oacute; rất ồn. Anh ấy để b&oacute;ng nảy qua trước mặt. El Shaarawy th&igrave; nhanh nhẹn đ&oacute;n b&oacute;ng v&agrave; ghi b&agrave;n&rdquo;.<br />\nTheo ng&ocirc;n ngữ thủ m&ocirc;n, &ldquo;away&rdquo; được d&ugrave;ng để cảnh b&aacute;o hậu vệ rằng thủ m&ocirc;n kh&ocirc;ng lao ra đ&oacute;n b&oacute;ng v&agrave; hậu vệ phải t&igrave;m c&aacute;ch ph&aacute;. T&acirc;n binh của Chelsea c&oacute; vẻ như đ&atilde; kh&ocirc;ng ch&uacute; &yacute; tới El Shaarawy từ đường chuyền d&agrave;i của Radja Nainggolan, v&agrave; nghĩ đồng đội bảo &quot;Tr&aacute;nh ra&quot;. Anh v&igrave; vậy khựng người lại, t&iacute;nh thả b&oacute;ng tr&ocirc;i qua cho Courtois. Nhưng từ ph&iacute;a sau, El Shaarawy đ&atilde; chớp thời cơ, ch&iacute;ch b&oacute;ng v&agrave;o lưới đ&aacute;nh dấu c&uacute; đ&uacute;p của anh trận n&agrave;y.</p>\n\n<p style=\"text-align:justify\">Trước đ&oacute;, ngay ph&uacute;t đầu ti&ecirc;n, El Shaarawy đ&atilde; chọc thủng lưới Chelsea. Sang hiệp hai đội kh&aacute;ch c&oacute; nhiều điều chỉnh về nh&acirc;n sự nhưng cũng kh&ocirc;ng thể cải thiện được t&igrave;nh h&igrave;nh. Ph&uacute;t 63 họ nhận b&agrave;n thua thứ ba, từ Diego Perotti. &ldquo;T&ocirc;i kh&ocirc;ng biết v&igrave; sao ch&uacute;ng t&ocirc;i đ&aacute;nh mất tinh thần chiến đấu trong hiệp hai&rdquo;, Courtois n&oacute;i. &ldquo;Điều đ&oacute; kh&ocirc;ng thể xảy ra khi ch&uacute;ng t&ocirc;i c&oacute; trận quan trọng v&agrave;o Chủ nhật tới. Ch&uacute;ng t&ocirc;i phải chứng minh cho người h&acirc;m mộ rằng đ&acirc;y chỉ l&agrave; tai nạn&rdquo;.</p>\n\n<p style=\"text-align:justify\">Thua trận nhưng Chelsea vẫn c&oacute; quyền tự quyết tại Champions League. Họ chỉ cần đoạt th&ecirc;m ba điểm để gi&agrave;nh v&eacute; v&agrave;o v&ograve;ng 1/8, trong đ&oacute; c&oacute; trận đấu được xem l&agrave; dễ thở gặp Qarabag, đại diện của Azerbaijan. V&agrave;o cuối tuần, nh&agrave; đương v&ocirc; địch Ngoại hạng Anh đ&oacute;n tiếp Man Utd trong trận cầu được v&iacute; như &quot;Super Sunday&quot;.</p>\n\n<p style=\"text-align:justify\">&ldquo;Ch&uacute;ng t&ocirc;i phải chơi hăng m&aacute;u hơn khi gặp Man Utd. M&ugrave;a trước, c&oacute; trận t&ocirc;i kh&ocirc;ng phải hoạt động, nhưng cũng c&oacute; trận l&agrave;m việc vất vả. H&ocirc;m nay Chelsea để lại h&igrave;nh ảnh tồi tệ, v&agrave; ch&uacute;ng t&ocirc;i phải nhanh ch&oacute;ng gượng dậy&rdquo;, thủ m&ocirc;n 25 tuổi nhấn mạnh.</p>', 1, '2017-11-13 18:51:54', '2017-11-16 07:45:10'),
(8, '123456781', 'Sofa 2', NULL, NULL, NULL, 'sofa-2', 'sofa-2.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật...', '<p>đang cập nhật...</p>', 2, '2017-11-14 07:41:35', '2017-11-22 08:10:39'),
(9, '123456782', 'Sofa 3', NULL, NULL, NULL, 'sofa-3', 'sofa-3.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật...', '<p>đang cập nhật...</p>', 3, '2017-11-14 07:42:26', '2017-11-14 07:42:26'),
(10, '1234567894', 'Sofa 4', NULL, NULL, NULL, 'sofa-4', 'sofa-4.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật', '<p>đang cập nhật...</p>', 4, '2017-11-14 07:43:14', '2017-11-22 08:10:39'),
(11, '123456785', 'Sofa 5', NULL, NULL, NULL, 'sofa-5', 'sofa-5.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật', '<p>đang cập nhật</p>', 5, '2017-11-14 07:46:55', '2017-11-14 07:46:55'),
(12, '123456786', 'Sofa 6', NULL, NULL, NULL, 'sofa-6', 'sofa-6.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật...', '<p>đang cập nhật...</p>', 6, '2017-11-14 07:47:40', '2017-11-21 14:23:52'),
(13, '123456787', 'Sofa 7', NULL, NULL, NULL, 'sofa-7', 'sofa-7.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật', '<p>đang cập nhật</p>', 7, '2017-11-14 07:48:50', '2017-11-14 07:48:50'),
(14, '123456788', 'Sofa 8', NULL, NULL, NULL, 'sofa-8', 'sofa-8.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật', '<p>đang cập nhật</p>', 8, '2017-11-14 07:49:33', '2017-11-14 07:49:33'),
(15, '123456783', 'Sofa 9', NULL, NULL, NULL, 'sofa-9', 'sofa-9.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật', '<p>đang cập nhật</p>', 9, '2017-11-14 07:50:30', '2017-11-14 07:50:30'),
(16, '223456784', 'Sofa 10', NULL, NULL, NULL, 'sofa-10', 'sofa-10.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật', '<p>đang cập nhật</p>', 10, '2017-11-14 07:51:26', '2017-11-14 07:51:26'),
(17, '123456799', 'Sofa 11', NULL, NULL, NULL, 'sofa-11', 'sofa-11.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật', '<p>đang cập nhật</p>', 11, '2017-11-14 07:52:14', '2017-11-22 07:19:05'),
(18, '123321456', 'Sofa 12', NULL, NULL, NULL, 'sofa-12', 'sofa-12.png', 1, NULL, '5000000.00', '4000000.00', 'đang cập nhật', '<p>đang cập nhật</p>', 12, '2017-11-14 07:52:58', '2017-11-22 07:18:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` bigint(20) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_product_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_category`
--

INSERT INTO `product_category` (`id`, `product_id`, `category_product_id`, `created_at`, `updated_at`) VALUES
(22, 7, 32, '2017-11-13 18:54:33', '2017-11-13 18:54:33'),
(23, 8, 32, '2017-11-14 07:41:36', '2017-11-14 07:41:36'),
(24, 9, 32, '2017-11-14 07:42:26', '2017-11-14 07:42:26'),
(25, 10, 32, '2017-11-14 07:43:14', '2017-11-14 07:43:14'),
(26, 11, 32, '2017-11-14 07:46:55', '2017-11-14 07:46:55'),
(27, 12, 32, '2017-11-14 07:47:41', '2017-11-14 07:47:41'),
(28, 13, 32, '2017-11-14 07:48:50', '2017-11-14 07:48:50'),
(29, 14, 32, '2017-11-14 07:49:33', '2017-11-14 07:49:33'),
(30, 15, 32, '2017-11-14 07:50:30', '2017-11-14 07:50:30'),
(31, 16, 32, '2017-11-14 07:51:26', '2017-11-14 07:51:26'),
(32, 17, 32, '2017-11-14 07:52:14', '2017-11-14 07:52:14'),
(33, 18, 32, '2017-11-14 07:52:58', '2017-11-14 07:52:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reminders`
--

DROP TABLE IF EXISTS `reminders`;
CREATE TABLE `reminders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_users`
--

DROP TABLE IF EXISTS `role_users`;
CREATE TABLE `role_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `setting_system`
--

DROP TABLE IF EXISTS `setting_system`;
CREATE TABLE `setting_system` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `article_perpage` int(11) DEFAULT NULL,
  `article_width` int(11) DEFAULT NULL,
  `article_height` int(11) DEFAULT NULL,
  `product_perpage` int(11) DEFAULT NULL,
  `product_width` int(11) DEFAULT NULL,
  `product_height` int(11) DEFAULT NULL,
  `currency_unit` varchar(255) DEFAULT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(255) DEFAULT NULL,
  `encription` varchar(255) DEFAULT NULL,
  `authentication` int(11) NOT NULL,
  `smtp_username` varchar(255) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  `email_from` varchar(255) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `to_name` varchar(255) DEFAULT NULL,
  `contacted_phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `opened_time` varchar(255) DEFAULT NULL,
  `opened_date` varchar(255) DEFAULT NULL,
  `contacted_name` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `google_plus` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `pinterest_url` varchar(255) DEFAULT NULL,
  `slogan_about` text,
  `map_url` text,
  `com_category_article` varchar(255) DEFAULT NULL,
  `com_category_product` varchar(255) DEFAULT NULL,
  `com_article` varchar(255) DEFAULT NULL,
  `com_product` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `setting_system`
--

INSERT INTO `setting_system` (`id`, `fullname`, `alias`, `article_perpage`, `article_width`, `article_height`, `product_perpage`, `product_width`, `product_height`, `currency_unit`, `smtp_host`, `smtp_port`, `encription`, `authentication`, `smtp_username`, `smtp_password`, `email_from`, `email_to`, `from_name`, `to_name`, `contacted_phone`, `address`, `website`, `telephone`, `opened_time`, `opened_date`, `contacted_name`, `facebook_url`, `twitter_url`, `google_plus`, `youtube_url`, `instagram_url`, `pinterest_url`, `slogan_about`, `map_url`, `com_category_article`, `com_category_product`, `com_article`, `com_product`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'settingsystem', 'setting-system', 12, 360, 230, 16, 400, 400, 'vi_VN', 'smtp.gmail.com', '465', 'ssl', 1, 'dien.toannang@gmail.com', 'lienhoancuoc', 'dienit02@gmail.com', 'tichtacso.com@gmail.com', 'Hệ thống', 'Công Ty TNHH VIDOCO', '096.302.7721', '35/6 Bùi Quang Là - P.12 - Q. Gò Vấp - HCM', 'noithatgialai.net', '096.302.7720', '8h - 20h', '(T2-T7). Chủ Nhật nghỉ', 'Mr. Vinh', 'https://www.facebook.com/nguyenvan.laptrinh', 'https://twitter.com/', 'https://plus.google.com/u/0/?hl=vi', 'https://www.youtube.com/watch?v=kAcV7S3sySU', 'http://flickr.com', 'http://daidung.vn/', 'Mipec cung cấp thực phẩm sạch, an toàn, đảm bảo chất lượng hàng đầu. Xóa đi nỗi lo về an toàn thực phẩm', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3871.605543764119!2d108.07355431421081!3d13.982069195684272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDU4JzU1LjQiTiAxMDjCsDA0JzMyLjciRQ!5e0!3m2!1svi!2s!4v1508913801584', 'chu-de', 'loai-san-pham', 'bai-viet', 'san-pham', 1, 1, '2017-11-10 19:46:32', '2017-11-24 14:40:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `throttle`
--

DROP TABLE IF EXISTS `throttle`;
CREATE TABLE `throttle` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`) VALUES
(1, NULL, 'global', NULL, '2017-11-12 07:00:10', '2017-11-12 07:00:10'),
(2, NULL, 'ip', '127.0.0.1', '2017-11-12 07:00:10', '2017-11-12 07:00:10'),
(3, NULL, 'global', NULL, '2017-11-12 07:00:22', '2017-11-12 07:00:22'),
(4, NULL, 'ip', '127.0.0.1', '2017-11-12 07:00:22', '2017-11-12 07:00:22'),
(5, NULL, 'global', NULL, '2017-11-12 07:00:36', '2017-11-12 07:00:36'),
(6, NULL, 'ip', '127.0.0.1', '2017-11-12 07:00:36', '2017-11-12 07:00:36'),
(7, NULL, 'global', NULL, '2017-11-12 07:05:02', '2017-11-12 07:05:02'),
(8, NULL, 'ip', '127.0.0.1', '2017-11-12 07:05:02', '2017-11-12 07:05:02'),
(9, NULL, 'global', NULL, '2017-11-12 07:30:11', '2017-11-12 07:30:11'),
(10, NULL, 'ip', '127.0.0.1', '2017-11-12 07:30:11', '2017-11-12 07:30:11'),
(11, NULL, 'global', NULL, '2017-11-12 07:32:49', '2017-11-12 07:32:49'),
(12, NULL, 'ip', '127.0.0.1', '2017-11-12 07:32:49', '2017-11-12 07:32:49'),
(13, NULL, 'global', NULL, '2017-11-12 07:39:23', '2017-11-12 07:39:23'),
(14, NULL, 'ip', '127.0.0.1', '2017-11-12 07:39:23', '2017-11-12 07:39:23'),
(15, NULL, 'global', NULL, '2017-11-12 07:55:42', '2017-11-12 07:55:42'),
(16, NULL, 'ip', '127.0.0.1', '2017-11-12 07:55:42', '2017-11-12 07:55:42'),
(17, NULL, 'global', NULL, '2017-11-12 07:59:33', '2017-11-12 07:59:33'),
(18, NULL, 'ip', '127.0.0.1', '2017-11-12 07:59:33', '2017-11-12 07:59:33'),
(19, NULL, 'global', NULL, '2017-11-12 08:01:13', '2017-11-12 08:01:13'),
(20, NULL, 'ip', '127.0.0.1', '2017-11-12 08:01:13', '2017-11-12 08:01:13'),
(21, NULL, 'global', NULL, '2017-11-12 08:01:34', '2017-11-12 08:01:34'),
(22, NULL, 'ip', '127.0.0.1', '2017-11-12 08:01:34', '2017-11-12 08:01:34'),
(23, NULL, 'global', NULL, '2017-11-12 08:01:41', '2017-11-12 08:01:41'),
(24, NULL, 'ip', '127.0.0.1', '2017-11-12 08:01:41', '2017-11-12 08:01:41'),
(25, NULL, 'global', NULL, '2017-11-12 08:02:05', '2017-11-12 08:02:05'),
(26, NULL, 'ip', '127.0.0.1', '2017-11-12 08:02:05', '2017-11-12 08:02:05'),
(27, NULL, 'global', NULL, '2017-11-12 08:12:23', '2017-11-12 08:12:23'),
(28, NULL, 'ip', '127.0.0.1', '2017-11-12 08:12:23', '2017-11-12 08:12:23'),
(29, NULL, 'global', NULL, '2017-11-12 08:18:51', '2017-11-12 08:18:51'),
(30, NULL, 'ip', '127.0.0.1', '2017-11-12 08:18:51', '2017-11-12 08:18:51'),
(31, NULL, 'global', NULL, '2017-11-12 08:19:22', '2017-11-12 08:19:22'),
(32, NULL, 'ip', '127.0.0.1', '2017-11-12 08:19:22', '2017-11-12 08:19:22'),
(33, NULL, 'global', NULL, '2017-11-12 08:34:38', '2017-11-12 08:34:38'),
(34, NULL, 'ip', '127.0.0.1', '2017-11-12 08:34:38', '2017-11-12 08:34:38'),
(35, NULL, 'global', NULL, '2017-11-12 10:21:38', '2017-11-12 10:21:38'),
(36, NULL, 'ip', '127.0.0.1', '2017-11-12 10:21:38', '2017-11-12 10:21:38'),
(37, NULL, 'global', NULL, '2017-11-12 10:38:16', '2017-11-12 10:38:16'),
(38, NULL, 'ip', '127.0.0.1', '2017-11-12 10:38:16', '2017-11-12 10:38:16'),
(39, 1, 'user', NULL, '2017-11-12 10:38:16', '2017-11-12 10:38:16'),
(40, NULL, 'global', NULL, '2017-11-12 10:39:37', '2017-11-12 10:39:37'),
(41, NULL, 'ip', '127.0.0.1', '2017-11-12 10:39:37', '2017-11-12 10:39:37'),
(42, 1, 'user', NULL, '2017-11-12 10:39:37', '2017-11-12 10:39:37'),
(43, NULL, 'global', NULL, '2017-11-12 10:58:13', '2017-11-12 10:58:13'),
(44, NULL, 'ip', '127.0.0.1', '2017-11-12 10:58:13', '2017-11-12 10:58:13'),
(45, NULL, 'global', NULL, '2017-11-12 10:59:19', '2017-11-12 10:59:19'),
(46, NULL, 'ip', '127.0.0.1', '2017-11-12 10:59:19', '2017-11-12 10:59:19'),
(47, 4, 'user', NULL, '2017-11-12 10:59:19', '2017-11-12 10:59:19'),
(48, NULL, 'global', NULL, '2017-11-12 11:00:10', '2017-11-12 11:00:10'),
(49, NULL, 'ip', '127.0.0.1', '2017-11-12 11:00:10', '2017-11-12 11:00:10'),
(50, 4, 'user', NULL, '2017-11-12 11:00:10', '2017-11-12 11:00:10'),
(51, NULL, 'global', NULL, '2017-11-12 11:04:27', '2017-11-12 11:04:27'),
(52, NULL, 'ip', '127.0.0.1', '2017-11-12 11:04:27', '2017-11-12 11:04:27'),
(53, 4, 'user', NULL, '2017-11-12 11:04:27', '2017-11-12 11:04:27'),
(54, NULL, 'global', NULL, '2017-11-12 11:05:04', '2017-11-12 11:05:04'),
(55, NULL, 'ip', '127.0.0.1', '2017-11-12 11:05:04', '2017-11-12 11:05:04'),
(56, 1, 'user', NULL, '2017-11-12 11:05:04', '2017-11-12 11:05:04'),
(57, NULL, 'global', NULL, '2017-11-12 11:08:43', '2017-11-12 11:08:43'),
(58, NULL, 'ip', '127.0.0.1', '2017-11-12 11:08:43', '2017-11-12 11:08:43'),
(59, 1, 'user', NULL, '2017-11-12 11:08:43', '2017-11-12 11:08:43'),
(60, NULL, 'global', NULL, '2017-11-12 11:14:37', '2017-11-12 11:14:37'),
(61, NULL, 'ip', '127.0.0.1', '2017-11-12 11:14:37', '2017-11-12 11:14:37'),
(62, 1, 'user', NULL, '2017-11-12 11:14:37', '2017-11-12 11:14:37'),
(63, NULL, 'global', NULL, '2017-11-12 11:18:13', '2017-11-12 11:18:13'),
(64, NULL, 'ip', '127.0.0.1', '2017-11-12 11:18:13', '2017-11-12 11:18:13'),
(65, 4, 'user', NULL, '2017-11-12 11:18:13', '2017-11-12 11:18:13'),
(66, NULL, 'global', NULL, '2017-11-12 11:19:22', '2017-11-12 11:19:22'),
(67, NULL, 'ip', '127.0.0.1', '2017-11-12 11:19:22', '2017-11-12 11:19:22'),
(68, 4, 'user', NULL, '2017-11-12 11:19:22', '2017-11-12 11:19:22'),
(69, NULL, 'global', NULL, '2017-11-12 12:21:15', '2017-11-12 12:21:15'),
(70, NULL, 'ip', '127.0.0.1', '2017-11-12 12:21:15', '2017-11-12 12:21:15'),
(71, 1, 'user', NULL, '2017-11-12 12:21:15', '2017-11-12 12:21:15'),
(72, NULL, 'global', NULL, '2017-11-12 12:30:54', '2017-11-12 12:30:54'),
(73, NULL, 'ip', '127.0.0.1', '2017-11-12 12:30:54', '2017-11-12 12:30:54'),
(74, 1, 'user', NULL, '2017-11-12 12:30:54', '2017-11-12 12:30:54'),
(75, NULL, 'global', NULL, '2017-11-12 12:31:09', '2017-11-12 12:31:09'),
(76, NULL, 'ip', '127.0.0.1', '2017-11-12 12:31:09', '2017-11-12 12:31:09'),
(77, 1, 'user', NULL, '2017-11-12 12:31:09', '2017-11-12 12:31:09'),
(78, NULL, 'global', NULL, '2017-11-12 19:20:51', '2017-11-12 19:20:51'),
(79, NULL, 'ip', '127.0.0.1', '2017-11-12 19:20:51', '2017-11-12 19:20:51'),
(80, NULL, 'global', NULL, '2017-11-12 19:20:51', '2017-11-12 19:20:51'),
(81, NULL, 'ip', '127.0.0.1', '2017-11-12 19:20:51', '2017-11-12 19:20:51'),
(82, NULL, 'global', NULL, '2017-11-12 19:20:52', '2017-11-12 19:20:52'),
(83, NULL, 'ip', '127.0.0.1', '2017-11-12 19:20:52', '2017-11-12 19:20:52'),
(84, NULL, 'global', NULL, '2017-11-12 19:20:52', '2017-11-12 19:20:52'),
(85, NULL, 'ip', '127.0.0.1', '2017-11-12 19:20:52', '2017-11-12 19:20:52'),
(86, NULL, 'global', NULL, '2017-11-12 19:20:52', '2017-11-12 19:20:52'),
(87, NULL, 'ip', '127.0.0.1', '2017-11-12 19:20:52', '2017-11-12 19:20:52'),
(88, NULL, 'global', NULL, '2017-11-12 19:20:52', '2017-11-12 19:20:52'),
(89, NULL, 'ip', '127.0.0.1', '2017-11-12 19:20:52', '2017-11-12 19:20:52'),
(90, NULL, 'global', NULL, '2017-11-12 19:24:30', '2017-11-12 19:24:30'),
(91, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:30', '2017-11-12 19:24:30'),
(92, NULL, 'global', NULL, '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(93, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(94, NULL, 'global', NULL, '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(95, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(96, NULL, 'global', NULL, '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(97, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(98, NULL, 'global', NULL, '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(99, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(100, NULL, 'global', NULL, '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(101, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:31', '2017-11-12 19:24:31'),
(102, NULL, 'global', NULL, '2017-11-12 19:24:32', '2017-11-12 19:24:32'),
(103, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:32', '2017-11-12 19:24:32'),
(104, NULL, 'global', NULL, '2017-11-12 19:24:32', '2017-11-12 19:24:32'),
(105, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:32', '2017-11-12 19:24:32'),
(106, NULL, 'global', NULL, '2017-11-12 19:24:32', '2017-11-12 19:24:32'),
(107, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:32', '2017-11-12 19:24:32'),
(108, NULL, 'global', NULL, '2017-11-12 19:24:33', '2017-11-12 19:24:33'),
(109, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:33', '2017-11-12 19:24:33'),
(110, NULL, 'global', NULL, '2017-11-12 19:24:33', '2017-11-12 19:24:33'),
(111, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:33', '2017-11-12 19:24:33'),
(112, NULL, 'global', NULL, '2017-11-12 19:24:33', '2017-11-12 19:24:33'),
(113, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:33', '2017-11-12 19:24:33'),
(114, NULL, 'global', NULL, '2017-11-12 19:24:33', '2017-11-12 19:24:33'),
(115, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:33', '2017-11-12 19:24:33'),
(116, NULL, 'global', NULL, '2017-11-12 19:24:34', '2017-11-12 19:24:34'),
(117, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:34', '2017-11-12 19:24:34'),
(118, NULL, 'global', NULL, '2017-11-12 19:24:34', '2017-11-12 19:24:34'),
(119, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:34', '2017-11-12 19:24:34'),
(120, NULL, 'global', NULL, '2017-11-12 19:24:34', '2017-11-12 19:24:34'),
(121, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:34', '2017-11-12 19:24:34'),
(122, NULL, 'global', NULL, '2017-11-12 19:24:35', '2017-11-12 19:24:35'),
(123, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:35', '2017-11-12 19:24:35'),
(124, NULL, 'global', NULL, '2017-11-12 19:24:35', '2017-11-12 19:24:35'),
(125, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:35', '2017-11-12 19:24:35'),
(126, NULL, 'global', NULL, '2017-11-12 19:24:35', '2017-11-12 19:24:35'),
(127, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:35', '2017-11-12 19:24:35'),
(128, NULL, 'global', NULL, '2017-11-12 19:24:35', '2017-11-12 19:24:35'),
(129, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:35', '2017-11-12 19:24:35'),
(130, NULL, 'global', NULL, '2017-11-12 19:24:39', '2017-11-12 19:24:39'),
(131, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:39', '2017-11-12 19:24:39'),
(132, NULL, 'global', NULL, '2017-11-12 19:24:40', '2017-11-12 19:24:40'),
(133, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:40', '2017-11-12 19:24:40'),
(134, NULL, 'global', NULL, '2017-11-12 19:24:40', '2017-11-12 19:24:40'),
(135, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:40', '2017-11-12 19:24:40'),
(136, NULL, 'global', NULL, '2017-11-12 19:24:40', '2017-11-12 19:24:40'),
(137, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:40', '2017-11-12 19:24:40'),
(138, NULL, 'global', NULL, '2017-11-12 19:24:40', '2017-11-12 19:24:40'),
(139, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:40', '2017-11-12 19:24:40'),
(140, NULL, 'global', NULL, '2017-11-12 19:24:41', '2017-11-12 19:24:41'),
(141, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:41', '2017-11-12 19:24:41'),
(142, NULL, 'global', NULL, '2017-11-12 19:24:41', '2017-11-12 19:24:41'),
(143, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:41', '2017-11-12 19:24:41'),
(144, NULL, 'global', NULL, '2017-11-12 19:24:41', '2017-11-12 19:24:41'),
(145, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:41', '2017-11-12 19:24:41'),
(146, NULL, 'global', NULL, '2017-11-12 19:24:41', '2017-11-12 19:24:41'),
(147, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:41', '2017-11-12 19:24:41'),
(148, NULL, 'global', NULL, '2017-11-12 19:24:42', '2017-11-12 19:24:42'),
(149, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:42', '2017-11-12 19:24:42'),
(150, NULL, 'global', NULL, '2017-11-12 19:24:42', '2017-11-12 19:24:42'),
(151, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:42', '2017-11-12 19:24:42'),
(152, NULL, 'global', NULL, '2017-11-12 19:24:42', '2017-11-12 19:24:42'),
(153, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:42', '2017-11-12 19:24:42'),
(154, NULL, 'global', NULL, '2017-11-12 19:24:42', '2017-11-12 19:24:42'),
(155, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:42', '2017-11-12 19:24:42'),
(156, NULL, 'global', NULL, '2017-11-12 19:24:43', '2017-11-12 19:24:43'),
(157, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:43', '2017-11-12 19:24:43'),
(158, NULL, 'global', NULL, '2017-11-12 19:24:43', '2017-11-12 19:24:43'),
(159, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:43', '2017-11-12 19:24:43'),
(160, NULL, 'global', NULL, '2017-11-12 19:24:43', '2017-11-12 19:24:43'),
(161, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:43', '2017-11-12 19:24:43'),
(162, NULL, 'global', NULL, '2017-11-12 19:24:44', '2017-11-12 19:24:44'),
(163, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:44', '2017-11-12 19:24:44'),
(164, NULL, 'global', NULL, '2017-11-12 19:24:44', '2017-11-12 19:24:44'),
(165, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:44', '2017-11-12 19:24:44'),
(166, NULL, 'global', NULL, '2017-11-12 19:24:44', '2017-11-12 19:24:44'),
(167, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:44', '2017-11-12 19:24:44'),
(168, NULL, 'global', NULL, '2017-11-12 19:24:44', '2017-11-12 19:24:44'),
(169, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:45', '2017-11-12 19:24:45'),
(170, NULL, 'global', NULL, '2017-11-12 19:24:45', '2017-11-12 19:24:45'),
(171, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:45', '2017-11-12 19:24:45'),
(172, NULL, 'global', NULL, '2017-11-12 19:24:45', '2017-11-12 19:24:45'),
(173, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:45', '2017-11-12 19:24:45'),
(174, NULL, 'global', NULL, '2017-11-12 19:24:45', '2017-11-12 19:24:45'),
(175, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:45', '2017-11-12 19:24:45'),
(176, NULL, 'global', NULL, '2017-11-12 19:24:45', '2017-11-12 19:24:45'),
(177, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:45', '2017-11-12 19:24:45'),
(178, NULL, 'global', NULL, '2017-11-12 19:24:46', '2017-11-12 19:24:46'),
(179, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:46', '2017-11-12 19:24:46'),
(180, NULL, 'global', NULL, '2017-11-12 19:24:46', '2017-11-12 19:24:46'),
(181, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:46', '2017-11-12 19:24:46'),
(182, NULL, 'global', NULL, '2017-11-12 19:24:46', '2017-11-12 19:24:46'),
(183, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:46', '2017-11-12 19:24:46'),
(184, NULL, 'global', NULL, '2017-11-12 19:24:46', '2017-11-12 19:24:46'),
(185, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:46', '2017-11-12 19:24:46'),
(186, NULL, 'global', NULL, '2017-11-12 19:24:47', '2017-11-12 19:24:47'),
(187, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:47', '2017-11-12 19:24:47'),
(188, NULL, 'global', NULL, '2017-11-12 19:24:47', '2017-11-12 19:24:47'),
(189, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:47', '2017-11-12 19:24:47'),
(190, NULL, 'global', NULL, '2017-11-12 19:24:47', '2017-11-12 19:24:47'),
(191, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:47', '2017-11-12 19:24:47'),
(192, NULL, 'global', NULL, '2017-11-12 19:24:48', '2017-11-12 19:24:48'),
(193, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:48', '2017-11-12 19:24:48'),
(194, NULL, 'global', NULL, '2017-11-12 19:24:48', '2017-11-12 19:24:48'),
(195, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:48', '2017-11-12 19:24:48'),
(196, NULL, 'global', NULL, '2017-11-12 19:24:48', '2017-11-12 19:24:48'),
(197, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:48', '2017-11-12 19:24:48'),
(198, NULL, 'global', NULL, '2017-11-12 19:24:49', '2017-11-12 19:24:49'),
(199, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:49', '2017-11-12 19:24:49'),
(200, NULL, 'global', NULL, '2017-11-12 19:24:49', '2017-11-12 19:24:49'),
(201, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:49', '2017-11-12 19:24:49'),
(202, NULL, 'global', NULL, '2017-11-12 19:24:49', '2017-11-12 19:24:49'),
(203, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:49', '2017-11-12 19:24:49'),
(204, NULL, 'global', NULL, '2017-11-12 19:24:50', '2017-11-12 19:24:50'),
(205, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:50', '2017-11-12 19:24:50'),
(206, NULL, 'global', NULL, '2017-11-12 19:24:50', '2017-11-12 19:24:50'),
(207, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:50', '2017-11-12 19:24:50'),
(208, NULL, 'global', NULL, '2017-11-12 19:24:50', '2017-11-12 19:24:50'),
(209, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:50', '2017-11-12 19:24:50'),
(210, NULL, 'global', NULL, '2017-11-12 19:24:51', '2017-11-12 19:24:51'),
(211, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:51', '2017-11-12 19:24:51'),
(212, NULL, 'global', NULL, '2017-11-12 19:24:51', '2017-11-12 19:24:51'),
(213, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:51', '2017-11-12 19:24:51'),
(214, NULL, 'global', NULL, '2017-11-12 19:24:57', '2017-11-12 19:24:57'),
(215, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:57', '2017-11-12 19:24:57'),
(216, NULL, 'global', NULL, '2017-11-12 19:24:57', '2017-11-12 19:24:57'),
(217, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:57', '2017-11-12 19:24:57'),
(218, NULL, 'global', NULL, '2017-11-12 19:24:57', '2017-11-12 19:24:57'),
(219, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:57', '2017-11-12 19:24:57'),
(220, NULL, 'global', NULL, '2017-11-12 19:24:57', '2017-11-12 19:24:57'),
(221, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:57', '2017-11-12 19:24:57'),
(222, NULL, 'global', NULL, '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(223, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(224, NULL, 'global', NULL, '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(225, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(226, NULL, 'global', NULL, '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(227, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(228, NULL, 'global', NULL, '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(229, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(230, NULL, 'global', NULL, '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(231, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:58', '2017-11-12 19:24:58'),
(232, NULL, 'global', NULL, '2017-11-12 19:24:59', '2017-11-12 19:24:59'),
(233, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:59', '2017-11-12 19:24:59'),
(234, NULL, 'global', NULL, '2017-11-12 19:24:59', '2017-11-12 19:24:59'),
(235, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:59', '2017-11-12 19:24:59'),
(236, NULL, 'global', NULL, '2017-11-12 19:24:59', '2017-11-12 19:24:59'),
(237, NULL, 'ip', '127.0.0.1', '2017-11-12 19:24:59', '2017-11-12 19:24:59'),
(238, NULL, 'global', NULL, '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(239, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(240, NULL, 'global', NULL, '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(241, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(242, NULL, 'global', NULL, '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(243, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(244, NULL, 'global', NULL, '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(245, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(246, NULL, 'global', NULL, '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(247, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:00', '2017-11-12 19:25:00'),
(248, NULL, 'global', NULL, '2017-11-12 19:25:01', '2017-11-12 19:25:01'),
(249, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:01', '2017-11-12 19:25:01'),
(250, NULL, 'global', NULL, '2017-11-12 19:25:01', '2017-11-12 19:25:01'),
(251, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:01', '2017-11-12 19:25:01'),
(252, NULL, 'global', NULL, '2017-11-12 19:25:01', '2017-11-12 19:25:01'),
(253, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:01', '2017-11-12 19:25:01'),
(254, NULL, 'global', NULL, '2017-11-12 19:25:02', '2017-11-12 19:25:02'),
(255, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:02', '2017-11-12 19:25:02'),
(256, NULL, 'global', NULL, '2017-11-12 19:25:32', '2017-11-12 19:25:32'),
(257, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:32', '2017-11-12 19:25:32'),
(258, NULL, 'global', NULL, '2017-11-12 19:25:32', '2017-11-12 19:25:32'),
(259, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:32', '2017-11-12 19:25:32'),
(260, NULL, 'global', NULL, '2017-11-12 19:25:32', '2017-11-12 19:25:32'),
(261, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:32', '2017-11-12 19:25:32'),
(262, NULL, 'global', NULL, '2017-11-12 19:25:33', '2017-11-12 19:25:33'),
(263, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:33', '2017-11-12 19:25:33'),
(264, NULL, 'global', NULL, '2017-11-12 19:25:33', '2017-11-12 19:25:33'),
(265, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:33', '2017-11-12 19:25:33'),
(266, NULL, 'global', NULL, '2017-11-12 19:25:33', '2017-11-12 19:25:33'),
(267, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:33', '2017-11-12 19:25:33'),
(268, NULL, 'global', NULL, '2017-11-12 19:25:34', '2017-11-12 19:25:34'),
(269, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:34', '2017-11-12 19:25:34'),
(270, NULL, 'global', NULL, '2017-11-12 19:25:34', '2017-11-12 19:25:34'),
(271, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:34', '2017-11-12 19:25:34'),
(272, NULL, 'global', NULL, '2017-11-12 19:25:34', '2017-11-12 19:25:34'),
(273, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:34', '2017-11-12 19:25:34'),
(274, NULL, 'global', NULL, '2017-11-12 19:25:34', '2017-11-12 19:25:34'),
(275, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:34', '2017-11-12 19:25:34'),
(276, NULL, 'global', NULL, '2017-11-12 19:25:35', '2017-11-12 19:25:35'),
(277, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:35', '2017-11-12 19:25:35'),
(278, NULL, 'global', NULL, '2017-11-12 19:25:35', '2017-11-12 19:25:35'),
(279, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:35', '2017-11-12 19:25:35'),
(280, NULL, 'global', NULL, '2017-11-12 19:25:35', '2017-11-12 19:25:35'),
(281, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:35', '2017-11-12 19:25:35'),
(282, NULL, 'global', NULL, '2017-11-12 19:25:35', '2017-11-12 19:25:35'),
(283, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:35', '2017-11-12 19:25:35'),
(284, NULL, 'global', NULL, '2017-11-12 19:25:36', '2017-11-12 19:25:36'),
(285, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:36', '2017-11-12 19:25:36'),
(286, NULL, 'global', NULL, '2017-11-12 19:25:36', '2017-11-12 19:25:36'),
(287, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:36', '2017-11-12 19:25:36'),
(288, NULL, 'global', NULL, '2017-11-12 19:25:36', '2017-11-12 19:25:36'),
(289, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:36', '2017-11-12 19:25:36'),
(290, NULL, 'global', NULL, '2017-11-12 19:25:37', '2017-11-12 19:25:37'),
(291, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:37', '2017-11-12 19:25:37'),
(292, NULL, 'global', NULL, '2017-11-12 19:25:37', '2017-11-12 19:25:37'),
(293, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:37', '2017-11-12 19:25:37'),
(294, NULL, 'global', NULL, '2017-11-12 19:25:37', '2017-11-12 19:25:37'),
(295, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:37', '2017-11-12 19:25:37'),
(296, NULL, 'global', NULL, '2017-11-12 19:25:37', '2017-11-12 19:25:37'),
(297, NULL, 'ip', '127.0.0.1', '2017-11-12 19:25:37', '2017-11-12 19:25:37'),
(298, NULL, 'global', NULL, '2017-11-12 19:36:41', '2017-11-12 19:36:41'),
(299, NULL, 'ip', '127.0.0.1', '2017-11-12 19:36:41', '2017-11-12 19:36:41'),
(300, 4, 'user', NULL, '2017-11-12 19:36:41', '2017-11-12 19:36:41'),
(301, NULL, 'global', NULL, '2017-11-12 19:44:35', '2017-11-12 19:44:35'),
(302, NULL, 'ip', '127.0.0.1', '2017-11-12 19:44:35', '2017-11-12 19:44:35'),
(303, 1, 'user', NULL, '2017-11-12 19:44:35', '2017-11-12 19:44:35'),
(304, NULL, 'global', NULL, '2017-11-13 12:12:10', '2017-11-13 12:12:10'),
(305, NULL, 'ip', '127.0.0.1', '2017-11-13 12:12:10', '2017-11-13 12:12:10'),
(306, 1, 'user', NULL, '2017-11-13 12:12:10', '2017-11-13 12:12:10'),
(307, NULL, 'global', NULL, '2017-11-15 04:15:14', '2017-11-15 04:15:14'),
(308, NULL, 'ip', '127.0.0.1', '2017-11-15 04:15:14', '2017-11-15 04:15:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_member_id` int(11) DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `group_member_id`, `password`, `permissions`, `last_login`, `fullname`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'diennk@dienkim.com', 1, '$2y$10$rpZe6oM3GUJmwL/ZMTKm/OSe24l9TJKFU9lwd8VmohkqH0Oax6rVK', NULL, '2017-11-24 06:39:38', 'Nguyễn Kim Điền', 1, 1, '2017-11-12 07:23:56', '2017-11-24 06:39:38'),
(6, 'nhatanh', 'nhatanh@gmail.com', 1, '$2y$10$X.wWyaR4gqC8BAvcVtlH0u8FG1DC2a0dXPzPL.Qs96Ds/cJZqxviO', NULL, '2017-11-15 09:46:30', 'Nhật Anh', 3, 1, '2017-11-15 09:45:46', '2017-11-15 09:46:30');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `article_category`
--
ALTER TABLE `article_category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category_article`
--
ALTER TABLE `category_article`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `group_member`
--
ALTER TABLE `group_member`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `group_privilege`
--
ALTER TABLE `group_privilege`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menu_type`
--
ALTER TABLE `menu_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `module_article`
--
ALTER TABLE `module_article`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `module_item`
--
ALTER TABLE `module_item`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `module_menu`
--
ALTER TABLE `module_menu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mod_menu_type`
--
ALTER TABLE `mod_menu_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `persistences`
--
ALTER TABLE `persistences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persistences_code_unique` (`code`);

--
-- Chỉ mục cho bảng `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Chỉ mục cho bảng `setting_system`
--
ALTER TABLE `setting_system`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `throttle`
--
ALTER TABLE `throttle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `throttle_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `activations`
--
ALTER TABLE `activations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT cho bảng `album`
--
ALTER TABLE `album`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT cho bảng `article`
--
ALTER TABLE `article`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT cho bảng `article_category`
--
ALTER TABLE `article_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT cho bảng `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT cho bảng `category_article`
--
ALTER TABLE `category_article`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT cho bảng `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT cho bảng `group_member`
--
ALTER TABLE `group_member`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT cho bảng `group_privilege`
--
ALTER TABLE `group_privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT cho bảng `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT cho bảng `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT cho bảng `menu_type`
--
ALTER TABLE `menu_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT cho bảng `module_article`
--
ALTER TABLE `module_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT cho bảng `module_item`
--
ALTER TABLE `module_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT cho bảng `module_menu`
--
ALTER TABLE `module_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT cho bảng `mod_menu_type`
--
ALTER TABLE `mod_menu_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT cho bảng `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT cho bảng `persistences`
--
ALTER TABLE `persistences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;
--
-- AUTO_INCREMENT cho bảng `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT cho bảng `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT cho bảng `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT cho bảng `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `setting_system`
--
ALTER TABLE `setting_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT cho bảng `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;
--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
