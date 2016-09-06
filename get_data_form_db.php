<?php

require_once 'connection.php';
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 05.09.16
 * Time: 22:18
 */

class Get_Data_Form_DB
{
    /**
     * ПОлучает данные о юзере из базы
     * @param $u_id
     */
    public function get_info($u_id)
    {
        $db = new mysqli(
            $GLOBALS['host'],
            $GLOBALS['login'],
            $GLOBALS['password'],
            $GLOBALS['db_name']
        );
        if (!$db->set_charset("utf8")) {
            printf("Ошибка при загрузке набора символов utf8: %s\n", $db->error);
        }

        if ($db->connect_errno) {
            exit("ошибка подключения");
        }
        $res = $db->query(
            "select * from users where id = '$u_id'"
        );
        $record = $res->fetch_assoc();
        $_SESSION ['username'] = $record ['username'];
        $_SESSION ['password'] = $record ['password'];
        $_SESSION ['name']     = $record ['name'];
        $_SESSION ['age']      = $record ['age'];
        $_SESSION ['about']    = $record ['about'];
    }


}