<?php
//connect.php



define('MYSQL_USER', 'tom');


define('MYSQL_PASSWORD', 'OE9DsrUBSsyJG1ADUgr5qft04Y61nSx3');


define('MYSQL_HOST', '88.99.155.173:3306');


define('MYSQL_DATABASE', 'website');

$pdoOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);

$pdo = new PDO(
    "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
    MYSQL_USER, //Username
    MYSQL_PASSWORD, //Password
    $pdoOptions //Options
);
?>