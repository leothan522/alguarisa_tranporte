<div class="card card-primary">
    <div class="card-header">

        <h3 class="card-title">
            <?php if (isset($keyword) && $keyword){ ?>
                 Búsqueda { <span class="text-warning text-bold"><?php echo $keyword?></span> }
                 <button type="button" class="btn btn btn-tool" onclick="initVehiculos()">
                    <i class=" fas fa-times-circle"></i>
                </button>
            <?php }else{ ?>
                Registrados [
                <span class="text-warning text-bold">
                    <?php
                        if (isset($totalRowsVehiculos)){
                            echo formatoMillares($totalRowsVehiculos, 0);
                        }
                    ?>
                </span> ]
            <?php } ?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="initVehiculos()">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool"  onclick="createVehiculos()" <?php if (!validarPermisos('vehiculos.create')){ echo 'disabled'; } ?>>
                <i class="fas fa-file-alt"></i> Nuevo
            </button>

        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive" style="height: 60vh; ">
            <table class="table table-sm table-head-fixed table-hover text-nowrap"  id="table_vehiculos">
                <thead>
                <tr class="text-center">
                    <th style="width: 10%">#</th>
                    <th class="text-left">Placa Batea</th>
                    <th class="text-left">Tipo</th>
                    <th class="text-left pl-5">Marca</th>
                    <th>Capacidad</th>
                    <th style="width: 5%;"> </th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($listarvehiculos) && $listarvehiculos)
                    foreach ($listarvehiculos as $vehiculo){
                        $tipo = $controller->getTipo($vehiculo['tipo']);
                        $i++;
                        $x++;

                    ?>
                    <tr id="tr_item_vehiculos_<?php echo $vehiculo['id'] ?>">
                        <td class="text-center"><?php echo $i; ?></td>
                        <td class="vehiculos_placa text-left p-0 text-uppercase">
                            <span class="btn btn-link btn-sm" onclick="showVehiculo(<?php echo $vehiculo['id'] ?>, origen = 'vehiculos')">
                                <?php echo $vehiculo['placa_batea']; ?>
                            </span>
                        </td>
                        <td class="vehiculos_tipo text-left text-uppercase" ><?php echo mb_strtoupper($tipo['nombre']); ?></td>
                        <td class="vehiculos_marca text-left pl-5"><?php echo mb_strtoupper($vehiculo['marca']); ?></td>
                        <td class="vehiculos_cantidad text-right pr-3 text-uppercase"><?php echo formatoMillares($vehiculo['capacidad'], 0); ?> </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info"
                                        onclick="editVehiculo(<?php echo $vehiculo['id']; ?>)"
                                        <?php if (!validarPermisos('vehiculos.edit')){ echo 'disabled'; } ?>>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info"
                                        onclick="destroyVehiculo(<?php echo $vehiculo['id'] ?>)"
                                        id="btn_eliminar_vehiculo_<?php echo $vehiculo['id']; ?>"
                                        <?php if (!validarPermisos('vehiculos.destroy')){ echo 'disabled'; } ?>>
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php  } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <input type="hidden" placeholder="valor_$x" value="<?php echo $x ?>" name="vehiculos_input_hidden_x" id="vehiculos_input_hidden_x">
        <?php
        if (isset($keyword) && $keyword){
            echo 'Resultados Encontrados: <span class="text-bold text-danger">'. $i.'</span>';
        }else{
            if (isset($links)){
                echo $links;
            }
        }
        ?>
    </div>

</div>