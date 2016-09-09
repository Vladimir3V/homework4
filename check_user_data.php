<?php

require_once 'Connection.php';
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 03.09.16
 * Time: 18:21
 */


class CheckUserData
{
    public $user_login    = 'login';
    public $user_password = 'password';

    /**
     * ПРоверяет пользователя и пароль
     * @param $user_login
     * @param $user_password
     */
    public function checkLoginPassword($user_login, $user_password)
    {
        if (isset($user_login) || isset($user_password)) {
            if (empty($user_login) || empty($user_password)) {
                echo "Данные введены неверно, пройдите регистрацию";
            } else {
                $db = new mysqli(
                    $GLOBALS['host'],
                    $GLOBALS['login'],
                    $GLOBALS['password'],
                    $GLOBALS['db_name']
                );
                if ($db->connect_errno) {
                    exit("ошибка подключения");
                }
                $result = $db->query(
                    "select * from users where username = '$user_login' LIMIT 0,1"
                );
                $record = $result->fetch_assoc();

                if (isset($result) && $record ['password'] == $user_password) {
                    echo 1;
                    $res = $db->query(
                        "select id from users where username = '$user_login' "
                    );
                    $record = $res->fetch_assoc();
                    $_SESSION ['id'] = $record ['id'];
                } else {
                    echo ' Что-то пошло не так, может нужно зарегистрироваться';
                }
            }
        }
    }
}
