<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <span id="title_form_vehiculos">Title</span>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="displayVehiculos()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <div class="form-group">
            <label for="vehiculos_select_empresa">Empresa</label>
            <select class="select2bs4 select_guias_empresas" data-placeholder="Seleccionar" name="empresas_id"
                    id="select_vehiculos_empresa">
                <option value="">Seleccione</option>
            </select>
            <div class="invalid-feedback" id="error_select_vehiculos_empresa"></div>
        </div>

        <div class="form-group">
            <label for="input_vehiculos_placa_batea">Placa Batea</label>
            <div class="input-group">
                <input type="text" class="form-control" name="placa_batea" id="input_vehiculos_placa_batea">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_input_vehiculos_placa_batea"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input_vehiculos_placa_chuto">Placa Chuto</label>
            <div class="input-group">
                <input type="text" class="form-control" name="placa_chuto" id="input_vehiculos_placa_chuto">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_input_vehiculos_placa_chuto"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="select_vehiculos_tipo">Tipo</label>
            <select class="select2bs4" data-placeholder="Seleccionar" name="tipos_id" id="select_vehiculos_tipo">
                <option value="">Seleccione</option>
            </select>
            <div class="invalid-feedback" id="error_select_vehiculos_tipo"></div>
        </div>


        <div class="form-group">
            <label for="input_vehiculos_marca">Marca</label>
            <div class="input-group">
                <input type="text" class="form-control" name="marca" id="input_vehiculos_marca">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-tag"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_input_vehiculos_marca"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input_vehiculos_color">Color</label>
            <div class="input-group">
                <input type="text" class="form-control" name="color" id="input_vehiculos_color">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-palette"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_input_vehiculos_color"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input_vehiculos_capasidad">Capacidad</label>
            <div class="input-group">
                <input type="text" class="form-control" name="capasidad" id="input_vehiculos_capasidad">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-weight"></i>
                    </div>
                </div>
                <div class="invalid-feedback" id="error_input_vehiculos_capasidad"></div>
            </div>
        </div>


    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <input type="hidden" placeholder="id" name="vehiculos_id" id="vehiculos_id">
        <input type="hidden" name="opcion" value="store" id="vehiculos_opcion">
        <button type="submit" class="btn btn-primary" id="btn_guradar_form_vehiculos">
            Guardar
        </button>
        <button type="reset" class="btn btn-default float-right" onclick="displayVehiculos()">Cancelar</button>
    </div>
</div>

