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
                    if (isset($totalRowsRutas)) {
                        echo formatoMillares($totalRowsRutas, 0);
                    }
                    ?>
                </span>
                ]
            <?php } ?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="createRutas()">
                <i class="fas fa-file-alt"></i> Nuevo
            </button>

        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive" style="height: 60vh; ">
            <table class="table table-sm table-head-fixed table-hover text-nowrap"  id="table_rutas">
                <thead>
                <tr>
                    <th class="text-center" style="width: 10%">#</th>
                    <th style="width: 30%">Origen</th>
                    <th class="text-center">Ruta</th>
                    <th style="width: 30%">Destino</th>
                    <th style="width: 5%;"> </th>
                </tr>
                </thead>
                <tbody>
                <?php

                if (isset($listarRutas) && $listarRutas)
                    foreach ($listarRutas as $ruta){
                        $origen = $controller->getParroquia($ruta['origen']);
                        $destino = $controller->getParroquia($ruta['destino']);
                        $lugares = json_decode($ruta['ruta']);
                        $texto = null;
                        foreach ($lugares as $lugar){
                            $texto.= $lugar.', ';
                        }

                        $i++;
                        $x++;
                        ?>
                        <tr id="tr_item_rutas_<?php echo $ruta['id']; ?>">
                            <td class="text-center"><?php echo $i; ?></td>
                            <td class="origen" ><?php echo $origen; ?></td>
                            <td class="ruta text-center">
                                <button class="btn btn-link btn-sm" onclick="showRutas(<?php echo $ruta['id']; ?>)">
                                    Ver ruta
                                </button>
                            </td>
                            <td class="destino"><?php echo $destino; ?> </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-info"
                                            onclick="editRuta(<?php echo $ruta['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-info"
                                            onclick="destroyRutas(<?php echo $ruta['id']; ?>)"
                                            id="btn_eliminar_chofer_<?php echo $ruta['id']; ?>">
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
        <input type="hidden" placeholder="valor_$x" value="<?php echo $x ?>" name="rutas_input_hidden_x" id="rutas_input_hidden_x">
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