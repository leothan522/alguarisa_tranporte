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
                 <button type="button" class="btn btn btn-tool" onclick="reconstruirTablaChofer()">
                    <i class=" fas fa-times-circle"></i>
                </button>
            <?php }else{ ?>
                Registrados [ <span class="text-warning text-bold"><?php echo $controller->totalRows?></span> ]
            <?php } ?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal_form-vehiculos" id="btn_modal_form"
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
                    <th>Placa Batea</th>
                    <th>Tipo</th>
                    <th>Marca</th>
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
                <tr id="tr_item_vehiculos_<?php  ?>">
                    <td><?php echo $i; ?></td>
                    <td class="vehiculos_placa"><span class="btn btn-link" data-toggle="modal"
                                                     data-target="#modal_datos_vehiculos" onclick=" " ><?php echo $vehiculo['placa_batea']; ?></span>
                    </td>
                    <td class="vehiculos_tipo text-center" ><?php echo $tipo['nombre']; ?></td>
                    <td class="vehiculos_marca text-center"><?php echo $vehiculo['marca']; ?></td>
                    <td class="vehiculos_cantidad text-right"><?php echo $vehiculo['capacidad']; ?> </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-info"
                                    onclick="">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-info"
                                    onclick=" "
                                    id="btn_eliminar_chofer_<?php  ?>">
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
        <input type="hidden" placeholder="valor_$x" value="<?php echo $x ?>" name="chofer_input_hidden_x" id="chofer_input_hidden_x">
        <?php
/*        if ($keyword){
            echo 'Resultados Encontrados: <span class="text-bold text-danger">'. $i.'</span>';
        }else{
            echo $links;
        }
        */?>
    </div>

</div>