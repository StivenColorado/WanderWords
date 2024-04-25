// controllers/verificarSesion.js
import { API_URL } from "../../global";

export async function verificarSesion() {
    try {
        const response = await fetch(`${API_URL}/usuarios/verificarSesion.php`);
        if (!response.ok) {
            throw new Error("La solicitud no fue exitosa");
        }
        
        const data = await response.json(); // Convertir la respuesta a JSON
        const sessionActive = data.sessionActive; // Obtener el estado de la sesión del JSON
        console.log(sessionActive)
        return sessionActive;
    } catch (error) {
        console.error('Error al verificar la sesión:', error);
        return false;
    }
}
