//inicializo datatable
datatable('tabla_parroquias');

//inicializamos el inputmask
inputmask('#parroquia_nombre', 'alfa', 5, 100, ' ');
inputmask('#parroquia_mini', 'alfa', 5, 50, ' ');
inputmask('#parroquia_asignacion', 'numerico', 1, 10, '');

//Aqui se hace la solicitud ajax para registrar una nueva parroquia o editar una existente
$('#form_parroquias').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let municipio = $('#parroquia_municipio');
    let parroquia = $('#parroquia_nombre');
    let mini = $('#parroquia_mini');
    let asignacion = $('#parroquia_asignacion');

    if (municipio.val().length <= 0){
        procesar = false;
        municipio.addClass('is-invalid');
        $('#error_parroquia_municipio').text('El municipio es obligatorio');
    }else {
        municipio.removeClass('is-invalid');
        municipio.addClass('is-valid');
    }

    if (!parroquia.inputmask('isComplete')){
        procesar = false;
        parroquia.addClass('is-invalid');
        $('#error_parroquia_nombre').text('El nombre de la parroquia es obligatoria, , debe tener al menos 5 caracteres.');
    }else {
        parroquia
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!mini.inputmask('isComplete')){
        procesar = false;
        mini.addClass('is-invalid');
        $('#error_parroquia_mini').text('La abreviatura es obligatoria, debe tener al menos 5 caracteres.');
    }else {
        mini
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!asignacion.inputmask('isComplete')){
        procesar = false;
        asignacion.addClass('is-invalid');
        $('#error_parroquia_asignacion').text('La asignacion es obligatoria, debe tener al menos 3 digitos.');
    }else {
        asignacion
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar){

        ajaxRequest({ url: '_request/ParroquiasRequest.php', data: $(this).serialize() }, function (data) {

            if (data.result){

                let table = $('#tabla_parroquias').DataTable();

                let btn_editar = '';
                let btn_eliminar = '';
                let btn_estatus = '';

                if (!data.btn_editar){
                    btn_editar = 'disabled';
                }

                if (!data.btn_eliminar){
                    btn_eliminar = 'disabled';
                }

                if (!data.btn_estatus){
                    btn_estatus = 'disabled';
                }

                if (data.nuevo){
                    //nuevo
                    let buttons = '<div class="btn-group btn-group-sm">\n' +
                        '<button type="button" class="btn btn-info" onclick="estatusParroquia(\''+ data.id +'\')" id="btn_estatus_parroquia_'+ data.id +'" '+ btn_estatus +'>\n' +
                        '                                    <i class="fas fa-eye"></i>\n' +
                        '                                </button>' +
                        '                                <button type="button" class="btn btn-info" onclick="editParroquia(\''+ data.id +'\')" data-toggle="modal"\n' +
                        '                                        data-target="#modal-parroquias" '+ btn_editar +'>\n' +
                        '                                    <i class="fas fa-edit"></i>\n' +
                        '                                </button>\n' +
                        '                                <button type="button" class="btn btn-info" onclick="elimParroquia(\''+ data.id +'\')" id="btn_eliminar_p_'+ data.id +'" '+ btn_eliminar +' >\n' +
                        '                                    <i class="far fa-trash-alt"></i>\n' +
                        '                                </button>\n' +
                        '                            </div>';

                    table.row.add([
                        data.item,
                        data.parroquia,
                        data.asignacion,
                        data.municipio,
                        buttons
                    ]).draw();

                    let nuevo = $('#tabla_parroquias tr:last');
                    nuevo.attr('id', 'tr_item_p_' + data.id);
                    nuevo.find("td:eq(1)").addClass('parroquia');
                    nuevo.find("td:eq(2)").addClass('asignacion');
                    nuevo.find("td:eq(3)").addClass('municipio');

                    //incremento el numero de parroquias en el municipio
                    municipioParroquias(data.municipios_id, data.municipio_parroquias);

                }else {
                    //estoy editando
                    let tr = $('#tr_item_p_' + data.id);
                    table
                        .cell(tr.find('.parroquia')).data(data.parroquia)
                        .cell(tr.find('.asignacion')).data(data.asignacion)
                        .cell(tr.find('.municipio')).data(data.municipio)
                        .draw();
                    if (data.edit_municipio){
                        municipioParroquias(data.anterior_id, data.anterior_cantidad);
                        municipioParroquias(data.actual_id, data.actual_cantidad);
                    }


                }

                $('#parroquia_btn_cancelar').click();
                $('#paginate_leyenda_parroquia').text(data.total);
            }else {

                if (data.error_nombre){
                    $('#parroquia_nombre').addClass('is-invalid');
                    $('#error_parroquia_nombre').text(data.message_nombre);
                }

                if (data.error_mini){
                    $('#parroquia_mini').addClass('is-invalid');
                    $('#error_parroquia_mini').text(data.message_mini);
                }

                if (data.error_asignacion){
                    $('#parroquia_asignacion').addClass('is-invalid');
                    $('#error_parroquia_asignacion').text(data.message_asignacion);
                }
            }

        });


    }

});

