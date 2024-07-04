datatable('table_vehiculos');

inputmask('#input_vehiculos_placa_batea', 'alfanumerico', 6, 7, '');
inputmask('#input_vehiculos_placa_chuto', 'alfanumerico', 6, 7, '');
inputmask('#input_vehiculos_marca', 'alfanumerico', 3, 100, ' ');
inputmask('#input_vehiculos_color', 'alfa', 3, 100, ' ');
inputmask('#input_vehiculos_capasidad', 'alfanumerico', 3, 100, ' ');

console.log('vehiculos');

function displayVehiculos(init = 'true') {
    verSpinner(true);
    $('.show_vehiculos_cerrar').attr('onclick', "display('vehiculos')");

    switch (init) {
        case "form":
            if ($("#row_form_vehiculos").hasClass( "d-none")){
                $('#row_form_vehiculos').removeClass('d-none');
            }
            if (!$("#row_table_vehiculos").hasClass( "d-none")){
                $('#row_table_vehiculos').addClass('d-none');
            }
            if (!$("#row_show_vehiculo").hasClass( "d-none")){
                $('#row_show_vehiculo').addClass('d-none');
            }
            break;

        case "show":
            if (!$("#row_form_vehiculos").hasClass( "d-none")){
                $('#row_form_vehiculos').addClass('d-none');
            }
            if (!$("#row_table_vehiculos").hasClass( "d-none")){
                $('#row_table_vehiculos').addClass('d-none');
            }
            if ($("#row_show_vehiculo").hasClass( "d-none")){
                $('#row_show_vehiculo').removeClass('d-none');
            }
            break;

        default:
            if (!$("#row_form_vehiculos").hasClass( "d-none")){
                $('#row_form_vehiculos').addClass('d-none');
            }
            if ($("#row_table_vehiculos").hasClass( "d-none")){
                $('#row_table_vehiculos').removeClass('d-none');
            }
            if (!$("#row_show_vehiculo").hasClass( "d-none")){
                $('#row_show_vehiculo').addClass('d-none');
            }
            break;
    }

    verSpinner(false);
}

function initVehiculos() {
    displayVehiculos();
    $('#keyword_vehiculos').val('');
    ajaxRequest({ url: '_request/VehiculosRequest.php', data: { opcion: 'index'}, html: true }, function (data) {
        $('#div_vehiculos').html(data.html);
        datatable('table_vehiculos');
    });
}

function getTipos() {
    ajaxRequest({url: '_request/VehiculosRequest.php', data: { opcion: 'get_tipos' } }, function (data) {
        if (data.result){
            let select = $('#select_vehiculos_tipo');
            let vehiculos = data.listarTipos.length;
            select.empty();
            select.append('<option value="">Seleccione</option>');
            for (let i = 0; i < vehiculos; i++) {
                let id = data.listarTipos[i]['id'];
                let nombre = data.listarTipos[i]['nombre'];
                select.append('<option value="' + id + '">' + nombre + '</option>');
            }
        }
    });
}

function resetVehiculos() {
    $('#vehiculos_opcion')
        .val('store');
    $('#vehiculos_id').val('');
    $('#select_vehiculos_empresa')
        .val('')
        .trigger('change')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#input_vehiculos_placa_batea')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#input_vehiculos_placa_chuto')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#select_vehiculos_tipo')
        .val('')
        .trigger('change')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#input_vehiculos_marca')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#input_vehiculos_color')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#input_vehiculos_capasidad')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
}

function createVehiculos(){
    $('#title_form_vehiculos').text('Nuevo Vehículo');
    $('#btn_guradar_form_vehiculos').text('Guardar');
    resetVehiculos();
    getEmpresas();
    getTipos();
    displayVehiculos('form');
}

//Buscar
$('#form_vehiculos_buscar').submit(function (e) {
    e.preventDefault();
    ajaxRequest({ url: '_request/VehiculosRequest.php', data: $(this).serialize(), html: 'si'  }, function (data) {
        $('#div_vehiculos').html(data.html);
        datatable('table_vehiculos');
    });
});

