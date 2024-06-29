datatable('table_empresas');

inputmask('#empresas_input_rif', 'alfanumerico', 9, 12, '-');
inputmask('#empresas_input_nombre', 'alfanumerico', 3, 100, ' .');
inputmask('#empresas_input_responsable', 'alfanumerico', 3, 100, ' ');
inputmaskTelefono('#empresas_input_telefono');


$('#empresas_form').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let rif = $('#empresas_input_rif');
    let nombre = $('#empresas_input_nombre');
    let responsable = $('#empresas_input_responsable');
    let telefono = $('#empresas_input_telefono');


    if (!rif.inputmask('isComplete')) {
        procesar = false;
        rif.addClass('is-invalid');
        $('#error_empresas_input_rif').text('El rif es obligatorio');
    } else {
        rif
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!nombre.inputmask('isComplete')) {
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_empresas_input_nombre').text('El nombre es obligatorio');
    } else {
        nombre
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!responsable.inputmask('isComplete')) {
        procesar = false;
        responsable.addClass('is-invalid');
        $('#error_empresas_input_responsable').text('El responsable es obligatorio');
    } else {
        responsable
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!telefono.inputmask('isComplete')) {
        procesar = false;
        telefono.addClass('is-invalid');
        $('#error_empresas_input_telefono').text('El teléfono es obligatorio');
    } else {
        telefono
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar) {
        let opcion = $('#empresas_opcion').val();
        if (opcion === 'store') {
            ajaxRequest({url: '_request/EmpresasRequest.php', data: $(this).serialize(), html: 'si'}, function (data) {
                if (data.is_json) {
                    if (data.error === 'existe_empresa') {
                        rif.addClass('is-invalid');
                        $('#error_empresas_input_rif').text(data.message);
                    }
                } else {
                    $('#btn_modal_form_empresas').click();
                    $('#card_table_empresas').html(data.html);
                    datatable('table_empresas');
                }
            });

        } else {
            ajaxRequest({url: '_request/EmpresasRequest.php', data: $(this).serialize()}, function (data) {
                if (data.result) {
                    $('#btn_modal_form_empresas').click();
                    let table = $('#table_empresas').DataTable();
                    let tr = $('#tr_item_empresas_' + data.id);
                    table
                        .cell(tr.find('.empresa_rif')).data(data.rif)
                        .cell(tr.find('.empresa_nombre')).data(data.nombre)
                        .cell(tr.find('.empresa_responsable')).data(data.responsable)
                        .cell(tr.find('.empresa_telefono')).data(data.telefono)
                        .draw();
                } else {
                    if (data.error === 'datos_duplicados') {
                        rif.addClass('is-invalid');
                        $('#error_empresas_input_rif').text(data.message);
                    }
                }

            });

        }
    }

});

function cerrarTable() {
    resetEmpresa();
    $('#btn_modal_table_empresas').click();
}

function cambiarTableEmpresa() {
    $('#btn_modal_empresas').click();
}

function editEmpresa(id) {
    $('#modal_form_empresas').click();
    ajaxRequest({url: '_request/EmpresasRequest.php', data: {opcion: 'edit', id: id}}, function (data) {
        if (data.result) {
            $('#empresas_input_rif').val(data.rif);
            $('#empresas_input_nombre').val(data.nombre);
            $('#empresas_input_responsable').val(data.responsable);
            $('#empresas_input_telefono').val(data.telefono);
            $('#empresas_id').val(data.id);
            $('#empresas_opcion').val('update');
        }
    });
}

function resetEmpresa() {
    $('#empresas_input_rif')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#empresas_input_nombre')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#empresas_input_responsable')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#empresas_input_telefono')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#empresas_id')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#empresas_opcion').val('store');
}

function elimEmpresa(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            let valor_x = $('#empresa_input_hidden_x').val();
            ajaxRequest({url: '_request/EmpresasRequest.php', data: {opcion: 'destroy', id: id}}, function (data) {
                if (data.result) {

                    let table = $('#table_empresas').DataTable();
                    let item = $('#btn_eliminar_empresa_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();

                    $('#paginate_leyenda').text(data.total);
                    valor_x = valor_x - 1;
                    if (valor_x === 0){
                        reconstruirTablaEmpresa();
                    }else {
                        $('#empresa_input_hidden_x').val(valor_x);
                    }
                }
            });

        }
    });
}

$('#form_empresas_buscar').submit(function (e) {
    e.preventDefault();
    ajaxRequest({ url: '_request/EmpresasRequest.php', data: $(this).serialize(), html: 'si'  }, function (data) {
        $('#card_table_empresas').html(data.html);
        datatable('table_empresas');
    });
});


function reconstruirTablaEmpresa() {
    ajaxRequest({ url: '_request/EmpresasRequest.php', data: { opcion: 'index'}, html: 'si' }, function (data) {
        $('#card_table_empresas').html(data.html);
        datatable('table_empresas');
    });
}

console.log('empresas');