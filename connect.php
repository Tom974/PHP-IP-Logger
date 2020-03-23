<?php


define('MYSQL_USER', 'mysql-username');


define('MYSQL_PASSWORD', 'your-database-password');


define('MYSQL_HOST', 'your-database-host:port');


define('MYSQL_DATABASE', 'your-database');

$pdoOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);

$pdo = new PDO(
    "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
    MYSQL_USER, 
    MYSQL_PASSWORD, 
    $pdoOptions 
);
?>
