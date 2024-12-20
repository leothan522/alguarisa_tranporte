const htmlToast = '<div class="toast-container position-fixed p-3 top-0 start-50 translate-middle-x mt-5">' +
    '<div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"> ' +
    '<div id="liveToastClass" class="toast-header"> ' +
    '<span id="liveToastIcon" class="ms-2 me-3"> ' +
    '<i class="fa-regular fa-circle-exclamation"></i> ' +
    '</span> ' +
    '<strong class="me-auto" id="liveToastTitle">¡Éxito!</strong> ' +
    '<small class="d-none" id="liveToastSubTitle">11 mins ago</small> ' +
    '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> ' +
    '</div> ' +
    '<div id="liveToastLightColor" class="toast-body">' +
    '<div id="liveToastMessage">Hello, world! This is a toast message.</div>' +
    '</div> ' +
    '</div>' +
    '</div>';

const htmlConfirm = '<div class="toast-container position-fixed p-3 top-50 start-50 translate-middle">' +
    '<div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">' +
    '<div id="liveToastClass" class="toast-header"> ' +
    '<span id="liveToastIcon" class="ms-2 me-3"> ' +
    '<i class="fa-solid fa-question ms-2 me-2"></i> ' +
    '</span> ' +
    '<strong class="me-auto"><span id="liveToastTitle">Estas seguro</span></strong> ' +
    '<small class="d-none" id="liveToastSubTitle">11 mins ago</small> ' +
    '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> ' +
    '</div> ' +
    '<div id="liveToastLightColor" class="toast-body"> ' +
    '<div id="liveToastMessage">¡No podrás revertir esto!</div>' +
    '<div class="d-flex mt-2 pt-2 border-top justify-content-between"> ' +
    '<button id="liveToastBtnSI" type="button" class="btn btn-primary btn-sm" data-bs-dismiss="toast">¡Sí, bórralo!</button> ' +
    '<button id="liveToastBtnNO" type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Cancelar</button> ' +
    '</div> ' +
    '</div> ' +
    '</div>' +
    '</div>';

const colores = {
    success: "text-bg-success",
    info: "text-bg-info",
    error: "text-bg-danger",
    warning: "text-bg-warning"
};

const lightColor = {
    success: "bg-success-subtle",
    info: "bg-info-subtle",
    error: "bg-danger-subtle",
    warning: "bg-warning-subtle"
};

const iconos = {
    success: '<i class="fa-solid fa-check"></i>',
    info: '<i class="fa-solid fa-info"></i>',
    error: '<i class="fa-solid fa-circle-exclamation"></i>',
    warning: '<i class="fa-solid fa-triangle-exclamation"></i>'
};

const titulos = {
    success: "¡Éxito!",
    info: "Información",
    error: "¡Error!",
    warning: "¡Alerta!"
};


/**
 * Envía notificaciones del sistema con un toast.
 *
 * Usando Toasts de Bootstrap 5
 * @param options
 */
function toastBootstrap(options = {}) {

    if (document.querySelector('#toastBootstrap')){

        document.querySelector('#toastBootstrap').innerHTML = htmlToast;

        const liveToastClass = document.querySelector('#liveToastClass');
        const liveToastLightColor = document.querySelector('#liveToastLightColor');
        const liveToastIcon = document.querySelector('#liveToastIcon');
        const liveToastTitle = document.querySelector('#liveToastTitle');
        const liveToastSubTitle = document.querySelector('#liveToastSubTitle');
        const liveToastMessage = document.querySelector('#liveToastMessage');

        const type = options.type ? options.type : 'success';
        const color = options.color ? options.color : colores[type];
        const bgcolor = options.lightcolor ? options.lightcolor : lightColor[type];
        const icon = options.icon ? options.icon : iconos[type];
        const title = options.title ? options.title : titulos[type];
        const subtitle = options.subtitle ? options.subtitle : "";
        const message = options.message ? options.message : "Datos Guardados.";
        const noToast = options.noToast ? options.noToast : false;

        liveToastClass.classList.add(color);
        liveToastLightColor.classList.add(bgcolor);
        liveToastIcon.innerHTML = icon;
        liveToastTitle.textContent = title;
        liveToastSubTitle.textContent = subtitle;
        liveToastMessage.innerHTML = message;

        const toastLive = document.getElementById('liveToast');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);

        if (!noToast) {
            toastBootstrap.show();
        }

    }else{
        console.log('Falta incluir en el html: \n <!-- Toast Bootstrap con JS --> \n <div id="toastBootstrap"> \n \t <!-- JS --> \n </div>');
        alert('Toast Bootstrap: Falta Elemento, ver mas detalles en consola.');
    }

}

