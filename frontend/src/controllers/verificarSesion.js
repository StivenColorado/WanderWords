import { API_URL } from "../../global";

export function verificarSesion() {
  // Obtener el token JWT del localStorage
  const token = localStorage.getItem('token');

  // Verificar si el token existe
  if (!token) {
    console.error('Token JWT no encontrado en el localStorage');
    return;
  }

  // Crear el objeto de datos a enviar en la solicitud POST
  const data = {
    token: token // Agregar el token JWT al objeto de datos
  };

  return fetch(`${API_URL}/usuarios/verificarSesion.php`, {
    method: "POST", // Cambiar el método de la solicitud a POST
    headers: {
      'Content-Type': 'application/json' // Establecer el tipo de contenido como JSON
    },
    body: JSON.stringify(data), // Convertir el objeto de datos a JSON y enviarlo en el cuerpo de la solicitud
    credentials: 'include' // Incluir cookies y datos de autenticación
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Sesión no válida');
      }
      return response.json();
    })
    .then(data => {
      const sessionActive = data.sessionActive;
      if (sessionActive) {
        console.log("La sesión está activa");
      } else {
        console.log("La sesión no está activa");
        // Aquí puedes redirigir al usuario a la página de inicio de sesión
      }
    })
    .catch(error => {
      console.error("Error al verificar la sesión:", error);
    });
}
