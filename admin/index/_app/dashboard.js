function generarPDF(id) {
    $('#btn_form_table_ver_pdf_formato_'+ id).click();
}

function actualizar() {
    ajaxRequest({url: 'index/_request/DashboardRequest.php', data: {opcion: 'index'}}, function (data) {
        if (data.result){
            $('#info_total_guias').text(data.total_guias);
            $('#info_total_choferes').text(data.total_choferes);
            $('#info_total_vehiculos').text(data.total_vehiculos);
            $('#info_total_empresas').text(data.total_empresas);

            if (data.listarGuias !== 'guias_vacio'){
                let cargamento = data.listarGuias.length;
                $('#tbody_table_dashboard').empty();
                for (let i = 0; i < cargamento; i++) {
                    let id = data.listarGuias[i]['id'];
                    let fecha = data.listarGuias[i]['fecha'];
                    let codigo = data.listarGuias[i]['codigo'];
                    let destino = data.listarGuias[i]['destino'];
                    let chofer = data.listarGuias[i]['chofer'];
                    let estatus = data.listarGuias[i]['estatus'];

                    let btn = '';
                    let label = '';

                    if (estatus === 1){
                        btn += '<button type="button" class="btn btn-info btn-sm" onclick="generarPDF(\''+id+'\')" id="btn_guias_generar_pdf">\n' +
                            '                                <i class="fas fa-file-pdf"></i>\n' +
                            '                            </button>';

                        label += ''+codigo+'';
                    }else {
                        btn += '<button type="button" class="btn btn-info btn-sm" disabled>\n' +
                            '                                <i class="fas fa-file-pdf"></i>\n' +
                            '                            </button>';

                        label += '<span class="font-italic text-gray">'+codigo+'</span>&ensp;<i class="fas fa-backspace text-danger"></i>\n';
                    }
                    btn += '<form class="d-none" target="_blank" method="post" action="'+data.formato+'">\n' +
                        '                            <input type="text" name="guias_id" value="'+ id +'">\n' +
                        '                            <input type="submit" value="enviar" id="btn_form_table_ver_pdf_formato_'+id+'">\n' +
                        '                        </form>';




                    let row = '<tr>\n' +
                        '         <td class="text-center"> '+fecha+'</td>\n' +
                        '         <td class="text-uppercase text-center">'+label+'</td>\n' +
                        '         <td class="text-uppercase">'+destino+'</td>\n' +
                        '         <td class="text-uppercase">'+chofer+'</td>\n' +
                        '         <td class="text-center">'+btn+'</td>\n' +
                        '      </tr>';

                    $('#tbody_table_dashboard').append(row);

                }
                $('#row_table_ultimas_guias').removeClass('d-none');
            }else {
                $('#row_table_ultimas_guias').addClass('d-none');
            }

        }
    });
}

function irGuias(){
    window.location.replace("../admin/guias/");
}

console.log('dashboard.js');