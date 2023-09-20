//validamos campos para los municpios
$('#municipio_nombre').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");
$('#parroquia_nombre').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");

//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_municipios');

//Aqui se hace la solicitud ajax para registrar un nuevo municipio o editar uno existente
$('#form_territorio_municipio').submit(function (e) {
    e.preventDefault();
    let municipio = $('#municipio_nombre');
    let procesar = true;

    if (!municipio.inputmask('isComplete')){
        procesar = false;
        municipio.addClass('is-invalid');
        $('#error_municipio_nombre').text('El Nombre es obligatorio, debe tener al menos 4 caracteres.');
    } else {
        municipio.removeClass('is-invalid');
        municipio.addClass('is-valid');
    }

    if (procesar){
        verSpinner(true);
        $.ajax({
            type: 'POST',
            url: 'procesar_municipio.php',
            data: $(this).serialize(),
            success: function (response) {
                let data = JSON.parse(response);

                if (data.result){

                    let table = $('#tabla_municipios').DataTable();

                    if (data.nuevo){
                        //es nuevo registro
                        let button_parroquia = '<div class="text-center"><div class="btn-group btn-group-sm text-center">\n' +
                            '                                <button type="button" class="btn btn-success" onclick="filtrarParroquias('+ data.id +')">\n' +
                            '                                    '+ data.parroquias +'\n' +
                            '                                </button>\n' +
                            '                            </div></div>';

                        let buttons = '<div class="btn-group btn-group-sm">\n' +
                            '                                <button type="button" class="btn btn-info" onclick="editMunicipio('+ data.id +')" data-toggle="modal" data-target="#modal-municipios">\n' +
                            '                                    <i class="fas fa-edit"></i>\n' +
                            '                                </button>\n' +
                            '                                <button type="button" class="btn btn-info" onclick="destroyMunicipio('+ data.id +')" id="btn_eliminar_'+ data.id +'">\n' +
                            '                                    <i class="far fa-trash-alt"></i>\n' +
                            '                                </button>\n' +
                            '                            </div>';
                        table.row.add([
                            data.item,
                            data.nombre,
                            button_parroquia,
                            buttons
                        ]).draw();

                        let nuevo = $('#tabla_municipios tr:last');
                        nuevo.attr('id', 'tr_item_' + data.id);
                        nuevo.find("td:eq(1)").addClass('nombre');
                        nuevo.find("td:eq(2)").addClass('parroquias');
                    }else {
                        //estoy editando
                        let tr = $('#tr_item_' + data.id);
                        table
                            .cell(tr.find('.nombre')).data(data.nombre)
                            .draw();
                        //modifico el nombre municipio en parroquias vinculadas
                        let table_parroquias = $('#tabla_parroquias').DataTable();
                        let parroquias = data.parroquias.length;
                        let tr_parroquia;
                        for (let i = 0; i < parroquias; i++) {
                            tr_parroquia = $('#tr_item_p_' + data.parroquias[i]['id']);
                            table_parroquias
                                .cell(tr_parroquia.find('.municipio')).data(data.nombre)
                                .draw()
                        }

                    }

                    resetMunicipio();
                    $('#municipio_btn_reset').click();
                    $('#paginate_leyenda_municipio').text(data.total);


                }else {
                    if (data.error === 'nombre_duplicado'){
                        $('#municipio_nombre').addClass('is-invalid');
                        $('#error_municipio_nombre').text(data.message);
                    }
                }

                if (data.alerta) {
                    Alerta.fire({
                        icon: data.icon,
                        title: data.title,
                        text: data.message
                    });
                } else {
                    /*Toast.fire({
                        icon: data.icon,
                        text: data.title
                    });*/
                }
                verSpinner(false);
            }
        });
    }
});

//esta funsion sirve para resetear los datos del modal
function resetMunicipio() {
    $('#municipio_nombre').val('');
    $('#municipio_nombre').removeClass('is-valid');
    $('#municipio_nombre').removeClass('is-invalid');
    $('#municipio_id').val('');
    $('#municipio_opcion').val('guardar_municipio');
    $('#municipio_title').text('Crear Municipio');
}

//aqui se cambia el modal para editan los municipios segun el id que se pasa
function editMunicipio(id) {
    verSpinner(true);
    resetMunicipio();
    $('#municipio_title').text('Editar Municipio');
    $.ajax({
        type: 'POST',
        url: 'procesar_municipio.php',
        data: {
            opcion: 'get_municipio',
            id: id
        },
        success: function (response) {
            let data = JSON.parse(response);


            if (data.result){
                $('#municipio_nombre').val(data.nombre);
                $('#municipio_id').val(data.id);
                $('#municipio_opcion').val('editar_municipio');
                $('#municipio_btn_button').text('Guardar Cambios');
            }else{
                $('#municipio_btn_reset').click();
            }

            if (data.alerta) {
                Alerta.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.message
                });
            } else {
                /*Toast.fire({
                    icon: data.icon,
                    text: data.title
                });*/
            }
            verSpinner(false);
        }
    });
}

//esta es la funcion para eliminar un municipio
function destroyMunicipio(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            verSpinner(true);
            $.ajax({
                type: 'POST',
                url: 'procesar_municipio.php',
                data: {
                    opcion: 'eliminar_municipio',
                    id: id
                },
                success: function (response) {
                    let data = JSON.parse(response);

                    if (data.result){
                        let table = $('#tabla_municipios').DataTable();
                        let item = $('#btn_eliminar_' + id).closest('tr');
                        table
                            .row(item)
                            .remove()
                            .draw();
                        $('#paginate_leyenda_municipio').text(data.total);

                        //elimno las parroquias
                        let tabla_prroquias = $('#tabla_parroquias').DataTable();
                        let parroquias = data.parroquias.length;
                        let item_parroquia;
                        for (let i = 0; i < parroquias; i++) {
                            item_parroquia = $('#btn_eliminar_p_' + data.parroquias[i]['id']).closest('tr');
                            tabla_prroquias
                                .row(item_parroquia)
                                .remove()
                                .draw();
                        }

                        $('#paginate_leyenda_parroquia').text(data.total_parroquias);

                    }

                    if (data.alerta) {
                        Alerta.fire({
                            icon: data.icon,
                            title: data.title,
                            text: data.message
                        });
                    } else {
                        Toast.fire({
                            icon: data.icon,
                            text: data.title
                        });
                    }
                    verSpinner(false);
                }
            });

        }
    });
}

console.log('hi municipio!');