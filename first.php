<?php
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 01.09.16
 * Time: 23:44
 */
session_start();
require_once 'db_operate.php';
require_once 'check_user_data.php';
require_once 'add_user_info.php';

$a = new DB_Operate('localhost', 'root', 'root', 'uzzerz');
$a->db_chek_make();


if (empty($_POST)) {
    exit('No data');
} else {
    if (isset($_POST['reg_login'])) {
        $user_login     = $_POST['reg_login'];
        $user_password  = $_POST['reg_password'];
        $user_password2 = $_POST['reg_password2'];

        $b = new Add_User_Info();
        $b->add_login_password($user_login, $user_password, $user_password2);

    } elseif (isset($_POST['login'])) {
        $user_login     = $_POST['login'];
        $user_password  = $_POST['password'];

        $b = new Check_User_Data();
        $b->check_login_password($user_login, $user_password);
    }
}

?>