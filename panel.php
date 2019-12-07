<?php

declare(strict_types=1);

mb_internal_encoding("UTF-8");

ini_set('display_errors', (string) 1);
ini_set('display_startup_errors', (string) 1);
ini_set('error_reporting', (string) E_ALL);

require_once 'core/account.php';
require_once 'core/config.php';

$account = new Account();
if ($account->getRole() === 'guest') {
    header('Location: ' . Config::SITE_NAME . '/');
    exit();
}

$params['login'] = $_SESSION['login'];

require_once 'tpl/panel.tpl';
