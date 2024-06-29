datatable('table_choferes')

inputmask('#choferes_input_cedula', 'numerico', 7, 8, '');
inputmask('#choferes_input_nombre', 'alfanumerico', 3, 100, ' ');
inputmaskTelefono('#choferes_input_telefono');

function cambiarForm() {
    resetChofer();
    $('#btn_modal_table_choferes').click();
}

function cambiarTable() {
    $('#btn_modal_choferes').click();
}

$('#choferes_form').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let empresa = $('#choferes_select_empresa');
    let vehiculo = $('#choferes_select_vehiculo');
    let cedula = $('#choferes_input_cedula');
    let nombre = $('#choferes_input_nombre');
    let telefono = $('#choferes_input_telefono');

    if (empresa.val().length <= 0){
        procesar = false;
        empresa.addClass('is-invalid');
        $('#error_choferes_select_empresa').text('La empresa es obligatoria');
    }else {
        empresa
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (vehiculo.val().length <= 0){
        procesar = false;
        vehiculo.addClass('is-invalid');
        $('#error_choferes_select_vehiculo').text('El vehiculo es obligatorio');
    }else {
        vehiculo
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!cedula.inputmask('isComplete')){
        procesar = false;
        cedula.addClass('is-invalid');
        $('#error_choferes_input_cedula').text('La cedula es obligatoria');
    }else {
        cedula
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!nombre.inputmask('isComplete')){
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_choferes_input_nombre').text('El nombre es obligatorio');
    }else {
        nombre
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!telefono.inputmask('isComplete')){
        procesar = false;
        telefono.addClass('is-invalid');
        $('#error_choferes_input_telefono').text('El telefono es obligatorio');
    }else {
        telefono
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar){
        let opcion = $('#choferes_opcion').val();
        if (opcion === 'store'){
            ajaxRequest( {url: '_request/ChoferesRequest.php', data: $(this).serialize(), html: 'si' }, function (data) {
                if (data.is_json){
                    if (data.error === 'existe_chofer'){
                        cedula.addClass('is-invalid');
                        $('#error_choferes_input_cedula').text('La cedula ya esta registrada.')
                    }
                }else {
                    $('#btn_modal_form_choferes').click();
                    $('#card_table_choferes').html(data.html);
                    datatable('table_choferes');



                }
            });
        }else {
            ajaxRequest({ url: '_request/ChoferesRequest.php', data: $(this).serialize() }, function (data) {
                if (data.result){
                    $('#btn_modal_form_choferes').click();
                    let btn ='<span class="btn btn-link" data-toggle="modal"\n' +
                        '     data-target="#modal_datos_vehiculos" onclick="cambiarForm(); datosVehiculo('+ data.vehiculos_id +')">' +
                            data.placa +
                        '</span>';
                    let table = $('#table_choferes').DataTable();
                    let tr = $('#tr_item_choferes_' + data.id);
                    table
                        .cell(tr.find('.choferes_cedula')).data(data.cedula)
                        .cell(tr.find('.choferes_nombre')).data(data.nombre)
                        .cell(tr.find('.choferes_telefono')).data(data.telefono)
                        .cell(tr.find('.choferes_placa')).data(btn)
                        .draw();

                    reset();
                }
            });
        }

    }



});

function editChofer(id) {
    $('#btn_modal_form').click();
    ajaxRequest({ url: '_request/ChoferesRequest.php', data: { opcion: 'edit', id: id } }, function (data) {
        if (data.result){
            $('#choferes_input_cedula').val(data.cedula);
            $('#choferes_input_nombre').val(data.nombre);
            $('#choferes_input_telefono').val(data.telefono);
            $('#choferes_select_empresa')
                .val(data.empresas_id)
                .trigger('change');
            $('#choferes_select_vehiculo')
                .val(data.vehiculos_id)
                .trigger('change');
            $('#choferes_opcion').val('update');
            $('#choferes_id').val(data.id);
        }
    });
}

function resetChofer() {
    $('#choferes_input_cedula')
        .val('')
        .removeClass('is-valid');
    $('#choferes_input_nombre')
        .val('')
        .removeClass('is-valid');
    $('#choferes_input_telefono')
        .val('')
        .removeClass('is-valid');
    $('#choferes_select_empresa')
        .val('')
        .trigger('change')
        .removeClass('is-valid');
    $('#choferes_select_vehiculo')
        .val('')
        .trigger('change')
        .removeClass('is-valid');
    $('#choferes_opcion').val('store');
}

function datosVehiculo(id) {
    ajaxRequest( { url: '_request/ChoferesRequest.php', data: { opcion: 'get_datos_vehiculo', id: id } }, function (data) {
        if (data.result){
            $('#modal_vehiculo_placa_batea').text(data.placa_batea);
            $('#modal_vehiculo_marca').text(data.marca);
            $('#modal_vehiculo_tipo').text(data.tipo);
            $('#modal_vehiculo_color').text(data.color_vehiculo);
            if (data.placa_chuto.length <= 0){
                $('#modal_placa_chuto').addClass('d-none');
            }else {
                $('#modal_placa_chuto').removeClass('d-none');
                $('#modal_vehiculo_placa_chuto').text(data.placa_chuto);
            }

            $('#modal_empresa_rif').text(data.rif);
            $('#modal_empresa_nombre').text(data.nombre);
            $('#modal_empresa_responsable').text(data.responsable);
            $('#modal_empresa_telefono').text(data.telefono);

        }
    });
}

function destroyChofer(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            let valor_x = $('#chofer_input_hidden_x').val();
            ajaxRequest({ url: '_request/ChoferesRequest.php', data: { opcion: 'destroy', id: id } }, function (data) {
                if (data.result) {

                    let table = $('#table_choferes').DataTable();
                    let item = $('#btn_eliminar_chofer_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();

                    $('#paginate_leyenda').text(data.total);
                    valor_x = valor_x - 1;
                    if (valor_x === 0){
                        reconstruirTablaChofer();
                    }else {
                        $('#chofer_input_hidden_x').val(valor_x);
                    }
                }
            });

        }
    });
}

$('#form_choferes_buscar').submit(function (e) {
    e.preventDefault();
    ajaxRequest({ url: '_request/ChoferesRequest.php', data: $(this).serialize(), html: 'si'  }, function (data) {
        $('#card_table_choferes').html(data.html);
        datatable('table_choferes');
    });
});

function reconstruirTablaChofer() {
    ajaxRequest({ url: '_request/ChoferesRequest.php', data: { opcion: 'index'}, html: true }, function (data) {
        $('#card_table_choferes').html(data.html);
        datatable('table_choferes');
    });
}



console.log('choferes..');