//aqui se cambia el modal para editar las parroquias segun el id que se pasa
function editParroquia(id) {
    resetParroquia();

    ajaxRequest({ url: '_request/ParroquiasRequest.php', data: { opcion: 'edit', id: id } }, function (data) {
        if (data.result){
            $('#parroquia_municipio')
                .val(data.municipios)
                .trigger('change');
            $('#parroquia_nombre').val(data.parroquia);
            $('#parroquia_opcion').val('update');
            $('#parroquia_id').val(data.id);
            $('#parroquia_mini').val(data.mini);
            $('#parroquia_asignacion').val(data.asignacion);
        }
    });


}

function elimParroquia(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed){
            let valor_x = $('#input_hidden_parroquia_valor_x').val();
            ajaxRequest({ url: '_request/ParroquiasRequest.php', data: { opcion: 'delete', id: id } }, function (data) {

                if (data.result){
                        let table = $('#tabla_parroquias').DataTable();
                        let item = $('#btn_eliminar_p_' + id).closest('tr');
                        table
                            .row(item)
                            .remove()
                            .draw();

                        $('#paginate_leyenda_parroquia').text(data.total);

                        //disminuir el numero de parroquias en el municipio
                        municipioParroquias(data.municipios_id, data.municipio_parroquias);
                        valor_x = valor_x - 1;
                        if (valor_x === 0){
                            reconstruirTablaParroquias();
                        }else {
                            $('#input_hidden_parroquia_valor_x').val(valor_x);
                        }

                }

            });


        }
    });
}

//esta funsion sirve para resetear los datos del modal de parroquia
function resetParroquia(){

    ajaxRequest({ url: '_request/ParroquiasRequest.php', data: { opcion: 'get_municipios' } }, function (data) {
        if (data.result){
            let select = $('#parroquia_municipio');
            let municipios = data.municipios.length;
            select.empty();
            select.append('<option value="">Seleccione</option>');
            for (let i = 0; i < municipios; i++) {
                let id = data.municipios[i]['id'];
                let nombre = data.municipios[i]['nombre'];
                select.append('<option value="' + id + '">' + nombre + '</option>');
            }
        }
    });



    $('#parroquia_municipio')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#parroquia_nombre')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#parroquia_mini')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#parroquia_id').val('');
    $('#parroquia_asignacion')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#parroquia_opcion').val('store');
    $('#title_parroquia').text('Crear Parroquia');
}

function municipioParroquias(id, parroquias) {
    let table_municipio = $('#tabla_municipios').DataTable();
    if (existeElemento('#tr_item_' + id)){
        let tr = $('#tr_item_' + id);
        let html = '<div class="text-center"><div class="btn-group btn-group-sm">\n' +
         '                                <button type="button" class="btn btn-success" onclick="filtrarParroquias('+ id +')">\n' +
                                             parroquias +
         '                                </button>\n' +
         '                            </div></div>';
     table_municipio
         .cell(tr.find('.parroquias')).data(html)
         .draw();
    }

}

