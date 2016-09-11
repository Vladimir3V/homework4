<?php

require_once 'Connection.php';
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 05.09.16
 * Time: 22:18
 */
//по psr-2 класы пишутся так GetDataFormDB
class GetDataFormDB
{
    /**
     * ПОлучает данные о юзере из базы
     * @param $u_id
     */


    public function getInfo($u_id)//методы тоже
        // --- нет не верно в PSR-1 написано что
// /Class names MUST be declared in StudlyCaps
//Method names MUST be declared in camelCase()
// Можешь посмтореть как в справочнике PSR2 в примерах методы называют
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
        return $_SESSION;
    }
}