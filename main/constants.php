<?php
//Defines the constants
/*
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Jagermeister42');
define('DB_NAME', 'scan as you shop');
*/
$pdo = new PDO('mysql:dbname=scan as you shop;host=localhost', 'root', 'Jagermeister42', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
?>
