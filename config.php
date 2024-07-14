<?php

$host = "localhost";
$dbname = "qyvwiiui_kk";
$username = "qyvwiiui_admin";
$password = "Notshethekey1.";

try {
    $mysql = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $username, $password);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysql->exec('SET CHARACTER SET UTF8');
    //echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
