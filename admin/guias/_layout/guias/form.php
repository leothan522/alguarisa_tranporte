<form id="form_guias">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span id="title_form_guias">Title</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool">
                    Cancelar
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">


            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Tipo de Guía</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="guias_tipo_id" id="form_guias_tipo">
                    <option value="">Seleccione</option>
                </select>
                </span>
            </div>

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Código Guía</span>
                <span class="col-8">
                     <input type="text" class="form-control" name="codigo" readonly id="form_guias_codigo">
                </span>
            </div>

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Vehículo</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="vehiculos_id" id="form_guias_vehiculo">
                    <option value="">Seleccione</option>
                </select>
                </span>
            </div>

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Chofer</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="choferes_id" id="form_guias_chofer">
                    <option value="">Seleccione</option>
                </select>
                </span>
            </div>

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Lugar de Origen</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="territorios_origen" id="form_guias_origen">
                    <option value="">Seleccione</option>
                </select>
                </span>
            </div>

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Lugar de Destino</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="territorios_destino" id="form_guias_destino">
                    <option value="">Seleccione</option>
                </select>
                </span>
            </div>

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Fecha Guía</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="fecha" id="form_guias_fecha">
                    <option value="">Seleccione</option>
                </select>
                </span>
            </div>

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Precinto</span>
                <span class="col-8">
                    <input type="text" class="form-control" placeholder="(Opcional)" name="precinto" id="form_guias_precinto">
                </span>
            </div>

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Precinto 2</span>
                <span class="col-8">
                     <input type="text" class="form-control" placeholder="(Opcional)" name="precinto_2" id="form_guias_precinto_2">
                </span>
            </div>

            <div class="form-group">
                <label class="col-12">
                    <i class="fas fa-truck-loading"></i> Carga a trasladar:
                    <button type="button" class="btn btn-link float-right" id="">
                        <i class="fas fa-plus-circle"></i>
                    </button
                    <input type="hidden" value="1" name="contador" id="contador" data-contador="1" placeholder="contador">
                </label>
                <div id="items">
                    <div class="row p-0" id="item_1">
                        <div class="col-3">
                            <input type="text" class="form-control" name="cantidad_1" placeholder="Cant." required  id="form_guias_cantidad"/>
                        </div>
                        <div class="col-7">
                            <input type="text" class="form-control" name="descripcion_1" placeholder="Descripción" required id="form_guias_descripcion"/>
                        </div>
                        <div class="col-2">
                            &nbsp;
                        </div>

                    </div>

                </div>
            </div>


        </div>
        <!-- /.card-body -->

        <div class="card-footer d-none">
            <input type="hidden" placeholder="id" name="guias_id" id="guias_id">
            <input type="hidden" name="opcion" value="store" id="guias_opcion">
            <button type="submit" class="btn btn-primary" id="btn_guradar_form_guias">
                Guardar
            </button>
            <button type="reset" class="btn btn-default float-right">Cancelar</button>
        </div>
    </div>
</form>