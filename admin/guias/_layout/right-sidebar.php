<div class="p-3">

    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <h5>Tablas</h5>
        </li>
        <li class="dropdown-divider"></li>

        <li class="nav-item">
            <button type="button" class="btn btn-primary btn-sm btn-block m-1" data-toggle="modal"
                    data-target="#modal_table-choferes" onclick="initChoferes()" id="btn_modal_choferes" <?php if (!validarPermisos('choferes.index')){ echo 'disabled'; } ?>>
                Choferes
            </button>
        </li>

        <li>
            <button type="button" class="btn btn-primary btn-sm btn-block m-1" data-toggle="modal"
                    data-target="#modal_table-vehiculos" onclick="initVehiculos()" id="btn_modal_vehiculos" <?php if (!validarPermisos('vehiculos.index')){ echo 'disabled'; } ?>>
                Vehículos
            </button>
        </li>

        <li>
            <button type="button" class="btn btn-primary btn-sm btn-block m-1" data-toggle="modal"
                    data-target="#modal_table-empresas" onclick="initEmpresas()" id="btn_modal_empresas" <?php if (!validarPermisos('empresas.index')){ echo 'disabled'; } ?>>
                Empresas
            </button>
        </li>

        <li>
            <button type="button" class="btn btn-primary btn-sm btn-block m-1" data-toggle="modal"
                    data-target="#modal_table-rutas" onclick="initRutas()" <?php if (!validarPermisos('rutas.index')){ echo 'disabled'; } ?>>
                Rutas
            </button>
        </li>

    </ul>
</div>