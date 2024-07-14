<?php
// save_photo.php

// Obtener los datos de la imagen de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);
$image = $data['image'];
$count = $data['count'];

// Decodificar la imagen de base64
$image = str_replace('data:image/png;base64,', '', $image);
$image = str_replace(' ', '+', $image);
$imageData = base64_decode($image);

// Generar un nombre de archivo único para cada foto
$filename = 'photo_' . uniqid() . '_' . $count . '.png';

// Especificar la ruta donde se guardará la imagen
$filepath = 'uploads/' . $filename;

// Guardar la imagen en el servidor
file_put_contents($filepath, $imageData);

// Devolver una respuesta JSON
echo json_encode(['success' => true, 'filename' => $filename]);
