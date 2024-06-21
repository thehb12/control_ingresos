import Swal from "sweetalert2"

/**
   * Easy selector helper function
   */
export const select = (el, all = false) => {
    el = el.trim()
    if (all) {
        return [...document.querySelectorAll(el)]
    } else {
        return document.querySelector(el)
    }
}

/**
  * Easy event listener function
  */
export const on = (type, el, listener, all = false) => {
    if (all) {
        select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
        select(el, all).addEventListener(type, listener)
    }
}

  /**
   * Easy on scroll event listener 
   */
 export const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

export const sweetalert2 = () => {
    Swal.fire({
        title: 'Test Alert',
        text: 'test',
        icon: 'success',
        timer: 1000
    });
}


export const sweetalert2Server = (server={
    title: 'Test Alert',
    text: 'test',
    icon: 'success',
    timer: 1000
}) => {
    Swal.fire(server);
}


export const async_fecth_form_data = async (rute, formData, method = 'POST') => {
    try {
        
        const response = await fetch(rute, {
            method: method,
            body: formData
        });

        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        return { result: await response.json(), error: "" }

    } catch (error) {
        return { result: {}, error: error.message }
    }
}