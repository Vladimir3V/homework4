<?php

require_once 'Connection.php';
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 04.09.16
 * Time: 17:13
 */

class AddUserInfo
{
    public $user_login     = 'login';
    public $user_password  = 'password';
    public $user_password2 = 'password2';
    public $user_name      = 'name';
    public $user_age       = 'age';
    public $user_about     = 'about';

    /**
     * Функция удаляет Юзера
     * @param $userid
     */
    public function delUser($posst, $userid)
    {
        if (isset($posst)) {
            $db = new mysqli(
                $GLOBALS['host'],
                $GLOBALS['login'],
                $GLOBALS['password'],
                $GLOBALS['db_name']
            );
            if ($db->connect_errno) {
                echo "ошибка подключения к БР";

            }
            $db->query("DELETE FROM `users` WHERE 'id' = $userid");
            unset($_SESSION["id"]);
            session_destroy();
            echo '<script type="text/javascript">
              window.location = "index.html"
              </script>';

        }

    }
    /**
     * Function adds lofin and password from registration form
     * @param string $user_login it is login
     * @param string $user_password
     * @param string $user_password2
     */
    public function addLoginPassword($user_login, $user_password, $user_password2)
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

                        $res = $db->query(
                            "select id from users where username = '$user_login' "
                        );
                        $record = $res->fetch_assoc();
                        $_SESSION ['id'] = $record ['id'];

                        echo 2;
                    }
                }
            }
        } else {
            echo 'Пароли не совпадают';
        }
    }

    /**
     * Function adds data about user to date base
     */
    public function addNameAgeAbout($arr, $id)
    {

        if (isset($arr['Username'])) {
            $arr['username'] = strip_tags($arr['Username']);
            $arr['password'] = strip_tags($arr['Password']);
            $arr['name']     = strip_tags($arr['Name']);
            $arr['age']      = strip_tags($arr['Age']);
            $arr['about']    = strip_tags($arr['About']);
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
                        $arr['username'],
                        $arr['password'],
                        $arr['name'],
                        $arr['age'],
                        $arr['about'],
                        $id
                    );
                    $stmt->execute();
                }
            }
        }
    }
}
