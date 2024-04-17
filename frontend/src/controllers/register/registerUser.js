const formRegister = document.querySelector('#formularioRegistro');
var bcrypt = dcodeIO.bcrypt;

formRegister.addEventListener('submit', (e) => {
    e.preventDefault();
    const fechaActual = new Date();

    const año = fechaActual.getFullYear();
    const mes = ('0' + (fechaActual.getMonth() + 1)).slice(-2);
    const dia = ('0' + fechaActual.getDate()).slice(-2);

    const fechaFormateada = `${año}-${mes}-${dia}`;
    const formularioRegistro = new FormData(e.target);
    // agregar datos al formulario
    formularioRegistro.append('fecha', fechaFormateada);
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
            // console.log("Contraseña cifrada:", hash);
            formularioRegistro.append('contrasena', hash);
            for (const [key, value] of formularioRegistro) {
                console.log(key, value);
            }

            fetch('http://localhost/WanderWords/backend/usuarios/registrarUsuario.php', {
    method: 'POST',
                body: formularioRegistro
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La petición ha fallado');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});