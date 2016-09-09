<?php

require_once 'Connection.php';
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 01.09.16
 * Time: 18:38
 */


class DBOperate
{

    public $host = "host";
    public $login = "login";
    public $password = "password";
    public $db_name = "database";

    /**
     * DB_Operate constructor.
     * @param $host
     * @param $login
     * @param $password
     * @param $database
     */
    function __construct($host, $login, $password, $database)
    {
        $this->db_host = $host;
        $this->db_login = $login;
        $this->db_pass = $password;
        $this->db_name = $database;
    }

    /**
     * ПРоверяет есть ли база, если нет создает
     */
    public function dbChekMake()
    {
        $mysqli = new mysqli($this->db_host, $this->db_login, $this->db_pass);
        if ($mysqli->connect_errno) {
            exit("Не удалось подключиться к MySQL: " . $mysqli->connect_error);
        } else {
            $db = new mysqli(
                $this->db_host,
                $this->db_login,
                $this->db_pass,
                $this->db_name
            );
            if ($db->connect_errno) {
                $mysqli->query("CREATE DATABASE IF NOT EXISTS $this->db_name");
                $mysqli->select_db($this->db_name);
                $mysqli->query(
                    "CREATE TABLE users (
                         id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         username VARCHAR(50),
                         password VARCHAR(50),
                         name VARCHAR(50),
                         age INT (3),
                         about VARCHAR(1000),
                         avatar INT UNSIGNED
                         )
                         DEFAULT CHARSET = utf8 
                         COLLATE=utf8_unicode_ci 
                         AUTO_INCREMENT = 1"
                );
                $mysqli->query(
                    "CREATE TABLE photos (
                        id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                        user_id INT UNSIGNED,
                        file VARCHAR(200)
                    )
                    DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1"
                );
            }
        }
    }
}

