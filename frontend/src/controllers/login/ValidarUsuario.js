const formLogin = document.querySelector('#formLogin');
import { API_URL, ROUTES } from "../../../global";
import AWN from "awesome-notifications";

const notifier = new AWN();

formLogin.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const correo = formData.get('correo');
    const contrasena = formData.get('contrasena');

    // Enviar el correo y la contraseña al servidor
    fetch(`${API_URL}/usuarios/ValidarUsuario.php`, {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("La solicitud no fue exitosa");
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 200) {
                // Inicio de sesión exitoso
                notifier.success("Inicio de sesión exitoso.");
                // console.log(data.token);
                localStorage.setItem('token', data.token);

                setTimeout(() => {
                    window.location.href = ROUTES.home;
                }, 1500);
            } else {
                notifier.warning(data.message);
            }
        })
        .catch(error => {
            notifier.warning("Hubo un problema al procesar la solicitud. Por favor, inténtalo de nuevo.");
            console.error('Error:', error);
        });
});
