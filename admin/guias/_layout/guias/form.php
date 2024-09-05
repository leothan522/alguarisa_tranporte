
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span id="title_form_guias">Title</span>
            </h3>

            <div class="card-tools">
                <span class="btn btn-tool" id="icono_span_title">
                    Cancelar
                </span>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">


            <div class="row ml-1 mr-1 mb-3 justify-content-end">
                <span class="col-4 input-group-text">Tipo de Guía</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="guias_tipo_id" oninput="tipoGuia(this.value, 'create', '')" id="form_guias_tipo">
                        <option value="">Seleccione</option>
                    </select>
                    <!--<div class="invalid-feedback" id="error_select_guias_tipo"></div>-->
                </span>
                <small class="col-8 text-xs text-danger" id="error_select_guias_tipo"></small>
            </div>

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Código Guía</span>
                <span class="col-8">
                    <input type="text" class="form-control" readonly name="codigo" id="form_guias_codigo">
                    <div class="invalid-feedback" id="error_select_guias_codigo"></div>
                </span>
            </div>

            <div class="row ml-1 mr-1 mb-3 justify-content-end">
                <span class="col-4 input-group-text">Vehículo</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="vehiculos_id" id="form_guias_vehiculo">
                        <option value="">Seleccione</option>
                    </select>
                </span>
                <small class="col-8 text-xs text-danger" id="error_select_guias_vehiculo"></small>
            </div>

            <div class="row ml-1 mr-1 mb-3 justify-content-end">
                <span class="col-4 input-group-text">Chofer</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="choferes_id" id="form_guias_chofer">
                        <option value="">Seleccione</option>
                    </select>
                </span>
                <small class="col-8 text-xs text-danger" id="error_select_guias_chofer"></small>
            </div>

            <div class="row ml-1 mr-1 mb-3 justify-content-end">
                <span class="col-4 input-group-text">Lugar de Origen</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="territorios_origen" id="form_guias_origen">
                        <option value="">Seleccione</option>
                    </select>
                </span>
                <small class="col-8 text-xs text-danger" id="error_select_guias_origen"></small>
            </div>

            <div class="row ml-1 mr-1 mb-3 justify-content-end">
                <span class="col-4 input-group-text">Lugar de Destino</span>
                <span class="col-8">
                    <select class="select2bs4" data-placeholder="Seleccionar" name="territorios_destino" id="form_guias_destino">
                        <option value="">Seleccione</option>
                    </select>
                </span>
                <small class="col-8 text-xs text-danger" id="error_select_guias_destino"></small>
            </div>

            <div class="row ml-1 mr-1 mb-3 justify-content-end">
                <span class="col-4 input-group-text">Fecha Guía</span>
                <span class="col-8">
                    <input class="form-control" type="date" name="fecha" id="form_guias_fecha">
                </span>
                <small class="col-8 text-xs text-danger" id="error_input_guias_fecha"></small>
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

            <div class="row ml-1 mr-1 mb-3">
                <span class="col-4 input-group-text">Precinto 3</span>
                <span class="col-8">
                     <input type="text" class="form-control" placeholder="(Opcional)" name="precinto_3" id="form_guias_precinto_3">
                </span>
            </div>

            <div class="form-group">
                <label class="col-12">
                    <i class="fas fa-truck-loading"></i> Carga a trasladar:
                    <button type="button" class="btn btn-link float-right" onclick="addItemGuia()" id="btn_add_guias">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                    <input type="hidden" value="1" name="contador_guia" id="contador_guia" data-contador="1" placeholder="contador">
                </label>
                <div id="items_guias">
                    <div class="row p-0" id="item_guia_1">
                        <div class="col-3">
                            <input type="text" class="form-control input_guias_carga" name="cantidad_1" placeholder="Cant." id="cantidad_1"/>
                        </div>
                        <div class="col-7">
                            <input type="text" class="form-control input_guias_carga" name="descripcion_1" placeholder="Descripción" id="descripcion_1"/>
                        </div>
                        <div class="col-2">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <small class="d-none" id="mensaje_error_guia">
                    <small class="text-xs text-danger">
                        La Cantidad y la Descripcion son obligatorias.
                    </small>
                </small>
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
