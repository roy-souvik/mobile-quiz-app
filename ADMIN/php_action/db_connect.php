<?php

define('DB_SERVER', 'localhost');
define('DB_NAME', 'quiz_competition');

define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'password');
// define('DB_USERNAME', 'ntss');
// define('DB_PASSWORD', 'eerning');

$connect = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($connect->connect_error || !$link) {
    die("Connection Failed : " . $connect->connect_error);
}