function filtrarParroquias(id) {
    ajaxRequest({ url: '_request/ParroquiasRequest.php', data: { opcion: 'get_parroquias', id: id }, html: true }, function (data) {
        $('#dataContainerParroquia').html(data.html); datatable('tabla_parroquias');
        $('#parroquias_btn_restablecer').removeClass('d-none');
        $('#custom-tabs-one-profile-tab').click();
        $("#btn_header_municipios").removeClass('text-muted');
        $("#btn_header_parroquias").addClass('text-muted');
        $("#btn_restablecer_filtro").attr("onclick", "filtrarParroquias('"+id+"')")
    });


}

function estatusParroquia(id) {

    let boton = $('#btn_estatus_parroquia_' + id);

    ajaxRequest({ url: '_request/ParroquiasRequest.php', data: { opcion: 'set_estatus', id: id } }, function (data) {
        if (data.result){
            let icono;

            if (data.estatus === 1){
                icono = '<i class="fas fa-eye"></i>';
            }else {
                icono = '<i class="fas fa-eye-slash"></i>';
            }

            let btn_editar = '';
            let btn_eliminar = '';
            let btn_estatus = '';

            if (!data.btn_editar){
                btn_editar = 'disabled';
            }

            if (!data.btn_eliminar){
                btn_eliminar = 'disabled';
            }

            if (!data.btn_estatus){
                btn_estatus = 'disabled';
            }

            let buttons = '<div class="btn-group btn-group-sm">\n' +
                '<button type="button" class="btn btn-info" onclick="estatusParroquia(\''+ id +'\')" id="btn_estatus_parroquia_'+ id +'" '+ btn_estatus +'>\n' +
                '                               ' + icono +
                '                                </button>' +
                '                                <button type="button" class="btn btn-info" onclick="editParroquia(\''+ id +'\')" data-toggle="modal"\n' +
                '                                        data-target="#modal-parroquias" '+ btn_editar +'>\n' +
                '                                    <i class="fas fa-edit"></i>\n' +
                '                                </button>\n' +
                '                                <button type="button" class="btn btn-info" onclick="elimParroquia(\''+ id +'\')" id="btn_eliminar_p_'+ id +'" '+ btn_eliminar +' >\n' +
                '                                    <i class="far fa-trash-alt"></i>\n' +
                '                                </button>\n' +
                '                            </div>';

            let table = $('#tabla_parroquias').DataTable();
            let tr = $('#tr_item_p_' + id);
            table
                .cell(tr.find('.botones')).data(buttons)
                .draw();
        }
    });


}

$('#navbar_form_buscar').submit(function (e) {
    e.preventDefault();
    let keyword = $('#navbar_input_buscar').val();
    ajaxRequest({ url: '_request/ParroquiasRequest.php', data: { opcion: 'search', keyword: keyword}, html: 'si' }, function (data) {
        $('#dataContainerParroquia').html(data.html);
        datatable('tabla_parroquias');
    });

});

function reconstruirTablaParroquias() {
    ajaxRequest({ url: '_request/ParroquiasRequest.php', data: { opcion: 'get_parroquias'}, html: true }, function (data) {
        $('#dataContainerParroquia').html(data.html); datatable('tabla_parroquias');
        $('#parroquias_btn_restablecer').removeClass('d-none');
    });
}

function reconstruirBuscarParroquia(keyword) {
    ajaxRequest({ url: '_request/ParroquiasRequest.php', data: { opcion: 'search', keyword: keyword}, html: 'si' }, function (data) {
        $('#dataContainerParroquia').html(data.html);
        datatable('tabla_parroquias');
    });
}
console.log('Parroquia.!');
