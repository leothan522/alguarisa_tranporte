<form id="form_empresas">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span id="title_form_empresas">Title</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" onclick="displayEmpresas()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="form-group">
                <label for="input_empresas_rif">Rif</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="rif" id="input_empresas_rif">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-barcode"></i>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_input_empresas_rif"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="input_empresas_nombre">Nombre</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="nombre" id="input_empresas_nombre">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_input_empresas_nombre"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="input_empresas_responsable">Responsable</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="responsable" id="input_empresas_responsable">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_input_empresas_responsable"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="input_empresas_telefono">Teléfono</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="telefono" id="input_empresas_telefono">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="error_input_empresas_telefono"></div>
                </div>
            </div>



        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="hidden" placeholder="id" name="empresas_id" id="empresas_id">
            <input type="hidden" name="opcion" value="store" id="empresas_opcion">
            <button type="submit" class="btn btn-primary" id="btn_guradar_form_empresas">
                Guardar
            </button>
            <button type="reset" class="btn btn-default float-right" onclick="displayEmpresas()">Cancelar</button>
        </div>
    </div>
</form>