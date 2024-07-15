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
                <button type="button" class="btn btn btn-tool" onclick="initChoferes()">
                    <i class=" fas fa-times-circle"></i>
                </button>
            <?php }else{ ?>
                Registrados [
                <span class="text-warning text-bold">
                    <?php echo formatoMillares($totalRowsGuias, 0); ?>
                </span>
                ]
            <?php } ?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal"
                    data-target="#modal_create_guia" >
                <i class="fas fa-file-alt"></i> Nuevo
            </button>

            <button type="button" class="btn btn-tool">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive" style="height: 60vh;">
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
                       <tr>
                           <td class="text-center"><?php echo ++$i; ?></td>
                           <td class="text-center"><?php echo verFecha($guia['fecha']); ?></td>
                           <td class="text-center"><?php echo $guia['codigo']; ?></td>
                           <td class="d-none"><?php echo $guia['rutas_origen']; ?></td>
                           <td><?php echo $guia['rutas_destino']; ?></td>
                           <td><?php echo $guia['choferes_nombre']?></td>
                           <td class="d-none d-lg-table-cell">
                               <?php echo $guia['choferes_telefono']; ?>
                           </td>
                           <td class="d-none d-lg-table-cell">
                               <?php echo $guia['vehiculos_placa_batea']; ?>
                           </td>
                           <td>
                               <div class="btn-group btn-group-sm">
                                   <button type="button" class="btn btn-info">
                                       <i class="fas fa-eye"></i>
                                   </button>
                                   <button type="button" class="btn btn-info" onclick="generarPDF(<?php echo $guia['id']; ?>)">
                                       <i class="fas fa-file-pdf"></i>
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
</div>