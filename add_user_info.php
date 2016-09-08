<?php

require_once 'Connection.php';
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 04.09.16
 * Time: 17:13
 */

class Add_User_Info
{
    public $user_login     = 'login';
    public $user_password  = 'password';
    public $user_password2 = 'password2';
    public $user_name      = 'name';
    public $user_age       = 'age';
    public $user_about     = 'about';

    /**
     * Function adds lofin and password from registration form
     * @param string $user_login it is login
     * @param string $user_password
     * @param string $user_password2
     */
    public function add_login_password($user_login, $user_password, $user_password2)
    {
        if ($user_password == $user_password2) {
            if (isset($user_login) || isset($user_password)) {
                if (empty($user_login) || empty($user_password)) {
                    echo "Данные введены неверно";
                } else {
                    $user_login= strip_tags($user_login);
                    $db = new mysqli(
                        $GLOBALS['host'],
                        $GLOBALS['login'],
                        $GLOBALS['password'],
                        $GLOBALS['db_name']
                    );
                    if ($db->connect_errno) {
                        echo "ошибка подключения к БР";
                    }
                    $result = $db->query(
                        "select * from users
                        where username = '$user_login' LIMIT 0,1"
                    );
                    $record = $result->fetch_assoc();
                    if (!empty($record)) {
                        echo "Такой пользователь уже существует";
                    } else {
                        $db->query(
                            "INSERT INTO `users` (username, password) 
                            VALUES ('$user_login', '$user_password')"
                        );
                        echo 2;
                        echo "Регистрация прошла успешно";
                    }
                }
            }
        } else {
            echo 'Пароли не совпадают';
        }
    }

    /**
     * Function adds data about user to date base
     * @param $username
     * @param $password
     * @param $name
     * @param $age
     * @param $about
     * @param $id
     */
    public function add_name_age_about(
        $username,
        $password,
        $name,
        $age,
        $about,
        $id
    ) {
        if (isset($name) || isset($age) || isset($about)) {
            if (empty($name) || empty($age) || empty($about)) {
            } else {
                $username = strip_tags($username);
                $password = strip_tags($password);
                $name   = strip_tags($name);
                $age    = strip_tags($age);
                $about  = strip_tags($about);
                $db = new mysqli(
                    $GLOBALS['host'],
                    $GLOBALS['login'],
                    $GLOBALS['password'],
                    $GLOBALS['db_name']
                );
                if (!$db->set_charset("utf8")) {
                    printf(
                        "Ошибка при загрузке набора символов utf8: %s\n",
                        $db->error
                    );
                }

                if ($db->connect_errno) {
                    echo "ошибка подключения к БР";
                } else {
                    $sql = " UPDATE users
                          SET username = ?, 
                          password = ?, 
                          name = ?, 
                          age = ?, 
                          about = ? 
                          WHERE id = ?";
                    if ($stmt = $db->prepare($sql)) {
                        $stmt->bind_param(
                            'sssisi',
                            $username,
                            $password,
                            $name,
                            $age,
                            $about,
                            $id
                        );
                        $stmt->execute();
                    }
                }
            }
        }
    }
}