/**
 * Envía notificaciones del sistema con un toast Confirm.
 *
 * Usando Toasts de Bootstrap 5
 * @param options
 * @param callback
 */
function confirmToastBootstrap(callback, options = {}) {

    if (document.querySelector('#toastBootstrap')){

        document.querySelector('#toastBootstrap').innerHTML = htmlConfirm;

        const liveToastClass = document.querySelector('#liveToastClass');
        const liveToastLightColor = document.querySelector('#liveToastLightColor');
        const liveToastIcon = document.querySelector('#liveToastIcon');
        const liveToastTitle = document.querySelector('#liveToastTitle');
        const liveToastSubTitle = document.querySelector('#liveToastSubTitle');
        const liveToastMessage = document.querySelector('#liveToastMessage');
        const liveToastBtnSI = document.querySelector('#liveToastBtnSI');
        const liveToastBtnNO = document.querySelector('#liveToastBtnNO');

        const type = options.type ? options.type : 'warning';
        const color = options.color ? options.color : colores[type];
        const bgcolor = options.lightcolor ? options.lightcolor : lightColor[type];
        const icon = options.icon ? options.icon : iconos[type];
        const title = options.title ? "¿" + options.title + "?" : "¿Estas seguro?";
        const subtitle = options.subtitle ? options.subtitle : "";
        const message = options.message ? options.message : "¡No podrás revertir esto!";
        const btnSi = options.button ? options.button : "¡Sí, bórralo!";
        const btnNo = options.cancel ? options.cancel : "Cancelar";
        const is_callback = options.callback ? ""+ options.callback +"" : "isCallback";

        liveToastClass.classList.add(color);
        liveToastLightColor.classList.add(bgcolor);
        liveToastIcon.innerHTML = icon;
        liveToastTitle.textContent = title;
        liveToastSubTitle.textContent = subtitle;
        liveToastMessage.innerHTML = message;
        liveToastBtnSI.textContent = btnSi;
        liveToastBtnNO.textContent = btnNo;

        const toastLive = document.getElementById('liveToast');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);

        if (is_callback === "isCallback"){
            liveToastBtnSI.addEventListener('click', event => {
                callback();
            });
        } else {
            liveToastBtnSI.classList.add('d-none');
            liveToastBtnNO.textContent = options.cancel ? options.cancel : "OK";
            liveToastTitle.textContent = options.title ? options.title : titulos[type];
        }

        toastBootstrap.show();

    }else{
        console.log('Falta incluir en el html: \n <!-- Toast Bootstrap con JS --> \n <div id="toastBootstrap"> \n \t <!-- JS --> \n </div>');
        alert('Toast Bootstrap: Falta Elemento, ver mas detalles en consola.');
    }

}

/**
 * Envía notificaciones HTML y in boton OK
 *
 * Usando Toasts de Bootstrap 5
 * @param options
 */
function htmlToasBootstrap(options = {}) {
    const html = '<div class="row">' +
        '<div class="col-12 mt-3 mb-3 text-center">' +
        '<i class="fa-regular fa-lightbulb fa-4x text-warning"></i>' +
        '</div>' +
        '<div class="col-12 text-center">' +
        'El registro que intenta borrar ya se encuentra vinculado con otros procesos.' +
        '</div>' +
        '</div>';
    options.callback = "NO";
    options.message = options.message ? options.message : html;
    options.type = options.type ? options.type : "info";
    confirmToastBootstrap(null, options);
}

console.log('toastBootstrap.js')