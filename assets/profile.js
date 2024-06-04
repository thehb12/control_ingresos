//CODIGO PARA CAMBIAR CLAVE
let form_change_password = document.querySelector('#form-change-password');
let new_Password = document.querySelector('#newPassword')
let renew_Password = document.querySelector('#renewPassword')
let error_new_password = document.querySelector('#error_new_password')

renew_Password.addEventListener('input', (e) => {
    console.log(e.target.value)
    if (e.target.value === new_Password.value) {
        renew_Password.setCustomValidity('')
    } else {

        renew_Password.setCustomValidity('La contraseña no coinciden')
    }
})

form_change_password.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!form_change_password.checkValidity()) {
        e.stopPropagation()
        return false
    }
    //enviar data al server

    let formdata = new FormData(form_change_password)
    try {
        let resp = await fetch('/profile/change/password', {
            method: 'POST',
            body: formdata
        })
        if (resp.ok) {
            let result = resp.json()
            console.log(result.message)
            error_message.textContent = result.message;
            error_message.style.color = result.message.includes('Error') ? 'red' : 'green';
        } else {
            console.log(resp.statusText)
            error_message.textContent = 'Error al enviar el formulario';
            error_message.style.color = 'red';
        }
    } catch (error) {
        console.log(error)
        error_message.textContent = 'Error al enviar el formulario';
        error_message.style.color = 'red';

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
        fullName.setCustomValidity('El nombre completo es obligatorio');
    } else {
        fullName.setCustomValidity('');
    }
});

company.addEventListener('input', () => {
    if (company.value.trim() === '') {
        company.setCustomValidity('La empresa es obligatoria');
    } else {
        company.setCustomValidity('');
    }
});

job.addEventListener('input', () => {
    if (job.value.trim() === '') {
        job.setCustomValidity('El cargo es obligatorio');
    } else {
        job.setCustomValidity('');
    }
});

email.addEventListener('input', () => {
    if (email.value.trim() === '') {
        email.setCustomValidity('El email es obligatorio');
    } else if (!isValidEmail(email.value)) {
        email.setCustomValidity('El email no es válido');
    } else {
        email.setCustomValidity('');
    }
});

form_edit_profile.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!form_edit_profile.checkValidity()) {
        e.stopPropagation();
        form_edit_profile.classList.add('was-validated');
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

                error_message.textContent = result.message;
                error_message.style.color = result.message.includes('Error') ? 'red' : 'green';
            }
        } else {
            console.log(resp.statusText);
            error_message.textContent = 'Error al enviar el formulario';
            error_message.style.color = 'red';
        }
    } catch (error) {
        console.log(error);
        error_message.textContent = 'Error al enviar el formulario';
        error_message.style.color = 'red';
    }
});





















