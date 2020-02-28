<?php
require 'connect.php';

$ip = $_SERVER["REMOTE_ADDR"];
$Browser  = $_SERVER['HTTP_USER_AGENT'];

if(preg_match('/bot|Discord|robot|curl|spider|crawler|^$/i', $Browser)) {
    exit();
} else {

$sql = $pdo->exec("INSERT INTO ips (ip) VALUES ('$ip')");

if($sql){
echo "<script>alert("Thanks alot. your ip address is: $ip");</script>";
}
}
