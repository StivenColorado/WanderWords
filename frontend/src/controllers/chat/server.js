// Obtener referencia al input y al botón de enviar
const inputMessage = document.querySelector("#message-input");
const sendButton = document.querySelector("#send-button");

// Función para enviar un mensaje al servidor PHP
const sendMessageToServer = (message) => {
    // Crear una instancia de WebSocket y conectar al servidor PHP
    const socket = new WebSocket("ws://localhost:8080");

    // Evento cuando la conexión WebSocket se abre
    socket.onopen = () => {
        // Enviar el mensaje al servidor
        socket.send(message);
    };

    // Evento cuando se recibe un mensaje del servidor
    socket.onmessage = (event) => {
        // Procesar el mensaje recibido del servidor si es necesario
        console.log("Mensaje recibido del servidor:", event.data);
    };

    // Evento cuando se produce un error en la conexión WebSocket
    socket.onerror = (error) => {
        console.error("Error en la conexión WebSocket:", error);
    };

    // Evento cuando la conexión WebSocket se cierra
    socket.onclose = () => {
        console.log("Conexión WebSocket cerrada");
    };
};

// Evento cuando se presiona el botón de enviar
sendButton.addEventListener("click", () => {
    // Obtener el valor del mensaje del input
    const message = inputMessage.value.trim();

    // Verificar si el mensaje no está vacío
    if (message !== "") {
        // Enviar el mensaje al servidor PHP
        sendMessageToServer(message);

        // Limpiar el input después de enviar el mensaje
        inputMessage.value = "";
    }
});
