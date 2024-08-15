<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">Ultimas Guías Creadas</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="actualizar()">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
                <th class="text-center">Fecha</th>
                <th class="text-center">N° de Guía</th>
                <th>Destino</th>
                <th>Chofer</th>
                <th style="width: 5%; "></th>
            </tr>
            </thead>
            <tbody id="tbody_table_dashboard">
            <?php foreach ($controller->LISTAR_GUIAS as $guia){ ?>
                <tr>
                <td class="text-center"><?php echo verFecha($guia['fecha']); ?></td>
                <td class="text-uppercase text-center">
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
                <td class="text-uppercase"><?php echo $guia['rutas_destino']; ?></td>
                <td class="text-uppercase"><?php echo $guia['choferes_nombre']; ?></td>
                <td class="text-center">
                    <div class="">

                        <?php
                        if ($guia['estatus'] > 0){ ?>
                            <button type="button" class="btn btn-info btn-sm" onclick="generarPDF(<?php echo $guia['id']; ?>)" id="btn_guias_generar_pdf">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        <?php }else{ ?>
                            <button type="button" class="btn btn-info btn-sm" disabled>
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        <?php } ?>

                        <form class="d-none" target="_blank" method="post" action="<?php echo $controller->FORMATO_GUIA_PDF; ?>">
                            <input type="text" name="guias_id" value="<?php echo $guia['id']; ?>">
                            <input type="submit" value="enviar" id="btn_form_table_ver_pdf_formato_<?php echo $guia['id']; ?>">
                        </form>
                    </div>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php verCargando(); ?>
</div>
