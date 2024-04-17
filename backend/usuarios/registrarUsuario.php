<?php
require_once "../conexion.php";

// Definir el arreglo de respuesta
$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se recibieron los datos esperados
    if (
        isset($_POST["nombre"]) &&
        isset($_POST["apellido"]) &&
        isset($_POST["edad"]) &&
        isset($_POST["correo"]) &&
        isset($_POST["password"]) &&
        isset($_POST["id_rol"])
    ) {
        // Recibir los datos del formulario
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $edad = $_POST["edad"];
        $correo = $_POST["correo"];
        $password = $_POST["password"];
        $id_rol = $_POST["id_rol"];

        // Hashear la contraseña antes de almacenarla en la base de datos
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta SQL para insertar los datos en la tabla clientes
        $sql = "INSERT INTO clientes (nombre, apellido, edad, correo, contrasena, id_rol) VALUES (?, ?, ?, ?, ?, ?)";

        // Preparar la declaración
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        $stmt->bind_param("ssissi", $nombre, $apellido, $edad, $correo, $hashed_password, $id_rol);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            // Establecer el estado de la respuesta como éxito
            $response["success"] = true;
            $response["message"] = "Los datos se han insertado correctamente en la base de datos.";
        } else {
            // Establecer el estado de la respuesta como error
            $response["success"] = false;
            $response["message"] = "Error al insertar los datos en la base de datos: " . $conn->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        // Establecer el estado de la respuesta como error
        $response["success"] = false;
        $response["message"] = "No se recibieron todos los datos esperados.";
    }
} else {
    // Establecer el estado de la respuesta como error
    $response["success"] = false;
    $response["message"] = "La solicitud debe ser de tipo POST.";
}

// Enviar la respuesta como JSON
http_response_code(200); // Establecer el código de estado HTTP como 200 (OK)
header('Content-Type: application/json'); // Establecer la cabecera Content-Type como JSON
echo json_encode($response); // Convertir el arreglo de respuesta a JSON y enviarlo
?>
