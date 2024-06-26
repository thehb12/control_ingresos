import { sweetalert2 } from './util';

const formRegister = document.getElementById('registrationForm');

formRegister.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(formRegister);
    try {
        const resp = await fetch('/register', {
            method: 'POST',
            body: formData
        });

        if (resp.ok) {
            const result = await resp.json();
            if (result.mensaje) {
                sweetalert2({
                    title: 'Éxito',
                    icon: 'success',
                    text: result.mensaje,
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    location.href = '/login'; // Redirigir al inicio de sesión
                });
            }
        } else {
            const error = await resp.json();
            sweetalert2({
                title: 'Error',
                icon: 'error',
                text: error.mensaje,
                timer: 5000,
                showConfirmButton: false
            });
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        sweetalert2({
            title: 'Error',
            icon: 'error',
            text: 'Hubo un problema al procesar su solicitud',
            timer: 5000,
            showConfirmButton: false
        });
    }
});