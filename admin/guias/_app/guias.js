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

console.log('guias.js')