<div class="p-4">
    <!-- Widget: user widget style 2 -->
    <div class="card card-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-warning">
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src="<?php asset('public/img/preloader_171x171.png'); ?>" alt="User Avatar">
            </div>
            <!-- /.widget-user-image -->
            <h3 class="widget-user-username" id="show_guias_destino">Destino</h3>
            <h5 class="widget-user-desc" id="show_guias_codigo">Codigo</h5>
        </div>
        <div class="card-footer p-0">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <span class="nav-link">
                        Fecha <span class="float-right text-primary" id="show_guias_fecha">31</span>
                    </span>
                </li>
                <li class="nav-item">
                    <span  class="nav-link">
                        Tipo de Guía <span class="float-right text-primary" id="show_guias_tipo">31</span>
                    </span>
                </li>
                <li class="nav-item">
                    <span class="nav-link">
                        Origen <span class="float-right text-primary" id="show_guias_origen">842</span>
                    </span>
                </li>
                <li class="nav-item">
                    <span class="nav-link">
                        Cargamento:
                    </span>
                </li>
                <li class="nav-item pr-5 pl-5 pt-3">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="show_table_guias_cargamento">
                            <thead>
                            <tr class="text-center bg-info">
                                <th class="text-right pr-3" style="width: 30%;">Cantidad</th>
                                <th class="text-left">Descripción</th>
                            </tr>
                            </thead>

                            <tbody id="show_guias_cargamento">
                            <!-- lo relleno con js  -->
                            </tbody>
                        </table>
                    </div>
                </li>
                <li class="nav-item">
                    <span class="nav-link">
                        Tipo de Vehículo <span class="float-right text-primary" id="show_guias_tipo_vehiculo">12</span>
                    </span>
                </li>
                <li class="nav-item">
                    <span class="nav-link">
                        Placa Batea <span class="float-right text-primary" id="show_guias_placa_batea">12</span>
                    </span>
                </li>

                <li class="nav-item" id="li_show_placa_chuto">
                    <span class="nav-link">
                        Placa Chuto <span class="float-right text-primary" id="show_guias_placa_chuto">12</span>
                    </span>
                </li>

                <li class="nav-item">
                    <span class="nav-link">
                        Marca <span class="float-right  text-primary" id="show_guias_marca">12</span>
                    </span>
                </li>

                <li class="nav-item">
                    <span class="nav-link">
                        Color <span class="float-right text-primary" id="show_guias_color">12</span>
                    </span>
                </li>

                <li class="nav-item">
                    <span class="nav-link">
                        Capacidad <span class="float-right text-primary" id="show_guias_capacidad">12</span>
                    </span>
                </li>

                <li class="nav-item">
                    <span class="nav-link">
                        Chofer <span class="float-right text-primary" id="show_guias_chofer">842</span>
                    </span>
                </li>

                <li class="nav-item">
                    <span class="nav-link">
                        Cédula <span class="float-right text-primary" id="show_guias_cedula">842</span>
                    </span>
                </li>

                <li class="nav-item">
                    <span class="nav-link">
                        Teléfono <span class="float-right text-primary" id="show_guias_telefono">842</span>
                    </span>
                </li>

            </ul>
        </div>
    </div>
    <!-- /.widget-user -->
</div>
