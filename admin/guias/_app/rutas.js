datatable('table_rutas');

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
            if (!$("#row_show_rutas").hasClass("d-none")) {
                $('#row_show_rutas').addClass('d-none');
            }
            break;

        case "show":
            if (!$("#row_form_rutas").hasClass("d-none")) {
                $('#row_form_rutas').addClass('d-none');
            }
            if (!$("#row_table_rutas").hasClass("d-none")) {
                $('#row_table_rutas').addClass('d-none');
            }
            if ($("#row_show_rutas").hasClass("d-none")) {
                $('#row_show_rutas').removeClass('d-none');
            }
            break;

        default:
            if (!$("#row_form_rutas").hasClass("d-none")) {
                $('#row_form_rutas').addClass('d-none');
            }
            if ($("#row_table_rutas").hasClass("d-none")) {
                $('#row_table_rutas').removeClass('d-none');
            }
            if (!$("#row_show_rutas").hasClass("d-none")) {
                $('#row_show_rutas').addClass('d-none');
            }
            break;
    }

    verSpinner(false);
}

function initRutas() {
    displayRutas();
    $('#keyword_rutas').val('');
    ajaxRequest({url: '_request/RutasRequest.php', data: {opcion: 'index'}, html: true}, function (data) {
        $('#div_rutas').html(data.html);
        datatable('table_rutas');
    });
}

