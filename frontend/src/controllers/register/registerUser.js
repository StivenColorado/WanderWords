const formRegister = document.querySelector('#formularioRegistro');
var bcrypt = dcodeIO.bcrypt;
import { API_URL } from "../../../global";

import AWN from "awesome-notifications"

const notifier = new AWN();

formRegister.addEventListener('submit', (e) => {
    e.preventDefault();
    const formularioRegistro = new FormData(e.target);
    formularioRegistro.append('id_rol', 5);

    let text_pass;
    for (const [key, value] of formularioRegistro) {
        if (key === 'password') {
            text_pass = value;
        }
    }

    bcrypt.hash(text_pass, 10, function (err, hash) {
        if (err) {
            console.error("Error al cifrar la contraseña:", err);
        } else {
            formularioRegistro.append('contrasena', hash);

            fetch(`${API_URL}/usuarios/registrarUsuario.php`, {
                method: 'POST',
                body: formularioRegistro
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("La solicitud no fue exitosa");
                    }
                    return response.json();
                })
                .then(data => {
                    notifier.success("Los datos se han insertado correctamente en la base de datos.");
                    console.log(data);
                })
                .catch(error => {
                    notifier.warning("Hubo un problema al procesar la solicitud. Por favor, inténtalo de nuevo.");
                    console.error('Error:', error);
                });
        }
    });
});
