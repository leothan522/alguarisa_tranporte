<?php
$listarParametros = $controller->rows;
$links = $controller->links;
$totalRows = $controller->totalRows;
$limit = $controller->limit;
$keyword = $controller->keyword;
$i = $controller->offset;
$x = 0;
?>

<div class="card card-outline card-primary">

    <div class="card-header">
        <h3 class="card-title">
            <?php if (!$keyword) { ?>
                Registrados [ <span class="text-danger text-bold"><?php echo $controller->totalParametros; ?></span> ]
            <?php } else { ?>
                Búsqueda { <strong class="text-danger"><?php echo $keyword; ?></strong> } [ <span class="text-danger text-bold"><?php echo $controller->totalParametros; ?></span> ]
                <button type="button" class="btn btn-tool" onclick="reconstruirTabla()">
                    <i class="fas fa-times-circle"></i>
                </button>

            <?php } ?>

        </h3>

        <div class="card-tools">
            <?php if ($keyword){ ?>
                <button type="button" class="btn btn-tool" onclick="reconstruirBuscar('<?php echo ($keyword); ?>')">
                    <i class="fas fa-sync-alt"></i>
                </button>
            <?php }else{ ?>
                <button type="button" class="btn btn-tool" onclick="reconstruirTabla()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            <?php } ?>
            <button class="btn btn-tool" onclick="reset()" data-toggle="modal" data-target="#modal-parametros">
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>


    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive  mt-3"
            <?php if ($limit > 15 && $totalRows > 15) {
                echo 'style="height: 54vh;"';
            }
            ?> >
            <table class="table table-sm" id="table_parametros">
                <thead>
                <tr>
                    <th style="width: 10%">#</th>
                    <th>Nombre</th>
                    <th>Tabla_id</th>
                    <th>Valor</th>
                    <th style="width: 10%;">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarParametros as $parametro) {
                    $x++; ?>
                    <tr id="tr_item_<?php echo $parametro['rowquid']; ?>">
                        <td><span class="text-bold"><?php echo ++$i; ?></span></td>
                        <td class="nombre">
                            <?php echo $parametro['nombre'] ?>
                        </td>
                        <td class="tabla_id">
                            <?php echo $parametro['tabla_id'] ?>
                        </td>
                        <td class="valor">
                            <?php
                            if ($parametro['tabla_id'] == -1) {
                                echo 'JSON {...}';
                            } else {
                                echo $parametro['valor'];
                            }
                            ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-parametros"
                                        onclick="edit('<?php echo $parametro['rowquid'] ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info"
                                        onclick="borrar('<?php echo $parametro['rowquid']; ?>')"
                                        id="btn_eliminar_<?php echo $parametro['rowquid'] ?>">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <input type="hidden" placeholder="valor_$x" value="<?php echo $x ?>" name="input_hidden_x" id="input_hidden_x">
        <?php
        if (isset($links)) {
            echo $links;
        }
        ?>
    </div>
    <?php verCargando(); ?>
</div>