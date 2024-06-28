<div class="row pl-1 pr-1">

    <div class="col-12">
        <div class="form-group">
            <label>Empresa</label>
            <select class="select2bs4" data-placeholder="Seleccionar" name="choferes_select_empresa"
                    id="choferes_select_empresa">
                <option value="">Seleccione</option>
                <?php foreach ($empresas as $empresa) { ?>
                    <option value="<?php echo $empresa['id'] ?>"><?php echo $empresa['rif']; ?>
                        - <?php echo ucfirst($empresa['nombre']); ?></option>
                <?php } ?>
            </select>
            <div class="invalid-feedback" id="error_choferes_select_empresa"></div>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label for="exampleInputEmail1">Vehículo</label>
            <select class="select2bs4" data-placeholder="Seleccionar" name="choferes_select_vehiculo"
                    id="choferes_select_vehiculo">
                <option value="">Seleccione</option>
                <?php
                foreach ($vehiculos as $vehiculo) {
                    $tipo = $controller->getTipo($vehiculo['tipo']);
                    ?>

                    <option value="<?php echo $vehiculo['id'] ?>"><?php echo ucfirst($vehiculo['placa_batea']) ?>
                        - <?php echo $tipo['nombre']; ?></option>
                <?php } ?>
            </select>
            <div class="invalid-feedback" id="error_choferes_select_vehiculo"></div>
        </div>
    </div>

    <div class="col-12">
        <label for="exampleInputEmail1">Cédula</label>
        <div class="input-group">
            <input type="text" class="form-control" name="choferes_input_cedula" id="choferes_input_cedula">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-id-card"></i>
                </div>
            </div>
            <div class="invalid-feedback" id="error_choferes_input_cedula"></div>
        </div>
    </div>

    <div class="col-12">
        <label for="exampleInputEmail1">Nombre y Apellido</label>
        <div class="input-group">
            <input type="text" class="form-control" name="choferes_input_nombre" id="choferes_input_nombre">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="invalid-feedback" id="error_choferes_input_nombre"></div>
        </div>
    </div>

    <div class="col-12">
        <label for="exampleInputEmail1">Teléfono</label>
        <div class="input-group">
            <input type="text" class="form-control" name="choferes_input_telefono" id="choferes_input_telefono">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-mobile-alt"></i>
                </div>
            </div>
            <div class="invalid-feedback" id="error_choferes_input_telefono"></div>
        </div>
    </div>
</div>
