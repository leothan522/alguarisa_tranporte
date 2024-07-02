<form id="form_choferes">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span id="title_form_choferes">Title</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" onclick="displayChoferes()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">




            <div class="form-group">
                <label for="choferes_select_empresa">Empresa</label>
                <select class="select2bs4" data-placeholder="Seleccionar" name="empresas_id" id="select_choferes_empresa">
                    <option value="">Seleccione</option>
                </select>
                <div class="invalid-feedback" id="error_select_choferes_empresa"></div>
            </div>

            <div class="form-group">
                <label for="select_choferes_vehiculo">Vehículo</label>
                <select class="select2bs4" data-placeholder="Seleccionar" name="vehiculos_id" id="select_choferes_vehiculo">
                    <option value="">Seleccione</option>
                </select>
                <div class="invalid-feedback" id="error_select_choferes_vehiculo"></div>
            </div>

            <div class="form-group">
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
            </div>

            <div class="form-group">
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
            </div>

            <div class="form-group">
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
            </div>


        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" placeholder="id" name="choferes_id" id="choferes_id">
            <input type="hidden" name="opcion" value="store" id="choferes_opcion">
            <button type="submit" class="btn btn-primary" id="btn_guradar_form_choferes">
                Guardar
            </button>
            <button type="reset" class="btn btn-default float-right" onclick="displayChoferes()">Cancelar</button>
        </div>
    </div>
</form>