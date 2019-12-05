DELIMITER $$
CREATE PROCEDURE GetProductsByCustomerId (IN customerid INT) 
LANGUAGE SQL 
BEGIN
SELECT
  `p`.`name`
FROM
  `orders` `o`,
  `products` `p`
WHERE
  `o`.`customer_id` = customerid
  AND `o`.`product_id` = `p`.`id`;
END $$
DELIMITER ;

DELIMITER $$
CREATE FUNCTION GetCategoryByProductName (product_name VARCHAR(100)) 
RETURNS VARCHAR(100) 
LANGUAGE SQL 
BEGIN
DECLARE result VARCHAR(100);
SELECT
  `name` INTO result
FROM
  `categories`
WHERE
  `id` = (SELECT `category_id` FROM `products` WHERE `name` = product_name);
RETURN result;
END $$ 
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE GetProductsByPrice (IN val INT, IN cond VARCHAR(2)) 
LANGUAGE SQL 
BEGIN
  CASE cond
  WHEN '<' THEN
  SELECT * FROM `products` WHERE `price` < val;
  WHEN '<=' THEN
  SELECT * FROM `products` WHERE `price` <= val;
  WHEN '>' THEN
  SELECT * FROM `products` WHERE `price` > val;
  WHEN '>=' THEN
  SELECT * FROM `products` WHERE `price` >= val;
  WHEN '=' THEN
  SELECT * FROM `products` WHERE `price` = val;
  END CASE;
END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS GetProductsByPrice;