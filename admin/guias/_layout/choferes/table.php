<div class="card card-primary">
    <div class="card-header">

        <h3 class="card-title">
            <?php if (isset($keyword) && $keyword) { ?>
                Búsqueda { <span class="text-warning text-bold"><?php echo $keyword ?></span> } [ <span
                        class="text-warning text-bold"><?php echo $totalRowsChoferes ?></span> ]
                <button type="button" class="btn btn btn-tool" onclick="initChoferes()">
                    <i class=" fas fa-times-circle"></i>
                </button>
            <?php } else { ?>
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
            <?php if (empty($keyword)){ ?>
                <button type="button" class="btn btn-tool" onclick="initChoferes()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            <?php }else{ ?>
                <button type="button" class="btn btn-tool" onclick="reconstruirBuscarChoferes('<?php echo $controller->keyword ?>')">
                    <i class="fas fa-sync-alt"></i>
                </button>
            <?php } ?>
            <a href="https://alguarisa.com/guias/admin/transporte/choferes/descargar_excel.php" target="_blank"
               class="btn btn-tool d-none" onclick="">
                <i class="fas fa-file-excel"></i> Descargar Excel
            </a>

            <?php if (validarPermisos('choferes.descargar')) { ?>
                <a href="<?php asset('admin/guias/_storage/formatos/choferes/'); ?>" target="_blank"
                   class="btn btn-tool">
                    <i class="fas fa-qrcode"></i> Choferes QR
                </a>
            <?php } else { ?>
                <button type="button" class="btn btn-tool" disabled>
                    <i class="fas fa-qrcode"></i> Choferes QR
                </button>
            <?php } ?>
            <button type="button" class="btn btn-tool"
                    onclick="createChoferes()" <?php if (!validarPermisos('choferes.create')) {
                echo 'disabled';
            } ?>>
                <i class="fas fa-file-alt"></i> Nuevo
            </button>

        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-head-fixed table-hover text-nowrap" id="table_choferes">
                <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th class="text-right">Cédula</th>
                    <th>Nombre y Apellido</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Placa Batea</th>
                    <th style="width: 5%;"></th>
                </tr>
                </thead>
                <tbody>
                <?php

                if (isset($listarChoferes) && $listarChoferes)
                    foreach ($listarChoferes as $chofer) {
                        $i++;
                        $x++;

                        ?>
                        <tr id="tr_item_choferes_<?php echo $chofer['rowquid']; ?>">
                            <td class="text-center"><?php echo $i; ?></td>
                            <td class="choferes_cedula text-right pr-2"><?php echo formatoMillares($chofer['cedula']); ?></td>
                            <td class="choferes_nombre text-left pl-2 text-uppercase text-truncate" style="max-width: 150px;"><span data-toggle="tooltip" data-placement="top"  title="<?php echo $chofer['nombre']; ?>" style="cursor: pointer;"><?php echo mb_strtoupper($chofer['nombre']); ?></span></td>
                            <td class="choferes_telefono"><?php echo $chofer['telefono']; ?> </td>
                            <td class="choferes_placa text-uppercase">
                                <?php if (validarPermisos('vehiculos.index')) { ?>
                                    <span class="btn btn-link btn-sm"
                                          onclick="showVehiculo('<?php echo $chofer['rowquid']; ?>', 'choferes')">
                                    <?php echo $controller->getVehiculo($chofer['rowquid']); ?>
                                </span>
                                <?php } else { ?>
                                    <span class="btn btn-link btn-sm" style="cursor: text;">
                                    <?php echo $vehiculo['placa_batea']; ?>
                                </span>
                                <?php } ?>
                            </td>
                            <td class="btns_choferes">
                                <div class="btn-group btn-group-sm">
                                    <?php if ($chofer['band'] == 2){ ?>
                                        <button type="button" class="btn btn-info"
                                                onclick="estatusChofer('<?php echo $chofer['rowquid']; ?>')" <?php if (!validarPermisos('choferes.estatus')) {
                                            echo 'disabled';
                                        } ?>>
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    <?php }else{ ?>
                                        <button type="button" class="btn btn-info"
                                                onclick="estatusChofer('<?php echo $chofer['rowquid']; ?>')" <?php if (!validarPermisos('choferes.estatus')) {
                                            echo 'disabled';
                                        } ?>>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    <?php } ?>
                                    <button type="button" class="btn btn-info"
                                            onclick="editChofer('<?php echo $chofer['rowquid']; ?>')" <?php if (!validarPermisos('choferes.edit')) {
                                        echo 'disabled';
                                    } ?>>
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-info"
                                            onclick="destroyChofer('<?php echo $chofer['rowquid']; ?>')"
                                            id="btn_eliminar_chofer_<?php echo $chofer['rowquid']; ?>"
                                        <?php if (!validarPermisos('choferes.destroy')) {
                                            echo 'disabled';
                                        } ?>>
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <input type="hidden" placeholder="valor_$x" value="<?php echo $x ?>" name="chofer_input_hidden_x"
               id="chofer_input_hidden_x">
        <?php
        if (isset($keyword) && $keyword) {
            echo 'Resultados Encontrados: <span class="text-bold text-danger">' . $i . '</span>';
        } else {
            if (isset($links)) {
                echo $links;
            }
        }
        ?>
    </div>

</div>