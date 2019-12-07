-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 07 2019 г., 19:21
-- Версия сервера: 8.0.15
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dbms_course`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Материнские платы'),
(2, 'Видеокарты'),
(3, 'Процессоры'),
(4, 'Оперативная память'),
(5, 'Блоки питания'),
(6, 'Корпуса');

--
-- Триггеры `categories`
--
DELIMITER $$
CREATE TRIGGER `before_delete_categories` BEFORE DELETE ON `categories` FOR EACH ROW BEGIN
DELETE FROM
  `products`
WHERE
  `products`.`category_id` = OLD.`id`;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`) VALUES
(1, 'Борис', 'Казаков'),
(6, 'Валентин', 'Харитонов'),
(7, 'Валерий', 'Исаков'),
(2, 'Виталий', 'Белозёров'),
(9, 'Гавриил', 'Лапин'),
(8, 'Дмитрий', 'Тимофеев'),
(11, 'Матвей', 'Кононов'),
(13, 'Михаил', 'Русаков'),
(3, 'Никита', 'Доронин'),
(15, 'Никита', 'Никонов'),
(5, 'Никита', 'Шилов'),
(12, 'Ростислав', 'Сазонов'),
(4, 'Филлип', 'Одинцов');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `customer_price`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `customer_price` (
`first_name` varchar(100)
,`last_name` varchar(100)
,`total_price` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_count` int(10) UNSIGNED NOT NULL,
  `price` decimal(15,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `product_id`, `product_count`, `price`) VALUES
(1, 1, 12, 2, '25299.00'),
(2, 1, 17, 3, '55499.00'),
(3, 2, 4, 1, '10499.00'),
(4, 3, 8, 4, '4050.00'),
(5, 3, 12, 3, '25299.00'),
(6, 5, 5, 1, '35299.00'),
(7, 6, 9, 4, '7199.00'),
(8, 6, 11, 1, '16299.00'),
(9, 6, 13, 5, '7399.00'),
(10, 7, 13, 3, '7399.00'),
(11, 8, 13, 1, '7399.00'),
(12, 9, 18, 1, '850.00'),
(14, 11, 16, 2, '31299.00'),
(15, 12, 16, 2, '31299.00'),
(16, 12, 14, 3, '10499.00'),
(17, 12, 2, 1, '2600.00'),
(18, 1, 1, 1, '1.00');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) UNSIGNED NOT NULL,
  `count` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `price`, `count`) VALUES
(1, 3, 'AMD Athlon X4 840 OEM', '1599.00', 4),
(2, 3, 'Intel Celeron G3900 BOX', '2600.00', 6),
(3, 3, 'AMD Ryzen 5 2600 OEM', '10299.00', 9),
(4, 3, 'Intel Core i3-9100 OEM', '10499.00', 6),
(5, 3, 'Intel Xeon E5-2623 v4 OEM', '35299.00', 3),
(6, 3, 'Intel Core i7-7800X BOX', '35999.00', 1),
(7, 1, 'ASUS A68HM-K', '2899.00', 4),
(8, 1, 'ASRock AB350M-HDV R4.0', '4050.00', 12),
(9, 1, 'GIGABYTE B360M AORUS Gaming 3', '7199.00', 7),
(10, 1, 'ASRock Fatal1ty H370 Performance', '10299.00', 3),
(11, 1, 'ASRock Fatal1ty X370 Professional Gaming', '16299.00', 2),
(12, 2, 'GIGABYTE X299 AORUS GAMING 3', '25299.00', 14),
(13, 2, 'Gigabyte AMD Radeon RX 550 D5 [GV-RX550D5-2GD]', '7399.00', 10),
(14, 2, 'ASUS AMD Radeon RX 560 OC [RX560-O4G]', '10499.00', 7),
(15, 2, 'MSI GeForce GTX 1660 AERO ITX OC [GTX 1660 AERO ITX 6G OC]', '16500.00', 8),
(16, 2, 'GIGABYTE GeForce RTX 2060 Super WINDFORCE OC [GV-N206SWF2OC-8GD]', '31299.00', 6),
(17, 2, 'MSI GeForce RTX 2080 Super VENTUS XS OC [RTX 2080 SUPER VENTUS XS OC]', '55499.00', 4),
(18, 4, 'Patriot Signature [PSD32G16002] 2 ГБ', '850.00', 2),
(19, 4, 'A-Data XPG Gammix D10 [AX4U266638G16-DBG] 16 ГБ', '6199.00', 5),
(20, 4, 'Patriot Signature Line Premium [PSP432G2666KH1] 32 ГБ', '11799.00', 3),
(21, 5, 'Sven 400W [PU-400AN]', '950.00', 3),
(22, 5, 'Aerocool KCAS PLUS 500W [KCAS-500 PLUS]', '3050.00', 3),
(23, 5, 'Aerocool KCAS-700W [KCAS-700W]', '4050.00', 3),
(24, 5, 'NZXT E850 850W [NP-1PM-E850A]', '12299.00', 3),
(25, 1, 'Имя товара', '1.00', 1);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `product_category`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `product_category` (
`product_name` varchar(100)
,`category_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$ICE.tCHzUOXvjDKcqA95.ue1q9UNDSyXAjmzrefjhsQ5AiHGykBpy', 'admin'),
(2, 'sergey', '$2y$10$Y1ORi9QwqNQ.jmeMYiKqiOhoIr2p4OHGvBsgsd3z0fO47AOXZfvfm', 'user');

-- --------------------------------------------------------

--
-- Структура для представления `customer_price`
--
DROP TABLE IF EXISTS `customer_price`;

CREATE ALGORITHM=UNDEFINED DEFINER=`leoon`@`localhost` SQL SECURITY DEFINER VIEW `customer_price`  AS  select `c`.`first_name` AS `first_name`,`c`.`last_name` AS `last_name`,sum(`o`.`price`) AS `total_price` from (`orders` `o` join `customers` `c`) where (`o`.`customer_id` = `c`.`id`) group by `c`.`first_name`,`c`.`last_name` ;

-- --------------------------------------------------------

--
-- Структура для представления `product_category`
--
DROP TABLE IF EXISTS `product_category`;

CREATE ALGORITHM=UNDEFINED DEFINER=`leoon`@`localhost` SQL SECURITY DEFINER VIEW `product_category`  AS  select `p`.`name` AS `product_name`,`c`.`name` AS `category_name` from (`categories` `c` join `products` `p`) where (`p`.`category_id` = `c`.`id`) ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `first_name` (`first_name`,`last_name`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_products_fk` (`product_id`),
  ADD KEY `orders_customers_fk` (`customer_id`),
  ADD KEY `price` (`price`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_categories_fk` (`category_id`),
  ADD KEY `price` (`price`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customers_fk` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_products_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_categories_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
