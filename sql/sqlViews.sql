CREATE VIEW customer_price AS
SELECT
  c.first_name,
  c.last_name,
  SUM(o.price) as total_price
FROM orders o,
  customers c
WHERE
  o.customer_id = c.id
GROUP BY
  c.first_name,
  c.last_name;
CREATE VIEW product_category AS
SELECT
  p.name AS product_name,
  c.name AS category_name
FROM categories c,
  products p
WHERE
  p.category_id = c.id;
UPDATE product_category
SET
  product_name = 'Sven 400W [PU-400AN]'
WHERE
  product_name = 'Sven 350W [PU-350AN]';