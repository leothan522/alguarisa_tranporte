datatable('table_choferes')

inputmask('#input_choferes_cedula', 'numerico', 7, 8, '');
inputmask('#input_choferes_nombre', 'alfanumerico', 3, 100, ' ');
inputmaskTelefono('#input_choferes_telefono');



function displayChoferes(init = 'true') {
    verSpinner(true);
    $('.show_vehiculos_cerrar').attr('onclick', "display('choferes')");

    switch (init) {
        case "form":
            if ($("#row_form_choferes").hasClass("d-none")) {
                $('#row_form_choferes').removeClass('d-none');
            }
            if (!$("#row_table_choferes").hasClass("d-none")) {
                $('#row_table_choferes').addClass('d-none');
            }
            if (!$("#row_show_vehiculos").hasClass("d-none")) {
                $('#row_show_vehiculos').addClass('d-none');
            }
            break;

        case "show":
            if (!$("#row_form_choferes").hasClass("d-none")) {
                $('#row_form_choferes').addClass('d-none');
            }
            if (!$("#row_table_choferes").hasClass("d-none")) {
                $('#row_table_choferes').addClass('d-none');
            }
            if ($("#row_show_vehiculos").hasClass("d-none")) {
                $('#row_show_vehiculos').removeClass('d-none');
            }
            break;

        default:
            if (!$("#row_form_choferes").hasClass("d-none")) {
                $('#row_form_choferes').addClass('d-none');
            }
            if ($("#row_table_choferes").hasClass("d-none")) {
                $('#row_table_choferes').removeClass('d-none');
            }
            if (!$("#row_show_vehiculos").hasClass("d-none")) {
                $('#row_show_vehiculos').addClass('d-none');
            }
            break;
    }

    verSpinner(false);
}
function initChoferes() {
    displayChoferes();
    $('#keyword_choferes').val('');
    ajaxRequest({url: '_request/ChoferesRequest.php', data: {opcion: 'index'}, html: true}, function (data) {
        $('#div_choferes').html(data.html);
        datatable('table_choferes');
    });
}
//buscar
$('#form_choferes_buscar').submit(function (e) {
    e.preventDefault();
    ajaxRequest({url: '_request/ChoferesRequest.php', data: $(this).serialize(), html: 'si'}, function (data) {
        $('#div_choferes').html(data.html);
        datatable('table_choferes');
        displayChoferes();
    });

});
function createChoferes() {
    $('#title_form_choferes').text('Nuevo Chofer');
    resetChofer();
    getVehiculos();
    getEmpresas();
    displayChoferes('form');
}
function getVehiculos() {
    ajaxRequest({url: '_request/ChoferesRequest.php', data: {opcion: 'get_vehiculos'}}, function (data) {
        if (data.result) {
            let select = $('#select_choferes_vehiculo');
            let vehiculos = data.listarVehiculos.length;
            select.empty();
            select.append('<option value="">Seleccione</option>');
            for (let i = 0; i < vehiculos; i++) {
                let id = data.listarVehiculos[i]['id'];
                let nombre = data.listarVehiculos[i]['nombre'];
                select.append('<option value="' + id + '">' + nombre + '</option>');
            }
        }
    });
}
function destroyChofer(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            let valor_x = $('#chofer_input_hidden_x').val();
            ajaxRequest({url: '_request/ChoferesRequest.php', data: {opcion: 'destroy', id: id}}, function (data) {
                if (data.result) {

                    let table = $('#table_choferes').DataTable();
                    let item = $('#btn_eliminar_chofer_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();

                    $('#paginate_leyenda').text(data.total);
                    valor_x = valor_x - 1;
                    if (valor_x === 0) {
                        reconstruirTablaChofer();
                    } else {
                        $('#chofer_input_hidden_x').val(valor_x);
                    }
                }
            });

        }
    });
}
function resetChofer() {
    $('#input_choferes_cedula')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid')
    ;
    $('#input_choferes_nombre')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid')
    ;
    $('#input_choferes_telefono')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid')
    ;
    $('.select_guias_empresas')
        .val('')
        .trigger('change')
        .removeClass('is-valid')
        .removeClass('is-invalid')
    ;
    $('#select_choferes_vehiculo')
        .val('')
        .trigger('change')
        .removeClass('is-valid')
        .removeClass('is-invalid')
    ;
    $('#choferes_opcion').val('store');
}
$('#form_choferes').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let empresa = $('#select_choferes_empresa');
    let vehiculo = $('#select_choferes_vehiculo');
    let cedula = $('#input_choferes_cedula');
    let nombre = $('#input_choferes_nombre');
    let telefono = $('#input_choferes_telefono');

    if (empresa.val().length <= 0) {
        procesar = false;
        empresa.addClass('is-invalid');
        $('#error_select_choferes_empresa').text('La empresa es obligatoria');
    } else {
        empresa
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (vehiculo.val().length <= 0) {
        procesar = false;
        vehiculo.addClass('is-invalid');
        $('#error_select_choferes_vehiculo').text('El vehiculo es obligatorio');
    } else {
        vehiculo
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!cedula.inputmask('isComplete')) {
        procesar = false;
        cedula.addClass('is-invalid');
        $('#error_input_choferes_cedula').text('La cedula es obligatoria');
    } else {
        cedula
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!nombre.inputmask('isComplete')) {
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_input_choferes_nombre').text('El nombre es obligatorio');
    } else {
        nombre
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!telefono.inputmask('isComplete')) {
        procesar = false;
        telefono.addClass('is-invalid');
        $('#error_input_choferes_telefono').text('El telefono es obligatorio');
    } else {
        telefono
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar) {
        let opcion = $('#choferes_opcion').val();
        if (opcion === 'store') {
            ajaxRequest({url: '_request/ChoferesRequest.php', data: $(this).serialize(), html: 'si'}, function (data) {
                if (data.is_json) {
                    if (data.error === 'existe_chofer') {
                        cedula.addClass('is-invalid');
                        $('#error_input_choferes_cedula').text('La cedula ya esta registrada.')
                    }
                } else {
                    $('#div_choferes').html(data.html);
                    datatable('table_choferes');
                    displayChoferes();
                }
            });
        } else {
            ajaxRequest({url: '_request/ChoferesRequest.php', data: $(this).serialize()}, function (data) {
                if (data.result) {
                    let btn = '<span class="btn btn-link btn-sm" onclick="showVehiculo(\'' + data.vehiculos_id + '\', \'choferes\')">' +
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
                    resetChofer();
                    displayChoferes();
                }
            });
        }

    }

});
function editChofer(id) {
    displayChoferes('form');
    verSpinner(true);
    $('#title_form_choferes').text('Editar Chofer');
    $('#btn_guradar_form_choferes').text('Guardar Cambios');
    resetChofer();

    getVehiculos();
    getEmpresas();

    ajaxRequest({url: '_request/ChoferesRequest.php', data: {opcion: 'edit', id: id}}, function (data) {
        if (data.result) {
            verSpinner(true);
            $('#input_choferes_cedula').val(data.cedula);
            $('#input_choferes_nombre').val(data.nombre);
            $('#input_choferes_telefono').val(data.telefono);
            $('#select_choferes_vehiculo')
                .val(data.vehiculos_id)
                .trigger('change');
            $('#choferes_opcion').val('update');
            $('#choferes_id').val(data.id);
            setTimeout(function () {
                $('.select_guias_empresas')
                    .val(data.empresas_id)
                    .trigger('change');
            }, 500);
        }
    });

}
function reconstruirBuscarChoferes(keyword) {
    ajaxRequest({url: '_request/ChoferesRequest.php', data: { opcion: 'search', keyword: keyword}, html: 'si'}, function (data) {
        $('#div_choferes').html(data.html);
        datatable('table_choferes');
        displayChoferes();
    });
}

