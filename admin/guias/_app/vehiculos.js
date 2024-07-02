datatable('table_vehiculos');

inputmask('#vehiculos_input_placa_batea', 'alfanumerico', 6, 7, '');
inputmask('#vehiculos_input_placa_chuto', 'alfanumerico', 6, 7, '');
inputmask('#vehiculos_input_marca', 'alfanumerico', 3, 100, ' ');
inputmask('#vehiculos_input_color', 'alfa', 3, 100, ' ');
inputmask('#vehiculos_input_capacidad', 'alfanumerico', 3, 100, ' ');

$('#vehiculos_form').submit(function (e) {
   e.preventDefault();
   let procesar = true;
   let opcion = $('#vehiculos_opcion').val();
   let empresas_id = $('#vehiculos_select_empresa');
   let placa_batea = $('#vehiculos_input_placa_batea');
   let placa_chuto = $('#vehiculos_input_placa_chuto');
   let tipo = $('#vehiculos_select_tipo');
   let marca = $('#vehiculos_input_marca');
   let color = $('#vehiculos_input_color');
   let capacidad = $('#vehiculos_input_capacidad');

    if (empresas_id.val().length <= 0){
        procesar = false;
        empresas_id.addClass('is-invalid');
        $('#error_vehiculos_select_empresa').text('La empresa es obligatoria');
    }else {
        empresas_id
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (placa_batea.val().length <= 0){
        procesar = false;
        placa_batea.addClass('is-invalid');
        $('#error_vehiculos_input_placa_batea').text('La placa batea es obligatoria');
    }else {
        placa_batea
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (tipo.val().length <= 0){
        procesar = false;
        tipo.addClass('is-invalid');
        $('#error_vehiculos_select_tipo').text('El tipo es obligatorio');
    }else {
        tipo
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (marca.val().length <= 0){
        procesar = false;
        marca.addClass('is-invalid');
        $('#error_vehiculos_input_marca').text('La marca es obligatoria');
    }else {
        marca
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (color.val().length <= 0){
        procesar = false;
        color.addClass('is-invalid');
        $('#error_vehiculos_input_color').text('El color es obligatorio');
    }else {
        color
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (capacidad.val().length <= 0){
        procesar = false;
        capacidad.addClass('is-invalid');
        $('#error_vehiculos_input_capacidad').text('La capacidad es obligatoria');
    }else {
        capacidad
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar){
        if (opcion === 'store'){
            ajaxRequest({url: '_request/VehiculosRequest.php', data: $(this).serialize(), html: 'si' }, function (data) {
                if (data.is_json){
                    if (data.error === 'existe_vehiculo'){
                        placa_batea.addClass('is-invalid');
                        $('#error_vehiculos_input_placa_batea').text('La placa batea ya esta registrada.')
                    }
                }else {
                    $('#btn_modal_form_vehiculos').click();
                    $('#btn_modal_vehiculos').click();
                    $('#card_table_vehiculos').html(data.html);
                    datatable('table_vehiculos');
                }
            });

        }else {
            ajaxRequest({ url: '_request/VehiculosRequest.php', data: $(this).serialize()}, function (data) {
                if (data.result){
                    $('#btn_modal_form_vehiculos').click();
                    $('#btn_modal_vehiculos').click();

                    let btn = '<span class="btn btn-link" data-toggle="modal" data-target="#modal_datos_vehiculos"\n' +
                        '      onclick="datosVehiculoEmpresa('+ data.id +', origen = \'vehiculos\')" >\n' +
                                data.placa_batea +
                        '      </span>';

                    let table = $('#table_vehiculos').DataTable();
                    let tr = $('#tr_item_vehiculos_' + data.id);
                    table
                        .cell(tr.find('.vehiculos_placa')).data(btn)
                        .cell(tr.find('.vehiculos_tipo')).data(data.tipo)
                        .cell(tr.find('.vehiculos_marca')).data(data.marca)
                        .cell(tr.find('.vehiculos_cantidad')).data(data.capacidad)
                        .draw();

                    resetVehiculos();
                }
            });

        }
    }

});

function cambiarFormVehiculos() {
    resetVehiculos();
$('#cerrar_btn_modal_vehiculos').click();
}

function editVehiculo(id) {
    ajaxRequest({url: '_request/VehiculosRequest.php', data: { opcion: 'edit', id: id } }, function (data) {
        if (data.result){
            $('#btn_modal_form_vehiculos').click();
            $('#vehiculos_select_empresa')
                .val(data.empresas_id)
                .trigger('change');
            $('#vehiculos_input_placa_batea').val(data.placa_batea);
            if (data.placa_chuto){
                $('#vehiculos_input_placa_chuto').val(data.placa_chuto);
            }else {
                $('#vehiculos_input_placa_chuto').attr("placeholder", "No posee placa chuto.");
            }

            $('#vehiculos_select_tipo')
                .val(data.tipo)
                .trigger('change');
            $('#vehiculos_input_marca').val(data.marca);
            $('#vehiculos_input_color').val(data.color);
            $('#vehiculos_input_capacidad').val(data.capacidad);
            $('#vehiculos_id').val(data.id);
            $('#vehiculos_opcion').val('update');
        }
    });
}

function resetVehiculos() {
    $('#vehiculos_opcion')
        .val('store');
    $('#vehiculos_id').val('');
    $('#vehiculos_select_empresa')
        .val('')
        .trigger('change')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#vehiculos_input_placa_batea')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#vehiculos_input_placa_chuto')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#vehiculos_select_tipo')
        .val('')
        .trigger('change')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#vehiculos_input_marca')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#vehiculos_input_color')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#vehiculos_input_capacidad')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
}

function elimVehiculo(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            let valor_x = $('#vehiculos_input_hidden_x').val();
            ajaxRequest({ url: '_request/VehiculosRequest.php', data: { opcion: 'destroy', id: id } }, function (data) {
                if (data.result) {

                    let table = $('#table_vehiculos').DataTable();
                    let item = $('#btn_eliminar_vehiculo_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();

                    $('#paginate_leyenda').text(data.total);
                    valor_x = valor_x - 1;
                    if (valor_x === 0){
                        reconstruirTablaVehiculo();
                    }else {
                        $('#vehiculos_input_hidden_x').val(valor_x);
                    }
                }
            });

        }
    });
}

$('#form_vehiculos_buscar').submit(function (e) {
    e.preventDefault();
    ajaxRequest({ url: '_request/VehiculosRequest.php', data: $(this).serialize(), html: 'si'  }, function (data) {
        $('#card_table_vehiculos').html(data.html);
        datatable('table_vehiculos');
    });
});

function reconstruirTablaVehiculo() {
    ajaxRequest({ url: '_request/VehiculosRequest.php', data: { opcion: 'index'}, html: true }, function (data) {
        $('#card_table_vehiculos').html(data.html);
        datatable('table_vehiculos');
    });
}

console.log('vehiculos');