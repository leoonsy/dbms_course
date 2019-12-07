<?php
require_once 'config.php';
require_once 'db.php';

class Account
{
    /**
     * Права доступа к БД
     *
     * @var array
     */
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

    /**
     * Получить права доступа к БД
     *
     * @param string $role
     * @return array
     */
    public function getAclActions($role)
    {
        return $this->aclActions[$role];
    }

    public function __construct()
    {
        session_start();
    }

    /**
     * Получить роль
     *
     * @return string
     */
    public function getRole()
    {
        if (isset($_SESSION['login']))
            return $_SESSION['role'];

        return 'guest';
    }

    /**
     * Аутентификация пользователя
     *
     * @param string $login
     * @param string $password
     * @return bool
     */
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

    /**
     * Уничтожение сессии (выход)
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();
    }
}
