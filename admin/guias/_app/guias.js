datatable('table_guias');
$("#navbar_buscar").removeClass('d-none');
inputmask('#guias_num_init', 'numerico', 1, 8, '');

function display(origen) {
    if (origen === 'choferes'){
        displayChoferes();
    }

    if (origen === 'vehiculos'){
        displayVehiculos();
    }
}

function showVehiculo(id, origen) {
    ajaxRequest( { url: '_request/GuiasRequest.php', data: { opcion: 'get_vehiculo', id: id } }, function (data) {
        if (data.result){
            $('.modal_vehiculo_placa_batea').text(data.placa_batea);
            $('.modal_vehiculo_marca').text(data.marca);
            $('.modal_vehiculo_tipo').text(data.tipo);
            $('.modal_vehiculo_color').text(data.color_vehiculo);
            if (data.placa_chuto.length <= 0){
                $('.modal_placa_chuto').addClass('d-none');
            }else {
                $('.modal_placa_chuto').removeClass('d-none');
                $('.modal_vehiculo_placa_chuto').text(data.placa_chuto);
            }

            $('.modal_empresa_rif').text(data.rif);
            $('.modal_empresa_nombre').text(data.nombre);
            $('.modal_empresa_responsable').text(data.responsable);
            $('.modal_empresa_telefono').text(data.telefono);
            if (origen === 'choferes'){
                displayChoferes('show');
            }else {
                displayVehiculos('show');
            }
        }
    });
}

function getEmpresas() {
    ajaxRequest({ url: '_request/GuiasRequest.php', data: { opcion: 'get_empresas' } }, function (data) {
        if (data.result){
            let select = $('.select_guias_empresas');
            let empresas = data.listarEmpresas.length;
            select.empty();
            select.append('<option value="">Seleccione</option>');
            for (let i = 0; i < empresas; i++) {
                let id = data.listarEmpresas[i]['id'];
                let nombre = data.listarEmpresas[i]['nombre'];
                select.append('<option value="' + id + '">' + nombre + '</option>');
            }
        }
    });
}

$('#formulari_guia_init').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let num_guia = $('#guias_num_init');

    if (!num_guia.inputmask('isComplete')  || num_guia.val() <= 0){
        procesar = false;
        num_guia.addClass('is-invalid');
    }

    if (procesar){
        ajaxRequest({url: '_request/GuiasRequest.php', data: $(this).serialize() }, function (data) {

        });
    }
})

function generarPDF(id) {
    $('#btn_form_table_ver_pdf_formato_'+ id).click();
    //$('#modal_guia_btn_editar').attr('disabled', 'disabled');
}

$('#navbar_form_buscar').submit(function (e) {
   e.preventDefault();
    let keyword = $('#navbar_input_buscar').val();
   ajaxRequest({url: '_request/GuiasRequest.php', data: { opcion: 'search', keyword: keyword},html: 'si'}, function (data) {
       $('#div_guias').html(data.html);
       datatable('table_guias');
   });
});

