<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once '../vendor/autoload.php';
require_once '../cors.php';

try {
    // Leer la solicitud POST y obtener el token JWT del cuerpo de la solicitud
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);
    $token = $input['token'];

    // Clave secreta utilizada para firmar y verificar el token (asegúrate de usar la misma clave que usaste para generar el token)
    $secret = "123";

    // Decodificar el token para obtener su contenido
    $decoded = JWT::decode($token, new Key('123', 'HS256'));
    // Verificar si el token es válido y contiene la información esperada
    if ($decoded->user_id) {
        // El token es válido y contiene el ID del usuario
        // Puedes realizar acciones adicionales aquí si lo deseas
        echo json_encode(["sessionActive" => true]);
    } else {
        // El token no es válido o no contiene la información esperada
        echo json_encode(["sessionActive" => false]);
    }
} catch (Exception $e) {
    // Ocurrió un error al decodificar el token
    echo json_encode(["sessionActive" => false]);
}
