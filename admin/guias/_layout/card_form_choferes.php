<form>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registrar Chofer</h3>

            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">

                <div class="col-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Empresa</label>
                        <select class="select2bs4" data-placeholder="Seleccionar" name="choferes_select_empresa" id="choferes_select_empresa">
                            <!--JS-->
                        </select>
                        <div class="invalid-feedback" id="error_choferes_select_empresa"></div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Vehículo</label>
                        <select class="select2bs4" data-placeholder="Seleccionar" name="choferes_select_vehiculo" id="choferes_select_vehiculo">
                            <!--JS-->
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

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
    </div>
</form>