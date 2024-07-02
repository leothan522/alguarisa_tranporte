<?php
$listarvehiculos = $controller->rows;
$links = $controller->links;
$i = $controller->offset;
$keyword = $controller->keyword;
$x = 0;
?>
<div class="card card-primary">
    <div class="card-header">

        <h3 class="card-title">
            <?php if ($keyword){ ?>
                 Búsqueda { <span class="text-warning text-bold"><?php echo $controller->keyword?></span> }
                 <button type="button" class="btn btn btn-tool" onclick="reconstruirTablaVehiculo()">
                    <i class=" fas fa-times-circle"></i>
                </button>
            <?php }else{ ?>
                Registrados [ <span class="text-warning text-bold"><?php echo $controller->totalRows?></span> ]
            <?php } ?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal_form-vehiculos" id="btn_modal_form_vehiculos"
                    onclick="cambiarFormVehiculos()">
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
                    <th style="width: 10px">#</th>
                    <th class="text-left">Placa Batea</th>
                    <th class="text-left">Tipo</th>
                    <th class="text-left pl-5">Marca</th>
                    <th>cantidad</th>
                    <th style="width: 5px;"> </th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarvehiculos as $vehiculo){
                    $tipo = $controller->getTipo($vehiculo['tipo']);
                    $i++;
                    $x++;

                ?>
                <tr id="tr_item_vehiculos_<?php echo $vehiculo['id'] ?>">
                    <td><?php echo $i; ?></td>
                    <td class="vehiculos_placa text-left p-0">
                        <span class="btn btn-link" data-toggle="modal" data-target="#modal_datos_vehiculos"
                              onclick="getVehiculo(<?php echo $vehiculo['id'] ?>, origen = 'btn_modal_vehiculos')">
                            <?php echo $vehiculo['placa_batea']; ?>
                        </span>
                    </td>
                    <td class="vehiculos_tipo text-left" ><?php echo mb_strtoupper($tipo['nombre']); ?></td>
                    <td class="vehiculos_marca text-left pl-5"><?php echo mb_strtoupper($vehiculo['marca']); ?></td>
                    <td class="vehiculos_cantidad text-right pr-3"><?php echo $vehiculo['capacidad']; ?> </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-info"
                                    onclick="editVehiculo(<?php echo $vehiculo['id']; ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-info"
                                    onclick="elimVehiculo(<?php echo $vehiculo['id'] ?>)"
                                    id="btn_eliminar_vehiculo_<?php echo $vehiculo['id']; ?>">
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
        if ($keyword){
            echo 'Resultados Encontrados: <span class="text-bold text-danger">'. $i.'</span>';
        }else{
            echo $links;
        }
        ?>
    </div>

</div>