function resetGuia() {
    $('#form_guias_tipo')
        .removeClass('is-valid')
        .removeClass('is-invalid')
        .val('')
        .trigger('change');
    $('#form_guias_codigo')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#form_guias_vehiculo')
        .removeClass('is-valid')
        .removeClass('is-invalid')
        .val('')
        .trigger('change');
    $('#form_guias_chofer')
        .removeClass('is-valid')
        .removeClass('is-invalid')
        .val('')
        .trigger('change');
    $('#form_guias_origen')
        .removeClass('is-valid')
        .removeClass('is-invalid')
        .val('')
        .trigger('change');
    $('#form_guias_destino')
        .removeClass('is-valid')
        .removeClass('is-invalid')
        .val('')
        .trigger('change');
    $('#form_guias_fecha')
        .removeClass('is-valid')
        .removeClass('is-invalid')
        .val('');
    $('#form_guias_precinto').val('');
    $('#form_guias_precinto_2').val('');
    $('#form_guias_precinto_3').val('');
    $('#guias_opcion').val('store');
    $('#error_select_guias_tipo').text('');
    $('#error_select_guias_vehiculo').text('');
    $('#error_select_guias_chofer').text('');
    $('#error_select_guias_origen').text('');
    $('#error_select_guias_destino').text('');
    $('#error_input_guias_fecha').text('');

    let contadorGuia = document.getElementById('contador_guia');
    for (let i = 1; i <= contadorGuia.value; i++) {
        if (i > 1){
            if ($('#item_guia_'+ i).length){
                btnRemoveGuia('item_guia_' + i);
            }
        }
    }
    contadorGuia.value = 1;
    contadorGuia.dataset.contadorGuia = 1;
    $('#cantidad_1')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#descripcion_1')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');

    if (!$('#mensaje_error_guia').hasClass("d-none")){
        $('#mensaje_error_guia').addClass("d-none");
    }

}
function reconstruirTablaGuias() {
    ajaxRequest({url: '_request/GuiasRequest.php', data: { opcion: 'index'},html: 'si'}, function (data) {
        $('#div_guias').html(data.html);
        datatable('table_guias');
    });
}
function displayGuias(init = 'true') {
    verSpinner(true);

    switch (init) {
        case "form":
            $('#div_btn_show').addClass("d-none");
            $('#div_btn_form').removeClass("d-none");
            if ($("#row_form_guias").hasClass("d-none")) {
                $('#row_form_guias').removeClass('d-none');
            }

            if (!$("#row_show_guias").hasClass("d-none")) {
                $('#row_show_guias').addClass('d-none');
            }
            break;

        case "show":
            $('#div_btn_show').removeClass('d-none');
            $('#div_btn_form').addClass('d-none');
            if (!$("#row_form_guias").hasClass("d-none")) {
                $('#row_form_guias').addClass('d-none');
            }

            if ($("#row_show_guias").hasClass("d-none")) {
                $('#row_show_guias').removeClass('d-none');
            }
            break;

        default:
            if ($("#row_form_guias").hasClass("d-none")) {
                $('#row_form_guias').addClass('d-none');
            }

            if (!$("#row_show_guias").hasClass("d-none")) {
                $('#row_show_guias').addClass('d-none');
            }
            break;
    }

    verSpinner(false);
}
function rellenarForm(data, option = 'create') {
    let selectTipo = $('#form_guias_tipo');
    let tipo = data.listarTipos.length;
    selectTipo.empty();
    selectTipo.append('<option value="">Seleccione</option>');
    for (let i = 0; i < tipo; i++) {
        let id = data.listarTipos[i]['id'];
        let nombre = data.listarTipos[i]['nombre'];
        selectTipo.append('<option value="' + id + '">' + nombre + '</option>');
    }

    let selectVehiculo = $('#form_guias_vehiculo');
    let vehiculos = data.listarVehiculos.length;
    selectVehiculo.empty();
    selectVehiculo.append('<option value="">Seleccione</option>');
    for (let i = 0; i < vehiculos; i++) {
        let id = data.listarVehiculos[i]['id'];
        let placa = data.listarVehiculos[i]['placa'];
        let tipo = data.listarVehiculos[i]['tipo'];
        selectVehiculo.append('<option value="' + id + '">' + placa + ' - ' + tipo + '</option>');
    }

    let selectChofer = $('#form_guias_chofer');
    let chofer = data.listarChofer.length;
    selectChofer.empty();
    selectChofer.append('<option value="">Seleccione</option>');
    for (let i = 0; i < chofer; i++) {
        let id = data.listarChofer[i]['id'];
        let cedula = data.listarChofer[i]['cedula'];
        let nombre = data.listarChofer[i]['nombre'];
        selectChofer.append('<option value="' + id + '">' + cedula + ' - ' + nombre + '</option>');
    }

    let selecOrigen = $('#form_guias_origen');
    let origen = data.listarTerritorios.length;
    selecOrigen.empty();
    selecOrigen.append('<option value="">Seleccione</option>');
    for (let i = 0; i < origen; i++) {
        let id = data.listarTerritorios[i]['id'];
        let nombre = data.listarTerritorios[i]['nombre'];
        selecOrigen.append('<option value="' + id + '">' + nombre + '</option>');
    }

    let selecDestino = $('#form_guias_destino');
    let destino = data.listarTerritorios.length;
    selecDestino.empty();
    selecDestino.append('<option value="">Seleccione</option>');
    for (let i = 0; i < destino; i++) {
        let id = data.listarTerritorios[i]['id'];
        let nombre = data.listarTerritorios[i]['nombre'];
        selecDestino.append('<option value="' + id + '">' + nombre + '</option>');
    }

    $('#form_guias_fecha').val(data.hoy);

    if (option !== 'create'){
        //colocar datos de la guia a editar
        $('#form_guias_tipo')
            .val(data.tipo)
            .trigger('change');
        $('#form_guias_codigo').val(data.codigo);
        $('#form_guias_vehiculo')
            .val(data.vehiculo)
            .trigger('change');
        $('#form_guias_chofer')
            .val(data.chofer)
            .trigger('change');
        $('#form_guias_origen')
            .val(data.origen)
            .trigger('change');
        $('#form_guias_destino')
            .val(data.destino)
            .trigger('change');
        $('#form_guias_fecha').val(data.fecha);
        $('#form_guias_precinto').val(data.precinto);
        $('#form_guias_precinto_2').val(data.precinto_2);
        $('#form_guias_precinto_3').val(data.precinto_3);

        let total_items = $('#items_guias');
        let cargamento = data.listarCarga.length;
        let html = '';
        let item = 0;
        let btn = '';
        for (let i = 0; i < cargamento; i++){
            item = i+1;
            let cantidad = data.listarCarga[i]['cantidad'];
            let descripcion = data.listarCarga[i]['descripcion'];
            if (item > 1){
                btn = '<button type="button" class="btn" onclick="btnRemoveGuia(\'item_guia_' + item + '\')">' +
                    '      <i class="fas fa-minus-circle text-danger"></i>' +
                    '</button>';
            }else {
                btn = '<span class="btn">&nbsp;</span>';
            }

            html += ' <div class="row p-0" id="item_guia_'+ item +'">\n' +
                '          <div class="col-3">\n' +
                '              <input type="text" class="form-control input_guias_carga" value="'+ cantidad +'" name="cantidad_'+ item +'" placeholder="Cant."  id="cantidad_'+ item +'"/>\n' +
                '          </div>\n' +
                '          <div class="col-7">\n' +
                '              <input type="text" class="form-control input_guias_carga" value="'+ descripcion +'" name="descripcion_'+ item +'" placeholder="Descripción" id="descripcion_'+ item +'"/>\n' +
                '          </div>\n' +
                '          <div class="col-2">\n' +
                btn +
                '          </div>\n' +
                '      </div>';
        }
        total_items.html(html);
        let contador = document.getElementById('contador_guia');
        contador.value = cargamento;
        contador.dataset.contador = cargamento;
        $('#guias_opcion').val('update');
        $('#guias_id').val(data.id);
    }

    displayGuias('form');
}
function createGuia() {
    $('#title_form_guias').text('Nueva Guía');
    $('#icono_span_title').html('<i class="fas fa-file"></i>');
    $('#btn_cerrar_modal_guia')
        .attr("data-dismiss", "modal")
        .text('Cerrar');
    resetGuia();
    ajaxRequest({url: '_request/GuiasRequest.php', data: { opcion: 'create' } }, function (data) {
        if (data.result){
            //rellenar formulario
            rellenarForm(data);
        }
    });
}
function showGuia(id) {

    ajaxRequest({url: '_request/GuiasRequest.php', data: {opcion: 'show', id: id}}, function (data) {
        if (data.result){
            $('#show_guias_destino').text(data.destino);
            $('#show_guias_codigo').text(data.codigo);
            $('#show_guias_fecha').text(data.fecha);
            $('#show_guias_tipo').text(data.tipo);
            $('#show_guias_origen').text(data.origen);
            $('#show_guias_tipo_vehiculo').text(data.vehiculo_tipo);
            $('#show_guias_placa_batea').text(data.vehiculo_placa_batea);
            if (data.vehiculo_placa_chuto.length > 0){
                $('#li_show_placa_chuto').removeClass('d-none');
                $('#show_guias_placa_chuto').text(data.vehiculo_placa_chuto);
            }else {
                $('#li_show_placa_chuto').addClass('d-none');
            }
            $('#show_guias_marca').text(data.vehiculo_marca);
            $('#show_guias_color').text(data.vehiculo_color);
            $('#show_guias_capacidad').text(data.vehiculo_capacidad);
            $('#show_guias_chofer').text(data.chofer);
            $('#show_guias_cedula').text(data.chofer_cedula);
            $('#show_guias_telefono').text(data.chofer_telefono);

            if (data.precinto_1 === 'precinto_vacio'){
                $('#li_modal_guias_precinto_1').addClass('d-none');
            }else {
                $('#li_modal_guias_precinto_1').removeClass('d-none');
            }

            if (data.precinto_2 === 'precinto_vacio'){
                $('#li_modal_guias_precinto_2').addClass('d-none');
            }else {
                $('#li_modal_guias_precinto_2').removeClass('d-none');
            }

            if (data.precinto_3 === 'precinto_vacio'){
                $('#li_modal_guias_precinto_3').addClass('d-none');
            }else {
                $('#li_modal_guias_precinto_3').removeClass('d-none');
            }

            $('#show_guias_precinto_1').text(data.precinto_1);
            $('#show_guias_precinto_2').text(data.precinto_2);
            $('#show_guias_precinto_3').text(data.precinto_3);
            if (data.listarCarga !== 'cargamento_vacio'){
                let cargamento = data.listarCarga.length;
                $('#show_guias_table_cargamento').empty();
                for (let i = 0; i < cargamento; i++) {
                    let cantidad = data.listarCarga[i]['cantidad'];
                    let descripcion = data.listarCarga[i]['descripcion'];

                    let row = '<tr>\n' +
                        '         <td class="text-right pr-3"> '+cantidad+'</td>\n' +
                        '         <td class="text-left">'+descripcion+'</td>\n' +
                        '      </tr>';

                    $('#show_guias_table_cargamento').append(row);

                }
                $('#show_table_ocultar').removeClass('d-none');
                $('#show_guias_cargamento').text('');
            }else {
                $('#show_table_ocultar').addClass('d-none');
                $('#show_guias_cargamento').text('Sin Carga');
            }


            if (data.estatus > 0){
                $('#texto_guia_anulada').addClass('d-none');
                $('#modal_guia_btn_editar').removeClass('d-none');
                $('#modal_guia_btn_descargar').removeClass('d-none');
                $('#modal_guia_btn_anular').removeClass('d-none');

                $('#modal_guia_btn_editar').attr('onclick', 'editGuia('+id+')');
                $('#modal_guia_btn_descargar').attr('onclick', 'generarPDF('+id+')');
                $('#modal_guia_btn_anular').attr('onclick', 'destroy('+id+')');
            }else {
                let anulada = '&nbsp;<i class="fas fa-ban text-danger mt-2"></i></i>&nbsp; <span class="text-danger text-bold">Guía Anulada</span>';
                $('#texto_guia_anulada').removeClass('d-none');
                $('#texto_guia_anulada').html(anulada);
                $('#modal_guia_btn_editar').addClass('d-none');
                $('#modal_guia_btn_descargar').addClass('d-none');
                $('#modal_guia_btn_anular').addClass('d-none');
            }
            if (data.role >= 99){
                $('#modal_guia_btn_eliminar')
                    .removeClass('d-none');
                $('#modal_guia_btn_eliminar').click(function () {
                   $('#btn_eliminar_guia_'+id).click();
                });
            }else {
                $('#modal_guia_btn_eliminar').addClass('d-none');
            }

            $('#btn_cerrar_modal_guia')
                .removeAttr('onclick')
                .attr("data-dismiss", "modal")
                .text('Cerrar');

            displayGuias('show');
        }
    });
}
function editGuia(id) {

    resetGuia();

    $('#modal_guia_btn_guardar').text('Guardar Cambios');
    $('#title_form_guias').text('Editar Guia');
    $('#icono_span_title').html('<i class="fas fa-edit"></i>');
    $('#btn_cerrar_modal_guia')
        .removeAttr("data-dismiss")
        .attr("type", "button")
        .attr("onclick", "showGuia("+id+")")
        .text('Cancelar');

    $('#form_guias_tipo').attr('oninput', 'tipoGuia(this.value, "\'update\'", "'+id+'")');

    ajaxRequest({url: '_request/GuiasRequest.php', data: {opcion: 'edit', id: id}}, function (data) {
        if (data.result){
            //rellenar formulario
            rellenarForm(data, 'edit');
        }
    });

}
function addItemGuia() {
    let contador = document.getElementById("contador_guia");
    let valor_actual = contador.dataset.contador;
    let valor_nuevo = parseInt(valor_actual) + 1;
    contador.dataset.contador = valor_nuevo;
    let input_actual = contador.value;
    let input_nuevo = parseInt(input_actual) + 1;
    contador.value = input_nuevo;
    let content = '' +
        ' <div class="row p-0" id="item_guia_'+ input_nuevo +'">\n' +
        '                        <div class="col-3">\n' +
        '                            <input type="text" class="form-control input_guias_carga" name="cantidad_'+ input_nuevo +'" placeholder="Cant."  id="cantidad_'+ input_nuevo +'"/>\n' +
        '                        </div>\n' +
        '                        <div class="col-7">\n' +
        '                            <input type="text" class="form-control input_guias_carga" name="descripcion_'+ input_nuevo +'" placeholder="Descripción" id="descripcion_'+ input_nuevo +'"/>\n' +
        '                        </div>\n' +
        '                        <div class="col-2">\n' +
        '                           <button type="button" class="btn" onclick="btnRemoveGuia(\'item_guia_' + input_nuevo + '\')">' +
        '                               <i class="fas fa-minus-circle text-danger"></i>' +
        '                           </button>' +
        '                        </div>\n' +
        '                    </div>';

    $('#items_guias').append(content);
}
function btnRemoveGuia(item) {
    let contador = document.getElementById("contador_guia");
    let row = document.getElementById(item);
    let valor_actual = contador.dataset.contador;
    let valor_nuevo = parseInt(valor_actual) - 1;
    contador.dataset.contador = valor_nuevo;
    row.remove();
}
$('#form_guias').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let tipo = $('#form_guias_tipo');
    let codigo = $('#form_guias_codigo');
    let vehiculo = $('#form_guias_vehiculo');
    let chofer = $('#form_guias_chofer');
    let origen = $('#form_guias_origen');
    let destino = $('#form_guias_destino');
    let fecha = $('#form_guias_fecha');
    let carga = $('.input_guias_carga');
    let opcion = $('#guias_opcion').val();


    if (tipo.val().length <= 0) {
        procesar = false;
        tipo.addClass('is-invalid');
        $('#error_select_guias_tipo').text('El tipo es obligatorio');
    } else {
        tipo
            .removeClass('is-invalid')
            .addClass('is-valid');
        $('#error_select_guias_tipo').text('');

    }

    if (vehiculo.val().length <= 0) {
        procesar = false;
        vehiculo.addClass('is-invalid');
        $('#error_select_guias_vehiculo').text('El vehiculo es obligatorio');
    } else {
        vehiculo
            .removeClass('is-invalid')
            .addClass('is-valid');
        $('#error_select_guias_vehiculo').text('');
    }

    if (chofer.val().length <= 0) {
        procesar = false;
        chofer.addClass('is-invalid');
        $('#error_select_guias_chofer').text('El chofer es obligatorio');
    } else {
        chofer
            .removeClass('is-invalid')
            .addClass('is-valid');
        $('#error_select_guias_chofer').text('');
    }

    if (origen.val().length <= 0) {
        procesar = false;
        origen.addClass('is-invalid');
        $('#error_select_guias_origen').text('El origen es obligatorio');
    } else {
        origen
            .removeClass('is-invalid')
            .addClass('is-valid');
        $('#error_select_guias_origen').text('');
    }

    if (destino.val().length <= 0) {
        procesar = false;
        destino.addClass('is-invalid');
        $('#error_select_guias_destino').text('El destino es obligatorio');
    } else if (destino.val() === origen.val()) {
        procesar = false;
        destino.addClass('is-invalid');
        $('#error_select_guias_destino').text('El destino no puede ser igual al origen');
    } else {
        destino
            .removeClass('is-invalid')
            .addClass('is-valid');
        $('#error_select_guias_destino').text('');
    }

    if (fecha.val().length <= 0) {
        procesar = false;
        fecha.addClass('is-invalid');
        $('#error_input_guias_fecha').text('La fecha es es obligatoria');
    } else {
        fecha
            .removeClass('is-invalid')
            .addClass('is-valid');
        $('#error_input_guias_fecha').text('');
    }

    carga.each(function () {
        let valor_item = $(this).val();

        if (valor_item.length <= 0){
            procesar = false;
            $(this).addClass('is-invalid');
            $('#mensaje_error_guia').removeClass('d-none')
        }else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            if (!$('#mensaje_error_guia').hasClass("d-none")){
                $('#mensaje_error_guia').addClass("d-none");
            }
            $('#mensaje_error_guia').addClass('d-none');
        }
    });

    if (procesar){
        if (opcion === 'store'){
            let num_init_guias = $('#guias_num_init').val();
            ajaxRequest({url: '_request/GuiasRequest.php', data: $(this).serialize(), html: 'si'}, function (data) {
                if (!data.is_json){
                    $('#btn_cerrar_modal_guia').click();
                    num_init_guias = parseInt(num_init_guias) + 1;
                    $('#guias_num_init').val(num_init_guias);
                    $('#div_guias').html(data.html);
                    datatable('table_guias');
                }else {
                    if (data.error === 'existe_guia'){
                        codigo.addClass('is-invalid');
                    }

                    if (data.error === 'no_ruta'){
                        origen
                            .removeClass('is-valid')
                            .addClass('is-invalid');
                        destino
                            .removeClass('is-valid')
                            .addClass('is-invalid');
                    }
                }
            });
        }else {
            ajaxRequest({url: '_request/GuiasRequest.php', data: $(this).serialize()}, function (data) {
                if (data.result){
                    setRowGuias(data);
                    resetGuia();
                    $('#btn_cerrar_modal_guia').click();
                }else {
                    if (data.error === 'existe_guia'){
                        codigo.addClass('is-invalid');
                    }

                    if (data.error === 'no_ruta'){
                        origen.addClass('is-invalid');
                        destino.addClass('is-invalid');
                    }
                }
            });
        }
    }

});
function tipoGuia(value, accion, id) {
    if (value.length > 0){
        ajaxRequest({url: '_request/GuiasRequest.php', data: {opcion: 'get_codigo', tipos_id: value, accion, id}}, function (data) {
            $('#form_guias_codigo').val(data.codigo);
        });
    }
}
function destroy(id, opt = 'anular') {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            let countGuias = $('#count_guias').val();
            ajaxRequest({url: '_request/GuiasRequest.php', data: {opcion: 'destroy', id: id, opt: opt}}, function (data) {
                if (data.result){
                    if (data.opt === 'anular'){
                        $('#modal_guia_btn_editar').addClass('d-none');
                        $('#modal_guia_btn_descargar').addClass('d-none');
                        $('#modal_guia_btn_anular').addClass('d-none');
                        $('#texto_guia_anulada').removeClass('d-none');

                        setRowGuias(data);
                        $('#btn_guias_generar_pdf').attr("disabled", "disabled");
                        let anulada = '&nbsp;<i class="fas fa-ban text-danger mt-2"></i></i>&nbsp; <span class="text-danger text-bold">Guía Anulada</span>';
                        $('#texto_guia_anulada')
                            .removeClass('d-none')
                            .html(anulada);

                        if (data.role >= 99){
                            $('#modal_guia_btn_eliminar')
                                .removeClass('d-none')
                                .attr('onclick', 'destroy('+id+', \'delete\')');

                        }else {
                            $('#modal_guia_btn_eliminar').addClass('d-none');
                        }


                    }else {

                        let table = $('#table_guias').DataTable();
                        let item = $('#btn_eliminar_guia_' + id).closest('tr');
                        table
                            .row(item)
                            .remove()
                            .draw();
                        countGuias = countGuias - 1;
                        if (countGuias === 0){
                            reconstruirTablaGuias();
                        }else {
                            $('#count_guias').val(countGuias);
                        }

                        $('#paginate_leyenda').text(data.total);
                        $('#btn_cerrar_modal_guia')
                            .attr('data-dismiss', 'modal')
                            .click();
                    }

                }
            });
        }
    });
}
function setRowGuias(data) {
    let table = $('#table_guias').DataTable();
    let tr = $('#tr_item_guias_' + data.id);
    table
        .cell(tr.find('.guias_fecha')).data(data.fecha)
        .cell(tr.find('.guias_codigo')).data(data.codigo)
        .cell(tr.find('.guias_origen')).data(data.origen)
        .cell(tr.find('.guias_destino')).data(data.destino)
        .cell(tr.find('.guias_chofer')).data(data.chofer)
        .cell(tr.find('.guias_telefono')).data(data.chofer_telefono)
        .cell(tr.find('.guias_placa')).data(data.vehiculo_placa_batea)
        .draw();
}
function reconstruirBuscarGuia(keyword) {
    ajaxRequest({url: '_request/GuiasRequest.php', data: { opcion: 'search', keyword: keyword},html: 'si'}, function (data) {
        $('#div_guias').html(data.html);
        datatable('table_guias');
    });
}

console.log('guias.js')