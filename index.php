<?php
mb_internal_encoding("UTF-8");

ini_set('display_errors', (string) 1);
ini_set('display_startup_errors', (string) 1);
ini_set('error_reporting', (string) E_ALL);

require 'core/account.php';

$account = new Account();
if ($account->getRole() !== 'guest') {
    if (isset($_GET['logout'])) {
        $account->logout();
        header('Location: ' . Config::SITE_NAME . '/');
    } else
        header('Location: ' . Config::SITE_NAME . '/panel.php');

    exit();
}

$params = ['authError' => null];
if (isset($_POST['auth'])) {
    if ($account->authenticate($_POST['login'], $_POST['password'])) {
        header('Location: ' . Config::SITE_NAME . '/panel.php');
        exit();
    }

    $params['authError'] = true;
}

require 'tpl/index.tpl';