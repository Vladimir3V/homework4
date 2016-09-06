<?php

/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 05.09.16
 * Time: 22:18
 */
class Get_Data_Form_DB
{
    public function get_info ($u_id) {
        $db = new mysqli("localhost", "root", "root", 'uzzerz');
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