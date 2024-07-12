<form id="form_rutas">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span id="title_form_rutas">Title</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" onclick="displayRutas()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">




            <div class="form-group">
                <label for="select_rutas_origen">Origen</label>
                <select class="select2bs4 select_rutas_municipios" data-placeholder="Seleccionar" name="origen" id="select_rutas_origen">
                    <option value="">Seleccione</option>
                </select>
                <div class="invalid-feedback" id="error_select_rutas_origen"></div>
            </div>

            <div class="form-group">
                <label class="col-12">
                    Trayecto
                    <button type="button" class="btn btn-link float-right" onclick="addItem()" id="btn_add">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                    <input type="hidden" value="1" name="contador" data-contador="1" placeholder="contador" id="contador">
                </label>
                <div id="items">
                    <div class="row" id="item_1">
                        <div class="col-10">
                            <input type="text" class="form-control input_rutas_items" name="ruta_1" placeholder="Lugar" id="ruta_1">
                        </div>
                        <div class="col-2">
                            <span class="btn">&nbsp;</span>
                        </div>
                    </div>
                </div>
                <small class="d-none" id="mensaje_error_ruta">
                    <small class="text-xs text-danger">
                        Todos los campos en la ruta son obligatorios
                    </small>
                </small>

            </div>

            <div class="form-group">
                <label for="select_rutas_destino">Destino</label>
                <select class="select2bs4 select_rutas_municipios" data-placeholder="Seleccionar" name="destino" id="select_rutas_destino">
                    <option value="">Seleccione</option>
                </select>
                <div class="invalid-feedback" id="error_select_rutas_destino"></div>
            </div>

           <!-- <div class="form-group">
                <label for="select_choferes_vehiculo">Vehículo</label>
                <select class="select2bs4" data-placeholder="Seleccionar" name="vehiculos_id" id="select_choferes_vehiculo">
                    <option value="">Seleccione</option>
                </select>
                <div class="invalid-feedback" id="error_select_choferes_vehiculo"></div>
            </div>-->

            <!--<div class="form-group">
                <label for="input_choferes_cedula">Cédula</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="cedula" id="input_choferes_cedula">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_input_choferes_cedula"></div>
                </div>
            </div>-->

            <!--<div class="form-group">
                <label for="input_choferes_nombre">Nombre y Apellido</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="nombre" id="input_choferes_nombre">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_input_choferes_nombre"></div>
                </div>
            </div>-->

            <!--<div class="form-group">
                <label for="exampleInputEmail1">Teléfono</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="telefono" id="input_choferes_telefono">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_input_choferes_telefono"></div>
                </div>
            </div>-->


        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" placeholder="id" name="rutas_id" id="rutas_id">
            <input type="hidden" name="opcion" value="store" id="rutas_opcion">
            <button type="submit" class="btn btn-primary" id="btn_guradar_form_rutas">
                Guardar
            </button>
            <button type="reset" class="btn btn-default float-right" onclick="displayRutas()">Cancelar</button>
        </div>
    </div>
</form>