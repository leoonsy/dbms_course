<?php

declare(strict_types=1);
mb_internal_encoding("UTF-8");

ini_set('display_errors', (string) 1);
ini_set('display_startup_errors', (string) 1);
ini_set('error_reporting', (string) E_ALL);

require_once 'config.php';
require_once 'db.php';

$db = Db::getDBO();

$tables = ['categories', 'products', 'orders', 'customers'];

if (isset($_GET['table'])) {
	$table = $_GET['table'];
	if (!in_array($table, $tables))
		sendResponse(false);

	$rows = $db->getAll("SELECT * FROM $table");
	sendResponse(true, $rows);
}

function sendResponse($error, $data = [])
{
	echo json_encode(['success' => $error, 'data' => $data]);
	exit;
}

sendResponse(false);
