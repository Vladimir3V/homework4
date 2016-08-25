<?php
/** @var TYPE_NAME $server */

$db_hostname = "localhost";
$db_database = "users";
$db_username = "admin";
$db_password = "";

$connection = new mysqli(
    $db_hostname,
    $db_username,
    $db_password,
    $db_database
);


print_r($connection);
echo ($connection>connect_error);

if ($connection>connect_error) die($connection->connect_error);

echo (connect_error);