datatable('table_empresas');

inputmask('#input_empresas_rif', 'alfanumerico', 9, 12, '-');
inputmask('#input_empresas_nombre', 'alfanumerico', 3, 100, ' .');
inputmask('#input_empresas_responsable', 'alfanumerico', 3, 100, ' ');
inputmaskTelefono('#input_empresas_telefono');


function displayEmpresas(init = 'true') {
    verSpinner(true);

    switch (init) {
        case "form":
            if ($("#row_form_empresas").hasClass( "d-none")){
                $('#row_form_empresas').removeClass('d-none');
            }
            if (!$("#row_table_empresas").hasClass( "d-none")){
                $('#row_table_empresas').addClass('d-none');
            }
            break;

        default:
            if (!$("#row_form_empresas").hasClass( "d-none")){
                $('#row_form_empresas').addClass('d-none');
            }
            if ($("#row_table_empresas").hasClass( "d-none")){
                $('#row_table_empresas').removeClass('d-none');
            }
            break;
    }

    verSpinner(false);
}

function initEmpresas() {
    displayEmpresas();
    $('#keyword_empresas').val('');
    ajaxRequest({ url: '_request/EmpresasRequest.php', data: { opcion: 'index'}, html: true }, function (data) {
        $('#div_empresas').html(data.html);
        datatable('table_empresas');
    });
}

//buscar
$('#form_empresas_buscar').submit(function (e) {
    e.preventDefault();
    ajaxRequest({ url: '_request/EmpresasRequest.php', data: $(this).serialize(), html: 'si'  }, function (data) {
        $('#div_empresas').html(data.html);
        datatable('table_empresas');
        displayEmpresas();
    });
});

function createEmpresas(){
    $('#title_form_empresas').text('Nueva Empresa');
    $('#btn_guradar_form_empresas').text('Guardar');
    resetEmpresa();
    displayEmpresas('form');
}

function resetEmpresa() {
    $('#input_empresas_rif')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#input_empresas_nombre')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#input_empresas_responsable')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#input_empresas_telefono')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#empresas_id').val('');
    $('#empresas_opcion').val('store');
}

function editEmpresa(id) {
    resetEmpresa();
    $('#btn_guradar_form_empresas').text('Guardar Cambios');
    $('#title_form_empresas').text('Editar Empresa');
    ajaxRequest({url: '_request/EmpresasRequest.php', data: {opcion: 'edit', id: id}}, function (data) {
        if (data.result) {
            $('#input_empresas_rif').val(data.rif);
            $('#input_empresas_nombre').val(data.nombre);
            $('#input_empresas_responsable').val(data.responsable);
            $('#input_empresas_telefono').val(data.telefono);
            $('#empresas_id').val(data.id);
            $('#empresas_opcion').val('update');
            displayEmpresas('form');
        }
    });
}

$('#form_empresas').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let rif = $('#input_empresas_rif');
    let nombre = $('#input_empresas_nombre');
    let responsable = $('#input_empresas_responsable');
    let telefono = $('#input_empresas_telefono');


    if (!rif.inputmask('isComplete')) {
        procesar = false;
        rif.addClass('is-invalid');
        $('#error_input_empresas_rif').text('El rif es obligatorio');
    } else {
        rif
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!nombre.inputmask('isComplete')) {
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_input_empresas_nombre').text('El nombre es obligatorio');
    } else {
        nombre
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!responsable.inputmask('isComplete')) {
        procesar = false;
        responsable.addClass('is-invalid');
        $('#error_input_empresas_responsable').text('El responsable es obligatorio');
    } else {
        responsable
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!telefono.inputmask('isComplete')) {
        procesar = false;
        telefono.addClass('is-invalid');
        $('#error_input_empresas_telefono').text('El teléfono es obligatorio');
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
                        $('#error_input_empresas_rif').text(data.message);
                    }
                } else {
                    $('#div_empresas').html(data.html);
                    datatable('table_empresas');
                    displayEmpresas();
                }
            });

        } else {
            ajaxRequest({url: '_request/EmpresasRequest.php', data: $(this).serialize()}, function (data) {
                if (data.result) {
                    let table = $('#table_empresas').DataTable();
                    let tr = $('#tr_item_empresas_' + data.id);
                    table
                        .cell(tr.find('.empresa_rif')).data(data.rif)
                        .cell(tr.find('.empresa_nombre')).data(data.nombre)
                        .cell(tr.find('.empresa_responsable')).data(data.responsable)
                        .cell(tr.find('.empresa_telefono')).data(data.telefono)
                        .draw();
                    resetEmpresa();
                    displayEmpresas();
                } else {
                    if (data.error === 'datos_duplicados') {
                        rif.addClass('is-invalid');
                        $('#error_input_empresas_rif').text(data.message);
                    }
                }

            });

        }
    }

});

function destroyEmpresa(id) {
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

function reconstruirBuscarEmpresas(keyword) {
    ajaxRequest({ url: '_request/EmpresasRequest.php', data: { opcion: 'search', keyword: keyword}, html: 'si'  }, function (data) {
        $('#div_empresas').html(data.html);
        datatable('table_empresas');
        displayEmpresas();
    });
}

console.log('empresas');