<?php
require_once 'config.php';
require_once 'db.php';
require_once 'rest.php';
require_once 'account.php';

header('Content-Type: application/json');

$account = new Account();
$role = $account->getRole();
$aclActions = $account->getAclActions($role);

//запрос на получение прав для действий над таблицей
if (isset($_GET['acl'])) {
	echo json_encode($aclActions);
	exit();
}

$db = Db::getDBO();

$tables = ['categories', 'products', 'orders', 'customers'];

//удаление строки
if (isset($_DELETE['id'])) {
	if (!$aclActions['delete'])
		sendResponse(false);

	$id = $_DELETE['id'];
	if (!is_numeric($id))
		sendResponse(false);

	$table = $_GET['table'] ?? null;
	if (!in_array($table, $tables))
		sendResponse(false);

	try {
		$rows = $db->query("DELETE FROM $table WHERE id = ?", [$id]);
	} catch (Exception $e) {
		sendResponse(false);
	}
	sendResponse(true);
}

//добавление строки
if (isset($_POST['id'])) {
	if (!$aclActions['insert'])
		sendResponse(false);

	$table = $_GET['table'] ?? null;
	if (!in_array($table, $tables))
		sendResponse(false);

	switch ($table) {
		case 'categories':
			$db->query("INSERT INTO categories (id, name) VALUES (NULL, 'Новая категория')");
			break;
		case 'products':
			$db->query("INSERT INTO products (id, category_id, name, price, count) VALUES (NULL, '1', 'Имя товара', '1', '1')");
			break;
		case 'orders':
			$db->query("INSERT INTO orders (id, customer_id, product_id, product_count, price) VALUES (NULL, '1', '1', '1', '1')");
			break;
		case 'customers':
			$db->query("INSERT INTO customers (id, first_name, last_name) VALUES (NULL, 'Имя', 'Фамилия')");
			break;
	}

	$response = $db->getAll("SELECT * FROM $table ORDER BY ID DESC LIMIT 1");

	sendResponse(true, $response[0]);
}

//изменение таблицы
if (isset($_PUT['id'])) {
	if (!$aclActions['update'])
		sendResponse(false);

	$id = $_PUT['id'];

	if (isset($_PUT['key']))
		$key = $db->quote($_PUT['key'], false);
	else
		$key = null;

	$value = $_PUT['value'] ?? null;
	$table = $_GET['table'] ?? null;

	if (!in_array($table, $tables))
		sendResponse(false);

	try {
		$rows = $db->query("UPDATE $table SET $key = :value WHERE id = :id", ['value' => $value, 'id' => $id]);
	} catch (Exception $e) {
		sendResponse(false);
		exit();
	}
	sendResponse(true);
}

//получение таблицы
if (isset($_GET['table'])) {
	if (!$aclActions['select'])
		sendResponse(false);

	$table = $_GET['table'];
	if (!in_array($table, $tables))
		sendResponse(false);

	$rows = $db->getAll("SELECT * FROM $table");
	sendResponse(true, $rows);
}

sendResponse(false);

/**
 * Ответ в виде json
 *
 * @param bool $error
 * @param array $data
 * @return void
 */
function sendResponse($error, $data = [])
{
	echo json_encode(['success' => $error, 'data' => $data]);
	exit;
}
