import Swal from 'sweetalert2/dist/sweetalert2.js';
function sweetalert2(server) {
    setTimeout(() => Swal.fire(server), 1000);
}

const sweetalertnoserver = (mensajesError) => {
    sweetalert2({
        title: "Error",
        icon: 'error',
        html: mensajesError,
        position: 'center',
        timer: 5000,
        showConfirmButton: false
    });
}
// CODIGO PARA CAMBIAR CLAVE
let form_change_password = document.querySelector('#form-change-password');
let new_Password = document.querySelector('#newPassword');
let renew_Password = document.querySelector('#renewPassword');
let timeout = null;

renew_Password.addEventListener('input', (e) => {
    clearTimeout(timeout);// Limpiar el timeout anterior si el usuario sigue escribiendo
    timeout = setTimeout(() => {  // Establecer un nuevo timeout
        if (e.target.value !== '' && e.target.value !== new_Password.value) {
            let mensajesError = 'Las contraseñas no coinciden';
            sweetalertnoserver(mensajesError);
            renew_Password.setCustomValidity(mensajesError);
        } else {
            renew_Password.setCustomValidity('');
        }
    }, 600);
});

// Envío del formulario
form_change_password.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (new_Password.value === renew_Password.value) {
        // Enviar data al servidor
        let formdata = new FormData(form_change_password);
        try {
            let resp = await fetch('/profile/change/password', {
                method: 'POST',
                body: formdata
            });
            if (resp.ok) {
                let result = await resp.json();
                Swal.fire({
                    title: "Éxito",
                    icon: 'success',
                    html: 'El cambio de contraseña se realizó correctamente',
                    position: 'center',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    location.href = '/logout';
                });
            } else {
                console.log(resp.statusText);
            }
        } catch (error) {
            console.log(error);
        }
    } else {
        let mensajesError = 'Las contraseñas no coinciden';
        sweetalertnoserver(mensajesError);  // Mostrar la alerta
        renew_Password.setCustomValidity(mensajesError);
        form_change_password.reportValidity();  // Mostrar la validez del formulario
    }
})

//CODIGO PARA CAMBIAR DATOS DEL PERFIL 
const form_edit_profile = document.querySelector('#edit-profile-form');
const fullName = document.querySelector('#fullName');
const company = document.querySelector('#company');
const job = document.querySelector('#Job');
const email = document.querySelector('#Email');
const error_message = document.querySelector('#error_message');

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
}

fullName.addEventListener('input', () => {
    if (fullName.value.trim() === '') {
        let mensajesError = 'El nombre completo es obligatorio'
        sweetalertnoserver(mensajesError);
        fullName.setCustomValidity(mensajesError);
    } else {
        fullName.setCustomValidity('');
    }
});

company.addEventListener('input', () => {
    if (company.value.trim() === '') {
        let mensajesError = 'El nombre de la empresa obligatorio'
        sweetalertnoserver(mensajesError);
        company.setCustomValidity(mensajesError);
    } else {
        company.setCustomValidity('');
    }
});

job.addEventListener('input', () => {
    if (job.value.trim() === '') {
        let mensajesError = 'El cargo es obligatorio'
        sweetalertnoserver(mensajesError);
        job.setCustomValidity(mensajesError);
    } else {
        job.setCustomValidity('');
    }
});

email.addEventListener('input', () => {
    if (email.value.trim() === '') {
        let mensajesError = 'El email es obligatoria'
        sweetalertnoserver(mensajesError);
        email.setCustomValidity(mensajesError);
    } else if (!isValidEmail(email.value)) {
        email.setCustomValidity(mensajesError);
    } else {
        email.setCustomValidity('');
    }
});

form_edit_profile.addEventListener('submit', async (e) => {
    const invalidElements = form_edit_profile.querySelectorAll(':invalid');
    const mensajesError = Array.from(invalidElements).map(input => input.validationMessage);
    console.log(invalidElements)
    e.preventDefault();

    if (!form_edit_profile.checkValidity()) {


        form_edit_profile.classList.add('was-validated');
        e.stopPropagation();
        return false;
    }

    const formdata = new FormData(form_edit_profile);
    try {
        const resp = await fetch('/profile/change/profile', {
            method: 'POST',
            body: formdata
        });

        if (resp.ok) {
            const result = await resp.json();
            if (result.message) {
                console.log(result.message);
                sweetalert2(result.sweetalert);

            }
        } else {
            console.log(resp.statusText);

        }
    } catch (error) {
        console.log(error);
        sweetalert2(resul.sweetalert);
    }
})






