function estatusChofer(id) {
    ajaxRequest({ url: "_request/ChoferesRequest.php", data: { opcion: "set_estatus", id: id}}, function (data) {
        if (data.result){
            let icon;
            if (data.estatus === 'inactivo'){
                icon = '<i class="fas fa-eye-slash"></i>';
            }else {
                icon = '<i class="fas fa-eye"></i>';
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

            let button = ' <div class="btn-group btn-group-sm"> ' +
                '                   <button type="button" class="btn btn-info" ' +
                '                   onclick="estatusChofer(\''+ id +'\')" id="btn_estatus_'+ id +'" '+ btn_estatus +' >\n' +
                '                   ' + icon +
                '                   </button>' +
                '                   <button type="button" class="btn btn-info" ' +
                '                   onclick="editChofer(\''+ id +'\')" '+ btn_editar +' >\n' +
                '                   <i class="fas fa-edit"></i>\n'+
                '                   </button>' +
                '                   <button type="button" class="btn btn-info" ' +
                '                   onclick="destroyChofer(\''+ id +'\')" id="btn_eliminar_chofer_'+ id +'"  '+ btn_eliminar +' >\n' +
                '                   <i class="far fa-trash-alt"></i>\n'+
                '                   </button>' +
                '               </div>';


            let table = $('#table_choferes').DataTable();
            let tr = $('#tr_item_choferes_' + id);
            table
                .cell(tr.find('.btns_choferes')).data(button)
                .draw();



        }
    });
}




console.log('choferes.js');