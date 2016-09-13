<?php
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 02.09.16
 * Time: 0:23
 */

class Connection
{
    public $db;
    /** проверка подключения
     * @param $host
     * @param $user
     * @param $password
     * @param $dbname
     */
    public function dbconnect($host, $user, $password, $dbname)
    {
        $db = new mysqli($host, $user, $password, $dbname);
        if ($db->connect_errno) {
            exit("ошибка подключения к БД, повторите запрос");
        }
    }
}

