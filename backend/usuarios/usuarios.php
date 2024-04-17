<?php
require_once "../conexion.php";

$sql = "SELECT * FROM clientes";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $resultados_array = array();

    while ($fila = $resultado->fetch_assoc()) {
        $resultados_array[] = $fila;
    }

    $json_resultados = json_encode($resultados_array);

    echo $json_resultados;
} else {
    echo json_encode(array('mensaje' => 'No se encontraron resultados'));
}

// Cerrar la conexión
$conn->close();
?>
