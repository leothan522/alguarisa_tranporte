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
}

$('#navbar_form_buscar').submit(function (e) {
   e.preventDefault();
    let keyword = $('#navbar_input_buscar').val();
   ajaxRequest({url: '_request/GuiasRequest.php', data: { opcion: 'search', keyword: keyword},html: 'si'}, function (data) {
       $('#div_guias').html(data.html);
       datatable('table_guias');
   });
});

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

function getSelectGuia() {
    ajaxRequest({url: '_request/GuiasRequest.php', data: {opcion: 'get_select_guia'}}, function (data) {
        if (data.result){

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



            displayGuias('form');
        }
    });
}

function showGuia(id) {

    ajaxRequest({url: '_request/GuiasRequest.php', data: {opcion: 'show_guia', id: id}}, function (data) {
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

            let cargamento = data.listarCarga.length;
            $('#show_guias_cargamento').empty();
            for (let i = 0; i < cargamento; i++) {
                let cantidad = data.listarCarga[i]['cantidad'];
                let descripcion = data.listarCarga[i]['descripcion'];

                let row = '<tr>\n' +
                    '         <td>'+cantidad+'</td>\n' +
                    '         <td class="text-left">'+descripcion+'</td>\n' +
                    '      </tr>'

                $('#show_guias_cargamento').append(row);

            }

            displayGuias('show');
            $('#modal_guia_btn_editar').attr('onclick', 'editGuia('+id+')');
            $('#modal_guia_btn_descargar').attr('onclick', 'generarPDF('+id+')');
        }
    });
}

console.log('guias.js')