function destroyVehiculo(id) {
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
                        initVehiculos();
                    }else {
                        $('#vehiculos_input_hidden_x').val(valor_x);
                    }
                }
            });

        }
    });
}

function editVehiculo(id) {
    $('#title_form_vehiculos').text('Editar Vehiculo');
    $('#btn_guradar_form_vehiculos').text('Guardar Cambios');
    resetVehiculos();
    getEmpresas();
    getTipos();
    setTimeout(function () {
        ajaxRequest({url: '_request/VehiculosRequest.php', data: { opcion: 'edit', id: id } }, function (data) {
            if (data.result){
                $('#select_vehiculos_empresa')
                    .val(data.empresas_id)
                    .trigger('change');
                $('#input_vehiculos_placa_batea').val(data.placa_batea);
                if (data.placa_chuto){
                    $('#input_vehiculos_placa_chuto').val(data.placa_chuto);
                }else {
                    $('#input_vehiculos_placa_chuto').attr("placeholder", "No posee placa chuto.");
                }

                $('#select_vehiculos_tipo')
                    .val(data.tipo)
                    .trigger('change');
                $('#input_vehiculos_marca').val(data.marca);
                $('#input_vehiculos_color').val(data.color);
                $('#input_vehiculos_capasidad').val(data.capacidad);
                $('#vehiculos_id').val(data.id);
                $('#vehiculos_opcion').val('update');
                displayVehiculos('form');
            }
        });
    }, 500);
}

$('#form_vehiculos').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let opcion = $('#vehiculos_opcion').val();
    let empresas_id = $('#select_vehiculos_empresa');
    let placa_batea = $('#input_vehiculos_placa_batea');
    let placa_chuto = $('#input_vehiculos_placa_chuto');
    let tipo = $('#select_vehiculos_tipo');
    let marca = $('#input_vehiculos_marca');
    let color = $('#input_vehiculos_color');
    let capacidad = $('#input_vehiculos_capasidad');

    if (empresas_id.val().length <= 0){
        procesar = false;
        empresas_id.addClass('is-invalid');
        $('#error_select_vehiculos_empresa').text('La empresa es obligatoria');
    }else {
        empresas_id
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (placa_batea.val().length <= 0){
        procesar = false;
        placa_batea.addClass('is-invalid');
        $('#error_input_vehiculos_placa_batea').text('La placa batea es obligatoria');
    }else {
        placa_batea
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (tipo.val().length <= 0){
        procesar = false;
        tipo.addClass('is-invalid');
        $('#error_select_vehiculos_tipo').text('El tipo es obligatorio');
    }else {
        tipo
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (marca.val().length <= 0){
        procesar = false;
        marca.addClass('is-invalid');
        $('#error_input_vehiculos_marca').text('La marca es obligatoria');
    }else {
        marca
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (color.val().length <= 0){
        procesar = false;
        color.addClass('is-invalid');
        $('#error_input_vehiculos_color').text('El color es obligatorio');
    }else {
        color
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (capacidad.val().length <= 0){
        procesar = false;
        capacidad.addClass('is-invalid');
        $('#error_input_vehiculos_capasidad').text('La capacidad es obligatoria');
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
                        $('#error_input_vehiculos_placa_batea').text('La placa batea ya esta registrada.')
                    }
                }else {
                    $('#div_vehiculos').html(data.html);
                    datatable('table_vehiculos');
                    displayVehiculos();
                }
            });

        }else {
            ajaxRequest({ url: '_request/VehiculosRequest.php', data: $(this).serialize()}, function (data) {
                if (data.result){
                    let btn = '<span class="btn btn-link"\n' +
                        '      onclick="showVehiculo('+ data.id +', origen = \'vehiculos\')" >\n' +
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
                    displayVehiculos();
                }
            });

        }
    }

});
