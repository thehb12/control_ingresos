
    let form_change_password = document.querySelector('#form-change-password');
    let new_Password = document.querySelector('#newPassword')
    let renew_Password = document.querySelector('#renewPassword')
    let error_new_password = document.querySelector('#error_new_password')

renew_Password.addEventListener('input', (e) => {
    console.log(e.target.value)
    if (e.target.value === new_Password.value) {
        renew_Password.setCustomValidity('')
    }else {

        renew_Password.setCustomValidity('La contraseña no coinciden')
    }
})

form_change_password.addEventListener('submit', (e) => {
    e.preventDefault();
    if (!form_change_password.checkValidity()) {
        e.stopPropagation()
       return false
    }
//enviar data al server
})














