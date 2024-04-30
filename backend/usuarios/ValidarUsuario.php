<?php
//en este codigo como puedo proteger las peticiones que sean de url desconocidas?
require_once "../conexion.php";
require_once "../cors.php";
require_once "../vendor/autoload.php"; // Incluye el archivo autoload.php de Composer

use Firebase\JWT\JWT;

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST["correo"]) &&
        isset($_POST["contrasena"])
    ) {
        $correo = $_POST["correo"];
        $contrasena = $_POST["contrasena"];
        // Verificar si el correo y la contraseña existen en la base de datos
        $sql_check = "SELECT * FROM clientes WHERE correo = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $correo);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $row = $result_check->fetch_assoc();
            $hashed_password = $row["contrasena"];

            // Verificar si la contraseña es correcta
            if (password_verify($contrasena, $hashed_password)) {
                $expirationTime = time() + (60 * 60);

                // Generar el token JWT
                // Define el payload y la clave secreta
                $payload = array(
                    "user_id" => $row['id_cliente'],
                    "correo" => $correo,
                    "exp" => $expirationTime 
                );
                $secret = "123";

                // Codifica el token JWT usando el payload y la clave secreta
                $token = JWT::encode($payload, $secret, 'HS256');


                $response["status"] = 200;
                $response["message"] = "Inicio de sesión exitoso.";
                $response["token"] = $token;
            } else {
                $response["status"] = 401;
                $response["message"] = "La contraseña ingresada es incorrecta.";
            }
        } else {
            $response["status"] = 404;
            $response["message"] = "El correo electrónico ingresado no existe en la base de datos.";
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
