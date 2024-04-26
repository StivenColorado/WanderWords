<?php
// Configurar el socket TCP
$socket = stream_socket_server("tcp://localhost:8080", $errno, $errstr);

if (!$socket) {
    echo "$errstr ($errno)\n";
    exit(1);
}

echo "Servidor WebSocket iniciado en el puerto 8080\n";

// Array para almacenar los clientes conectados y sus roles
$clients = [];

// Array para almacenar los chats y los mensajes
$chats = [];

while (true) {
    // Aceptar una nueva conexión
    $clientSocket = stream_socket_accept($socket, -1);

    // Almacenar el cliente y su rol
    $clients[intval($clientSocket)] = 'cliente';

    // Mensaje de confirmación de conexión
    echo "Nuevo cliente conectado\n";

    // Leer mensajes de los clientes
    while ($data = fread($clientSocket, 1024)) {
        // Decodificar el mensaje del cliente
        $decodedData = decodeWebSocketMessage($data);
        
        // Mostrar el mensaje recibido del cliente
        echo "Mensaje recibido del cliente: $decodedData\n";

        // Enviar el mensaje recibido a los clientes relevantes
        send_message($clientSocket, $decodedData, $chats);

        // Mostrar la respuesta del mensaje enviado
        echo "Respuesta enviada al cliente: $decodedData\n";
    }
}

// Función para enviar un mensaje a los clientes relevantes
function send_message($senderSocket, $message, $chats)
{
    foreach ($chats as $socket => $chat) {
        // Enviar el mensaje al cliente relevante
        $encodedMessage = encode_data($message);
        fwrite($socket, $encodedMessage);
    }
}

function encode_data($data)
{
    return $data;
}

// Función para decodificar un mensaje WebSocket
function decodeWebSocketMessage($data)
{
    // Obtener la longitud del mensaje y el opcode
    $length = strlen($data);
    $opcode = ord($data[0]) & 0x0F;

    if ($opcode === 0x1 || $opcode === 0x8) {
        // Si el mensaje tiene longitud cero, no hay datos para decodificar
        if ($length < 2) {
            return '';
        }

        // Obtener el segundo byte, que indica la longitud y el formato de la carga útil
        $secondByte = ord($data[1]);
        $payloadLength = $secondByte & 0x7F;
        $isMasked = ($secondByte >> 7) & 0x01;

        if ($isMasked) {
            $payloadStartIndex = ($payloadLength <= 125) ? 6 : 8;

            $maskingKeyIndex = $payloadStartIndex - 4;

            // Extraer la máscara de enmascaramiento del mensaje
            $maskingKey = substr($data, $maskingKeyIndex, 4);

            // Desenmascarar la carga útil
            $payload = substr($data, $payloadStartIndex);
            $decodedPayload = '';
            for ($i = 0; $i < strlen($payload); $i++) {
                $decodedPayload .= $payload[$i] ^ $maskingKey[$i % 4];
            }
        } else {
            $decodedPayload = substr($data, 2);
        }

        return $decodedPayload;
    }
    return '';
}
