<?php
require_once 'config.php';
require_once 'db.php';

class Account
{
    private $aclActions = [
        'guest' => [
            'select' => false,
            'insert' => false,
            'update' => false,
            'delete' => false
        ],
        'user' => [
            'select' => true,
            'insert' => false,
            'update' => false,
            'delete' => false
        ],
        'admin' => [
            'select' => true,
            'insert' => true,
            'update' => true,
            'delete' => true
        ]
    ];

    public function getAclActions($role)
    {
        return $this->aclActions[$role];
    }

    public function __construct()
    {
        session_start();
    }

    public function getRole()
    {
        if (isset($_SESSION['login']))
            return $_SESSION['role'];

        return 'guest';
    }

    public function authenticate($login, $password)
    {
        $db = Db::getDBO();
        $account = $db->getFirst("SELECT * FROM users WHERE login = ?", [$login]);
        if ($account) {
            if (!password_verify($password, $account['password']))
                return false;

            $_SESSION['login'] = $account['login'];
            $_SESSION['role'] = $account['role'];
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_destroy();
    }
}
