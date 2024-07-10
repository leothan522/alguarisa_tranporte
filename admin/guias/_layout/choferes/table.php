<div class="card card-primary">
    <div class="card-header">

        <h3 class="card-title">
            <?php if (isset($keyword) && $keyword){ ?>
                 Búsqueda { <span class="text-warning text-bold"><?php echo $keyword?></span> }
                 <button type="button" class="btn btn btn-tool" onclick="initChoferes()">
                    <i class=" fas fa-times-circle"></i>
                </button>
            <?php }else{ ?>
                Registrados [
                <span class="text-warning text-bold">
                    <?php
                    if (isset($totalRowsChoferes)) {
                        echo formatoMillares($totalRowsChoferes, 0);
                    }
                    ?>
                </span>
                ]
            <?php } ?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="createChoferes()">
                <i class="fas fa-file-alt"></i> Nuevo
            </button>

        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive" style="height: 60vh; ">
            <table class="table table-sm table-head-fixed table-hover text-nowrap"  id="table_choferes">
                <thead>
                <tr>
                    <th class="text-center" style="width: 10%">#</th>
                    <th class="text-right">Cédula</th>
                    <th>Nombre y Apellido</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Placa Batea</th>
                    <th style="width: 5%;"> </th>
                </tr>
                </thead>
                <tbody>
                <?php

                if (isset($listarChoferes) && $listarChoferes)
                    foreach ($listarChoferes as $chofer){
                        $vehiculo = $controller->vehiculos($chofer['vehiculos_id']);
                        $i++;
                        $x++;

                        ?>
                        <tr id="tr_item_choferes_<?php echo $chofer['id']; ?>">
                            <td class="text-center"><?php echo $i; ?></td>
                            <td class="choferes_cedula text-right pr-2" ><?php echo formatoMillares($chofer['cedula']); ?></td>
                            <td class="choferes_nombre text-left pl-2"><?php echo mb_strtoupper($chofer['nombre']); ?></td>
                            <td class="choferes_telefono"><?php echo $chofer['telefono']; ?> </td>
                            <td class="choferes_placa">
                                <span class="btn btn-link btn-sm" onclick="showVehiculo(<?php echo $vehiculo['id']; ?>, 'choferes')">
                                    <?php echo $vehiculo['placa_batea']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-info"
                                            onclick="editChofer(<?php echo $chofer['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-info"
                                            onclick="destroyChofer(<?php echo $chofer['id']; ?>)"
                                            id="btn_eliminar_chofer_<?php echo $chofer['id']; ?>">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php  }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <input type="hidden" placeholder="valor_$x" value="<?php echo $x ?>" name="chofer_input_hidden_x" id="chofer_input_hidden_x">
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