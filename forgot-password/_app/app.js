/**
 * Muestra un Spinner mientras Carga.
 *
 * require agregar con php la funcion verCargando()
 * @param id
 * @param show
 */
function verCargando(id, show = true) {
    let selector = document.querySelector('#' + id);
    if (selector){
        let spinner = document.querySelector("#" + id + " .verCargando");
        if (spinner){
            if (show){
                selector.classList.add('opacity-25');
                spinner.classList.remove('d-none');
            }else {
                selector.classList.remove('opacity-25');
                spinner.classList.add('d-none');
            }
        }else {
            console.log('Falta verCargando() dentro del elemento #' + id)
            alert('verCargando(): Falta Elemento, ver mas detalles en consola.');
        }
    }else{
        console.log("Selector no encontrado: \n #" + id);
        alert('verCargando(): Falta Elemento, ver mas detalles en consola.');
    }

}

/**
 * Desabilita todos los botones con el selector indicado.
 *
 * @param selector
 */
function disabledButtons(selector = ".buttons_disabled") {
    const buttons = document.querySelectorAll(selector);
    buttons.forEach(boton => {
        boton.disabled = true;
    });
}

/**
 * Fetch: Peticiones Asíncronas.
 *
 * realizar peticiones HTTP asíncronas utilizando promesas.
 * @param options
 * @param callback
 */
function ajaxRequest(options, callback) {

    //Valores por defecto
    let url = options.url ? options.url : "/";
    let method = options.method ? options.method : "POST";
    let data = options.data ? options.data : null;
    let form = options.form ? options.form : null;
    let type = options.response ? options.response : "json";

    let withData;

    if (data !== null) {
        if (form !== null) {
            withData = new FormData(form);
        } else {
            withData = new FormData();
        }
        Object.entries(data).forEach(([key, value]) => {
            withData.append(key, value);
        });
    } else {
        withData = new FormData(form);
    }

    const option = {
        method: method,
        body: withData
    }

    if (type === "json") {

        fetch(url, option)
            .then(response => response.json())
            .then(data => {
                //toastBootstrap(data);
                callback(data);
            })
            .catch(error => {
                // Si hay un error en la petición, lo manejamos aqui
                /*toastBootstrap({
                    type: "error",
                    message: error
                });*/
            });

    } else {

        fetch(url, option)
            .then(response => response.text())
            .then(data => callback(data))
            .catch(error => {
                // Si hay un error en la petición, lo manejamos aqui
                /*toastBootstrap({
                    type: "error",
                    message: error
                })*/
            });

    }


    /*
    * Ejemplo de Uso:
    *-------------------------------------------------------------------
    *
        *
        *
        *

        const form = document.querySelector("#form_prueba");
        const btnGuardar = document.querySelector("#btn_guardar");
        const btnCancelar = document.querySelector("#btn_calcelar");

        form.addEventListener('submit', event => {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
            if (form.checkValidity()){
                btnGuardar.disabled = "disabled"
                verCargando("hola");
                let url = "<?= route('prueba') ?>";
                ajaxRequest({ url: url, form: form }, function (data) {
                    //acciones extras
                    btnGuardar.removeAttribute('disabled');
                    verCargando('hola', false);
                });
            }
        });


    *
    *-------------------------------------------------------------------
    * */

}


// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()

console.log('app.js');
