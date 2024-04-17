<?php
// Configuración de la conexión a la base de datos
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "viajes_db"; 

// Crear la conexión
$conn = new mysqli($host, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
