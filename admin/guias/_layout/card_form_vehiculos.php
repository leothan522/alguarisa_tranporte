<form>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registrar Vehículo</h3>

            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">

                <div class="col-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Empresa</label>
                        <select class="select2bs4" data-placeholder="Seleccionar" name="vehiculos_select_empresa" id="vehiculos_select_empresa">
                            <!--JS-->
                        </select>
                        <div class="invalid-feedback" id="error_vehiculo_select_empresa"></div>
                    </div>
                </div>

                <div class="col-12">
                    <label for="exampleInputEmail1">Placa Batea</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="vehiculos_input_batea" id="vehiculos_input_batea">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="error_vehiculos_input_batea"></div>
                    </div>
                </div>

                <div class="col-12">
                    <label for="exampleInputEmail1">Placa Chuto</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="vehiculos_input_chuto" id="vehiculos_input_chuto">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fa-solid fa-car-rear"></i>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="error_vehiculos_input_chuto"></div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tipo</label>
                        <select class="select2bs4" data-placeholder="Seleccionar" name="vehiculos_select_tipo" id="vehiculos_select_tipo">
                            <!--JS-->
                        </select>
                        <div class="invalid-feedback" id="error_vehiculos_select_tipo"></div>
                    </div>
                </div>

                <div class="col-12">
                    <label for="exampleInputEmail1">Marca</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="vehiculos_input_marca" id="vehiculos_input_marca">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-trademark"></i>
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
                                <i class="fas fa-palette"></i>
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
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="error_vehiculos_input_capacidado"></div>
                    </div>
                </div>



            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
    </div>
</form>