function createRutas() {
    $('#title_form_rutas').text('Nueva Ruta');
    getMunicipios();
    resetRutas();
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
        '<input type="text" class="form-control input_rutas_items" name="ruta_' + input_nuevo + '" placeholder="Lugar" id="ruta_' + input_nuevo + '" />' +
        /*'<div class="invalid-feedback" id="error_ruta_'+ input_nuevo +'"></div>'+*/
        '</div>' +
        '<div class="col-2">' +
        '<button type="button" class="btn" onclick="btnRemove(\'item_' + input_nuevo + '\')">' +
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

$('#form_rutas').submit(function (e) {
   e.preventDefault();
   let procesar = true;
   let origen = $('#select_rutas_origen');
   let destino = $('#select_rutas_destino');
   let ruta = $('.input_rutas_items');
   let opcion = $('#rutas_opcion').val();


    if (origen.val().length <= 0) {
        procesar = false;
        origen.addClass('is-invalid');
        $('#error_select_rutas_origen').text('El origen es obligatorio');
    } else {
        origen
            .removeClass('is-invalid')
            .addClass('is-valid');

    }

    ruta.each(function () {
        let valor_item = $(this).val();
        let valor_id = $(this).attr('id');

        if (valor_item.length <= 0) {
            procesar = false;
            $(this).addClass('is-invalid');
            $('#mensaje_error_ruta').removeClass('d-none')
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            if (!$('#mensaje_error_ruta').hasClass("d-none")){
                $('#mensaje_error_ruta').addClass("d-none");
            }
            $('#mensaje_error_ruta').addClass('d-none')
        }
    });

    if (destino.val().length <= 0) {
        procesar = false;
        destino.addClass('is-invalid');
        $('#error_select_rutas_destino').text('El destino es obligatorio');
    } else if (destino.val() === origen.val()) {
        procesar = false;
        destino.addClass('is-invalid');
        $('#error_select_rutas_destino').text('El destino no puede ser igual al origen');
    } else {
        destino
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar){
        if (opcion === 'store'){
            ajaxRequest({url: '_request/RutasRequest.php', data: $(this).serialize(), html: 'si'}, function (data) {
                if (!data.is_json){
                    $('#div_rutas').html(data.html);
                    datatable('table_rutas');
                    displayRutas();
                }else {
                    //manejo los errores
                    if (data.error === 'ruta_duplicada'){
                        destino
                            .removeClass('is-valid')
                            .addClass('is-invalid');
                        $('#error_select_rutas_destino').text(data.title);
                        origen
                            .removeClass('is-valid')
                            .addClass('is-invalid');
                        $('#error_select_rutas_origen').text(data.title);
                    }
                }
            });
        }else {
            //editando
            ajaxRequest({url: '_request/RutasRequest.php', data: $(this).serialize()}, function (data) {
                if (data.result){
                    let btn = '<button class="btn btn-link btn-sm" onclick="showRutas('+data.id+')">\n' +
                        '              Ver ruta\n' +
                        '      </button>';
                    let table = $('#table_rutas').DataTable();
                    let tr = $('#tr_item_rutas_' + data.id);
                    table
                        .cell(tr.find('.origen')).data(data.origen)
                        .cell(tr.find('.ruta')).data(btn)
                        .cell(tr.find('.destino')).data(data.destino)
                        .draw();
                    resetRutas();
                    displayRutas();
                }else {
                    if (data.error === 'ruta_duplicada'){
                        destino
                            .removeClass('is-valid')
                            .addClass('is-invalid');
                        $('#error_select_rutas_destino').text(data.title);
                        origen
                            .removeClass('is-valid')
                            .addClass('is-invalid');
                        $('#error_select_rutas_origen').text(data.title);
                    }
                }
            });
        }
    }
});

function resetRutas() {
    $('#select_rutas_origen')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#select_rutas_destino')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('.input_rutas_items')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#rutas_opcion').val('store');
    $('#rutas_id').val('');
    let contador = document.getElementById('contador');
    for (let i = 1; i <= contador.value; i++) {
        if (i > 1){
            if ($('#item_'+ i).length){
                btnRemove('item_' + i);
            }
        }
    }
    contador.value = 1;
    contador.dataset.contador = 1;
    $('#ruta_1').val('');

    if (!$('#mensaje_error_ruta').hasClass("d-none")){
        $('#mensaje_error_ruta').addClass("d-none");
    }
}

function showRutas(id) {
    ajaxRequest({url: '_request/RutasRequest.php', data: {opcion: 'get_ruta', id : id}}, function (data) {
        if (data.result){
            $('#modal_ruta_ver_origen').text(data.origen);
            $('#modal_ruta_ver_destino').text(data.destino);
            let trayecto = $('#modal_ruta_ver_trayecto');
            let lugares = data.listarLugares.length;
            let html = '';
            for (let i = 0; i < lugares; i++) {
                let lugar = data.listarLugares[i]['lugar'];
                html += '<li class="list-group-item"><span class="text-primary"><small>'+ (i + 1) + '.-</small>&nbsp;'+ lugar +' </span></li>';
            }
            trayecto.html(html);
            $('#modal_ruta_btn_editar').attr("onclick", "editRuta("+id+")");
            displayRutas('show');
        }
    });
}

function editRuta(id) {
    verSpinner(true);
    $('#title_form_rutas').text('Editar Ruta');
    $('#btn_guradar_form_rutas').text('Guardar Cambios');
    resetRutas();
    getMunicipios();

    ajaxRequest({url: '_request/RutasRequest.php', data: {opcion: 'get_ruta', id: id}}, function (data) {
        if (data.result){
            $('#select_rutas_origen')
                .val(data.id_origen)
                .trigger('change');
            $('#select_rutas_destino')
                .val(data.id_destino)
                .trigger('change');
            let trayecto = $('#items');
            let lugares = data.listarLugares.length;
            let html = '';
            let item = 0;
            let btn = '';
            for (let i = 0; i < lugares; i++) {
                item = i+1;
                let lugar = data.listarLugares[i]['lugar'];
                if (item > 1){
                    btn =  '<button type="button" class="btn" onclick="btnRemove(\'item_' + item + '\')">' +
                        '<i class="fas fa-minus-circle text-danger"></i>' +
                        '</button>';
                }else {
                    btn = '<span class="btn">&nbsp;</span>';
                }
                html += '<div class="row" id="item_'+item+'">\n' +
                    '                        <div class="col-10">\n' +
                    '                            <input type="text" class="form-control input_rutas_items" value="'+lugar+'" name="ruta_'+item+'" placeholder="Lugar" id="ruta_'+item+'">\n' +
                    '                        </div>\n' +
                    '                        <div class="col-2 p-1">\n' +
                                                btn +
                    '                        </div>\n' +
                    '                    </div>';
            }
            trayecto.html(html);
            let contador = document.getElementById('contador');
            contador.value = lugares;
            contador.dataset.contador = lugares;
            $('#rutas_opcion').val('update');
            $('#rutas_id').val(id)
            displayRutas('form');
        }
    });

}

function destroyRutas(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            let valor_x = $('#rutas_input_hidden_x').val();
            ajaxRequest({url: '_request/RutasRequest.php', data: {opcion: 'destroy', id: id}}, function (data) {
                if (data.result) {
                    let table = $('#table_rutas').DataTable();
                    let item = $('#tr_item_rutas_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();
                    $('#paginate_leyenda').text(data.total);
                    valor_x = valor_x - 1;
                    if (valor_x === 0) {
                        initRutas();
                    } else {
                        $('#rutas_input_hidden_x').val(valor_x);

                    }
                }
            });

        }
    });
}


console.log('rutas.js');