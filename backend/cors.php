<?php
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if ($origin === 'http://localhost:4321') {
    // Permitir solicitudes desde el origen específico
    header("Access-Control-Allow-Origin: $origin");

    // Permitir el intercambio de cookies y otros datos de autenticación
    header("Access-Control-Allow-Credentials: true");

    // Permitir los métodos HTTP especificados
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

    // Permitir los encabezados personalizados y estándar
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}

// Finalizar la ejecución de scripts si la solicitud es de tipo OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
