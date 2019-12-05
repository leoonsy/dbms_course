--ALTER TABLE имяВашейТаблицы AUTO_INCREMENT = 0
INSERT INTO
  `categories` (`id`, `name`)
VALUES
  (NULL, 'Материнские платы'),
  (NULL, 'Видеокарты'),
  (NULL, 'Процессоры'),
  (NULL, 'Оперативная память'),
  (NULL, 'Блоки питания'),
  (NULL, 'Корпуса');

INSERT INTO
  `products` (`id`, `category_id`, `name`, `price`, `count`)
VALUES
  (NULL, '3', 'AMD Athlon X4 840 OEM', '1599', '4'),
  (NULL, '3', 'Intel Celeron G3900 BOX', '2600', '6'),
  (NULL, '3', 'AMD Ryzen 5 2600 OEM', '10299', '9'),
  (NULL, '3', 'Intel Core i3-9100 OEM', '10499', '6'),
  (NULL, '3', 'Intel Xeon E5-2623 v4 OEM', '35299', '3'),
  (NULL, '3', 'Intel Core i7-7800X BOX', '35999', '1'),
  (NULL, '1', 'ASUS A68HM-K', '2899', '4'),
  (NULL, '1', 'ASRock AB350M-HDV R4.0', '4050', '12'),
  (NULL, '1', 'GIGABYTE B360M AORUS Gaming 3', '7199', '7'),
  (NULL, '1', 'ASRock Fatal1ty H370 Performance', '10299', '3'),
  (NULL, '1', 'ASRock Fatal1ty X370 Professional Gaming', '16299', '2'),
  (NULL, '2', 'GIGABYTE X299 AORUS GAMING 3', '25299', '14'),
  (NULL, '2', 'Gigabyte AMD Radeon RX 550 D5 [GV-RX550D5-2GD]', '7399', '10'),
  (NULL, '2', 'ASUS AMD Radeon RX 560 OC [RX560-O4G]', '10499', '7'),
  (NULL, '2', 'MSI GeForce GTX 1660 AERO ITX OC [GTX 1660 AERO ITX 6G OC]', '16500', '8'),
  (NULL, '2', 'GIGABYTE GeForce RTX 2060 Super WINDFORCE OC [GV-N206SWF2OC-8GD]', '31299', '6'),
  (NULL, '2', 'MSI GeForce RTX 2080 Super VENTUS XS OC [RTX 2080 SUPER VENTUS XS OC]', '55499', '4'),
  (NULL, '4', 'Patriot Signature [PSD32G16002] 2 ГБ', '850', '2'),
  (NULL, '4', 'A-Data XPG Gammix D10 [AX4U266638G16-DBG] 16 ГБ', '6199', '5'),
  (NULL, '4', 'Patriot Signature Line Premium [PSP432G2666KH1] 32 ГБ', '11799', '3'),
  (NULL, '5', 'Sven 350W [PU-350AN]', '950', '3'),
  (NULL, '5', 'Aerocool KCAS PLUS 500W [KCAS-500 PLUS]', '3050', '3'),
  (NULL, '5', 'Aerocool KCAS-700W [KCAS-700W]', '4050', '3'),
  (NULL, '5', 'NZXT E850 850W [NP-1PM-E850A]', '12299', '3');

INSERT INTO 
  `customers` (`id`, `first_name`, `last_name`) 
VALUES 
  (NULL, 'Борис', 'Казаков'),
  (NULL, 'Виталий', 'Белозёров'),
  (NULL, 'Никита', 'Доронин'),
  (NULL, 'Филлип', 'Одинцов'),
  (NULL, 'Никита', 'Шилов'),
  (NULL, 'Валентин', 'Харитонов'),
  (NULL, 'Валерий', 'Исаков'),
  (NULL, 'Дмитрий', 'Тимофеев'),
  (NULL, 'Гавриил', 'Лапин'),
  (NULL, 'Матвей', 'Кононов'),
  (NULL, 'Ростислав', 'Сазонов'),
  (NULL, 'Михаил', 'Русаков'),
  (NULL, 'Никита', 'Никонов');

INSERT INTO `orders` 
  (`id`, `customer_id`, `product_id`, `product_count`, `price`) 
VALUES 
  (NULL, '1', '12', '2', (SELECT `price` FROM `products` WHERE `id`='12')),
  (NULL, '1', '17', '3', (SELECT `price` FROM `products` WHERE `id`='17')),
  (NULL, '2', '4', '1', (SELECT `price` FROM `products` WHERE `id`='4')),
  (NULL, '3', '8', '4', (SELECT `price` FROM `products` WHERE `id`='8')),
  (NULL, '3', '12', '3', (SELECT `price` FROM `products` WHERE `id`='12')),
  (NULL, '5', '5', '1', (SELECT `price` FROM `products` WHERE `id`='5')),
  (NULL, '6', '9', '4', (SELECT `price` FROM `products` WHERE `id`='9')),
  (NULL, '6', '11', '1', (SELECT `price` FROM `products` WHERE `id`='11')),
  (NULL, '6', '13', '5', (SELECT `price` FROM `products` WHERE `id`='13')),
  (NULL, '7', '13', '3', (SELECT `price` FROM `products` WHERE `id`='13')),
  (NULL, '8', '13', '1', (SELECT `price` FROM `products` WHERE `id`='13')),
  (NULL, '9', '18', '1', (SELECT `price` FROM `products` WHERE `id`='18')),
  (NULL, '10', '18', '1', (SELECT `price` FROM `products` WHERE `id`='18')),
  (NULL, '11', '16', '2', (SELECT `price` FROM `products` WHERE `id`='16')),
  (NULL, '12', '16', '2', (SELECT `price` FROM `products` WHERE `id`='16')),
  (NULL, '12', '14', '3', (SELECT `price` FROM `products` WHERE `id`='14')),
  (NULL, '12', '2', '1', (SELECT `price` FROM `products` WHERE `id`='2'));