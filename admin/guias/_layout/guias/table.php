<?php
$listarGuias = $controller->rows;
$links = $controller->links;
$totalRowsGuias = $controller->totalRows;
$i = $controller->offset;

?>
<div class="card card-outline card-primary">
    <div class="card-header">

        <h3 class="card-title">
            <?php if (isset($keyword) && $keyword){ ?>
                Búsqueda { <span class="text-warning text-bold"><?php echo $keyword?></span> }
                <button type="button" class="btn btn btn-tool" onclick="reconstruirTablaGuias()">
                    <i class=" fas fa-times-circle"></i>
                </button>
            <?php if (isset($controller->prueba)){echo $controller->prueba; } }else{ ?>
                Registrados [
                <span class="text-warning text-bold" id="total_rows_table_guias">
                    <?php echo formatoMillares($totalRowsGuias, 0); ?>
                </span>
                ]
            <?php } ?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="reconstruirTablaGuias()">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool" data-toggle="modal"
                    data-target="#modal_create_guia" onclick="createGuia()">
                <i class="fas fa-file-alt"></i> Nuevo
            </button>

            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm" id="table_guias">
                <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th class="text-center" style="width: 10%">Fecha</th>
                    <th class="text-center">N° Guía</th>
                    <th class="d-none">Origen</th>
                    <th>Destino</th>
                    <th>Chofer</th>
                    <th style="width: 15%" class="d-none d-lg-table-cell">Teléfono</th>
                    <th style="width: 10%" class="d-none d-lg-table-cell">Placa</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
               <?php
               if (!empty($listarGuias)){
                   foreach ($listarGuias as $guia){

               ?>
                       <tr id="tr_item_guias_<?php echo $guia['id'] ?>">
                           <td class="text-center"><?php echo ++$i; ?></td>
                           <td class="guias_fecha text-center"><?php echo verFecha($guia['fecha']); ?></td>

                           <td class="guias_codigo text-center">
                               <?php
                                    if ($guia['estatus'] > 0){
                                        echo $guia['codigo'];
                                    }else{
                                        ?>
                                        <span class="font-italic text-gray"><?php echo $guia['codigo']; ?></span>&ensp;<i class="fas fa-backspace text-danger"></i>
                                        <?php
                                    }
                               ?>
                           </td>
                           <td class="guias_origen d-none"><?php echo $guia['rutas_origen']; ?></td>
                           <td class="guias_destino"><?php echo $guia['rutas_destino']; ?></td>
                           <td class="guias_chofer"><?php echo $guia['choferes_nombre']?></td>
                           <td class="guias_telefono d-none d-lg-table-cell">
                               <?php echo $guia['choferes_telefono']; ?>
                           </td>
                           <td class="guias_placa d-none d-lg-table-cell">
                               <?php echo $guia['vehiculos_placa_batea']; ?>
                           </td>
                           <td class="guias_btns">
                               <div class="btn-group btn-group-sm">
                                   <button type="button" class="btn btn-info" data-toggle="modal"
                                           data-target="#modal_create_guia" onclick="showGuia(<?php echo $guia['id']; ?>)">
                                       <i class="fas fa-eye"></i>
                                   </button>
                                   <?php
                                        if ($guia['estatus'] > 0){ ?>
                                            <button type="button" class="btn btn-info" onclick="generarPDF(<?php echo $guia['id']; ?>)" id="btn_guias_generar_pdf">
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                   <?php }else{ ?>
                                            <button type="button" class="btn btn-info" disabled>
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                   <?php } ?>
                                   <button type="button" class="btn btn-info d-none"
                                           onclick="destroy(<?php echo $guia['id'] ?>, 'delete')"
                                           id="btn_eliminar_guia_<?php echo $guia['id']; ?>">
                                       <i class="far fa-trash-alt"></i>
                                   </button>
                                   <form class="d-none" target="_blank" method="post" action="<?php echo $controller->FORMATO_GUIA_PDF; ?>">
                                       <input type="text" name="guias_id" value="<?php echo $guia['id']; ?>">
                                       <input type="submit" value="enviar" id="btn_form_table_ver_pdf_formato_<?php echo $guia['id']; ?>">
                                   </form>
                               </div>
                           </td>
                       </tr>
               <?php
                   }
               }
               ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix ">
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
    <?php verCargando(); ?>
</div>