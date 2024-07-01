<div class="row pl-1 pr-1">

    <div class="col-12">
        <div class="form-group">
            <label>Empresa</label>
            <select class="select2bs4" data-placeholder="Seleccionar" name="Vehiculos_select_empresa"
                    id="Vehiculos_select_empresa">
                <option value="">Seleccione</option>
                <?php foreach ($empresas as $empresa) { ?>
                    <option value="<?php echo $empresa['id'] ?>"><?php echo $empresa['rif']; ?>
                        - <?php echo ucfirst($empresa['nombre']); ?></option>
                <?php } ?>
            </select>
            <div class="invalid-feedback" id="error_Vehiculos_select_empresa"></div>
        </div>
    </div>


    <div class="col-12">
        <label for="exampleInputEmail1">Placa Batea</label>
        <div class="input-group">
            <input type="text" class="form-control" name="vehiculos_input_placa_batea" id="vehiculos_input_placa_batea">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-id-card"></i>
                </div>
            </div>
            <div class="invalid-feedback" id="error_vehiculos_input_placa_batea"></div>
        </div>
    </div>

    <div class="col-12">
        <label for="exampleInputEmail1">Placa Chuto</label>
        <div class="input-group">
            <input type="text" class="form-control" name="vehiculos_input_placa_chuto" id="vehiculos_input_placa_chuto">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-id-card"></i>
                </div>
            </div>
            <div class="invalid-feedback" id="error_vehiculos_input_placa_chuto"></div>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Tipo</label>
            <select class="select2bs4" data-placeholder="Seleccionar" name="Vehiculos_select_tipo"
                    id="Vehiculos_select_tipo">
                <option value="">Seleccione</option>
                <?php foreach ($tipos as $tipo) { ?>
                    <option value="<?php echo $tipo['id'] ?>"><?php echo $tipo['nombre']; ?> </option>
                <?php } ?>
            </select>
            <div class="invalid-feedback" id="error_Vehiculos_select_tipo"></div>
        </div>
    </div>

    <div class="col-12">
        <label for="exampleInputEmail1">Marca</label>
        <div class="input-group">
            <input type="text" class="form-control" name="vehiculos_input_marca" id="vehiculos_input_marca">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="invalid-feedback" id="error_vehiculos_input_marca"></div>
        </div>
    </div>

    <div class="col-12">
        <label for="exampleInputEmail1">Color</label>
        <div class="input-group">
            <input type="text" class="form-control" name="vehiculos_input_color" id="vehiculos_input_color">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="invalid-feedback" id="error_vehiculos_input_color"></div>
        </div>
    </div>

    <div class="col-12">
        <label for="exampleInputEmail1">Capacidad</label>
        <div class="input-group">
            <input type="text" class="form-control" name="vehiculos_input_capacidad" id="vehiculos_input_capacidad">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="invalid-feedback" id="error_vehiculos_input_capacidad"></div>
        </div>
    </div>