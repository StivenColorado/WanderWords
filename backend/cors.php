<?php
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if ($origin === 'http://localhost:4321') {
    header("Access-Control-Allow-Origin: $origin");

    header("Access-Control-Allow-Credentials: true");

    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
