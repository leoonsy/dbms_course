SELECT
  `c`.`name` AS `category_name`,
  `p`.`name` AS `product_name`
FROM
  `categories` `c`,
  `products` `p`
WHERE
  `p`.`category_id` = `c`.`id`
ORDER BY
  `c`.`name`;
SELECT
  DISTINCT `cat`.`name` AS `category_name`,
  `cust`.`first_name`,
  `cust`.`last_name`
FROM
  `categories` `cat`,
  `products` `p`,
  `orders` `o`,
  `customers` `cust`
WHERE
  `cat`.`id` = `p`.`category_id`
  AND `p`.`id` = `o`.`product_id`
  AND `o`.`customer_id` = `cust`.`id`
ORDER BY
  `cat`.`name`
SELECT
  DISTINCT `cat`.`name` AS `category_name`,
  `cust`.`first_name`,
  `cust`.`last_name`
FROM
  `orders` `o`
  JOIN `customers` `cust` ON `o`.`customer_id` = `cust.id`
  JOIN `products` `p` ON `p`.`id` = `o`.`product_id`
  RIGHT JOIN `categories` `cat` ON `cat`.`id` = `p`.`category_id`
ORDER BY
  `cat`.`name`
SELECT
  `p`.`name`,
  COUNT(`p`.`name`) AS `products_count`
FROM
  `products` `p`,
  `orders` `o`
WHERE
  `p`.`id` = `o`.`product_id`
GROUP BY
  `p`.`name`
ORDER BY
  `products_count`
SELECT
  `c`.`first_name`,
  `c`.`last_name`,
  SUM(`o`.`price`) AS `price_sum`
FROM
  `orders` `o`,
  `customers` `c`
WHERE
  `o`.`customer_id` = `c`.`id`
GROUP BY
  `c`.`first_name`,
  `c`.`last_name`
ORDER BY
  `price_sum` DESC
LIMIT
  1