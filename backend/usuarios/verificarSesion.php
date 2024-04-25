<?php
require_once('../cors.php');
session_start();

$response = array();
$response['sessionActive'] = isset($_SESSION['usuario_id']); // Verificar si existe la sesión

header('Content-Type: application/json');
echo json_encode($response);
?>
