<?php
require_once "../conexion.php";
require_once "../cors.php";

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST["nombre"]) &&
        isset($_POST["apellido"]) &&
        isset($_POST["edad"]) &&
        isset($_POST["correo"]) &&
        isset($_POST["password"]) &&
        isset($_POST["id_rol"])
    ) {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $edad = $_POST["edad"];
        $correo = $_POST["correo"];
        $password = $_POST["password"];
        $id_rol = $_POST["id_rol"];

        // Obtener la fecha actual
        $fecha_registro = date('Y-m-d');

        $sql_check = "SELECT COUNT(*) as count FROM clientes WHERE correo = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $correo);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();

        if ($row_check['count'] > 0) {
            $response["status"] = 400;
            $response["message"] = "El correo electrónico ya está registrado.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO clientes (nombre, apellido, edad, correo, contrasena, id_rol, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssissis", $nombre, $apellido, $edad, $correo, $hashed_password, $id_rol, $fecha_registro);

            if ($stmt_insert->execute()) {
                $response["status"] = 200;
                $response["message"] = "Los datos se han insertado correctamente en la base de datos.";
            } else {
                // Error al insertar el nuevo registro
                $response["status"] = 500;
                $response["message"] = "Error al insertar los datos en la base de datos: " . $conn->error;
            }

            $stmt_insert->close();
        }

        $stmt_check->close();
    } else {
        $response["status"] = 400;
        $response["message"] = "No se recibieron todos los datos esperados.";
    }
} else {
    $response["status"] = 405;
    $response["message"] = "La solicitud debe ser de tipo POST.";
}

// Establecer el código de respuesta HTTP
http_response_code($response["status"]);

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Enviar la respuesta JSON al cliente
echo json_encode($response);
?>
