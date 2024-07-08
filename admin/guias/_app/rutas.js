
function displayRutas(init = 'true') {
    verSpinner(true);

    switch (init) {
        case "form":
            if ($("#row_form_rutas").hasClass("d-none")) {
                $('#row_form_rutas').removeClass('d-none');
            }
            if (!$("#row_table_rutas").hasClass("d-none")) {
                $('#row_table_rutas').addClass('d-none');
            }
            break;

        default:
            if (!$("#row_form_rutas").hasClass("d-none")) {
                $('#row_form_rutas').addClass('d-none');
            }
            if ($("#row_table_rutas").hasClass("d-none")) {
                $('#row_table_rutas').removeClass('d-none');
            }
            break;
    }

    verSpinner(false);
}

function initRutas() {
    displayRutas();
    $('#keyword_rutas').val('');
    /*ajaxRequest({url: '_request/ChoferesRequest.php', data: {opcion: 'index'}, html: true}, function (data) {
        $('#div_choferes').html(data.html);
        datatable('table_choferes');
    });*/
}

function createRutas() {
    $('#title_form_rutas').text('Nueva Ruta');
    getMunicipios();
    //resetChofer();
    displayRutas('form');
}

function getMunicipios() {
    ajaxRequest({url: '_request/RutasRequest.php', data: { opcion: 'get_parroquias' }}, function (data) {
        if (data.result){
            let select = $('.select_rutas_municipios');
            let parroquias = data.listarParroquias.length;
            select.empty();
            select.append('<option value="">Seleccione</option>');
            for (let i = 0; i < parroquias; i++) {
                let id = data.listarParroquias[i]['id'];
                let nombre = data.listarParroquias[i]['nombre'];
                select.append('<option value="' + id + '">' + nombre + '</option>');
            }
        }
    });
}

function addItem() {
    let contador = document.getElementById("contador");
    let valor_actual = contador.dataset.contador;
    let valor_nuevo = parseInt(valor_actual) + 1;
    contador.dataset.contador = valor_nuevo;
    let input_actual = contador.value;
    let input_nuevo = parseInt(input_actual) + 1;
    contador.value = input_nuevo;
    let content = '' +
        '<div class="row" id="item_' + input_nuevo + '">' +
        '<div class="col-10">' +
        '<input type="text" class="form-control" name="ruta_' + input_nuevo + '" placeholder="Lugar" id="ruta_' + input_nuevo + '" required />' +
        '</div>' +
        '<div class="col-2 p-1">' +
        '<button type="button" class="btn btn-link" onclick="btnRemove(\'item_' + input_nuevo + '\')">' +
        '<i class="fas fa-minus-circle text-danger"></i>' +
        '</button>' +
        '</div>' +
        '</div>';

    $('#items').append(content);
    //alert(valor_nuevo);
}

function btnRemove(item)
{
    let contador = document.getElementById("contador");
    let row = document.getElementById(item);
    let valor_actual = contador.dataset.contador;
    let valor_nuevo = parseInt(valor_actual) - 1;
    contador.dataset.contador = valor_nuevo;
    row.remove();
}

console.log('rutas.js');