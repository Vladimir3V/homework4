<?php
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 09.09.16
 * Time: 6:22
 */

require_once 'Connection.php';

$a = new DBOperate(
    $GLOBALS['host'],
    $GLOBALS['login'],
    $GLOBALS['password'],
    $GLOBALS['db_name']
);
$a->dbChekMake();