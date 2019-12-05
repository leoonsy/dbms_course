DELIMITER $$ 

CREATE TRIGGER `before_delete_categories` 
BEFORE DELETE ON `categories` 
FOR EACH ROW BEGIN
DELETE FROM
  `products`
WHERE
  `products`.`category_id` = OLD.`id`;
END$$

DELIMITER ;

INSERT INTO
  `products` (`id`, `category_id`, `name`, `price`, `count`)
VALUES
  (NULL, '6', 'AEROCOOL VX PLUS 450W', '1739', '2');

DELETE FROM `categories` WHERE `categories`.`id` = 6;

SELECT * FROM `products` WHERE `category_id` = 6