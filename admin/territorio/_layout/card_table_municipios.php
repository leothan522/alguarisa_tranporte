<?php
$listarMunicipios = $controller->rows;
$links = $controller->links;
$i = $controller->offset;
$x = 0;
$count = count($controller->rows);
?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <?php if (empty($controller->keyword)) { ?>
                Municipios [ <span class="text-danger text-bold"><?php echo $controller->totalMunicipio ?></span> ]
            <?php } else { ?>
                Municipio { <strong class="text-danger"><?php echo $controller->keyword; ?></strong> } [ <span
                        class="text-danger text-bold"><?php echo $controller->totalMunicipio ?></span> ]
                <button type="button" class="btn btn-tool" onclick="reconstruirTablaMunicipios()">
                    <i class="fas fa-times-circle"></i>
                </button>
            <?php } ?>
        </h3>

        <div class="card-tools">
            <?php if (empty($controller->keyword)) { ?>
                <button type="button" class="btn btn-tool" onclick="reconstruirTablaMunicipios()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            <?php } else { ?>
                <button type="button" class="btn btn-tool" onclick="reconstruirBuscarMunicipio('<?php echo $controller->keyword; ?>')">
                    <i class="fas fa-sync-alt"></i>
                </button>
            <?php } ?>
            <button class="btn btn-tool"
                    onclick="resetMunicipio()" data-toggle="modal"
                    data-target="#modal-municipios"
                <?php if (!validarPermisos('municipios.create')) {
                    echo 'disabled';
                } ?> >
                <i class="far fa-file-alt"></i> Nuevo
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table table-responsive">
            <table class="table table-sm" id="tabla_municipios">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nombre</th>
                    <th>Abreviatura</th>
                    <th style="width: 40px">Asignación</th>
                    <th style="width: 40px">Parroquias</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarMunicipios as $municipio) {
                    $i++;
                    $x++;
                    ?>
                    <tr id="tr_item_<?php echo $municipio['rowquid']; ?>">
                        <td class="text-center item"><?php echo $i; ?>.</td>
                        <td class="nombre text-uppercase text-truncate" style="max-width: 150px;"><span data-toggle="tooltip" data-placement="top"  title="<?php echo $municipio['nombre']; ?>" style="cursor: pointer;"><?php echo $municipio['nombre']; ?></span></td>
                        <td class="mini text-uppercase"><?php echo $municipio['mini']; ?></td>
                        <td class="asignacion text-right"> <?php echo formatoMillares($municipio['familias'], 0); ?> </td>
                        <td class="text-center parroquias">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-success"
                                        onclick="filtrarParroquias('<?php echo $municipio['rowquid'] ?>')"
                                        id="btn_count_parroquias_<?php echo $municipio['rowquid'] ?>">
                                    <?php echo formatoMillares($controller->countParroquias($municipio['rowquid']), 0); ?>
                                </button>
                            </div>
                        </td>

                        <td class="botones">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info"
                                        onclick="estatusMunicipio('<?php echo $municipio['rowquid']; ?>')"
                                        id="btn_estatus_mun_<?php echo $municipio['rowquid']; ?>"
                                    <?php if (!validarPermisos('municipios.estatus')) {
                                        echo 'disabled';
                                    } ?> >
                                    <?php if ($municipio['estatus']) { ?>
                                        <i class="fas fa-eye"></i>
                                    <?php } else { ?>
                                        <i class="fas fa-eye-slash"></i>
                                    <?php } ?>
                                </button>
                                <button type="button" class="btn btn-info"
                                        onclick="editMunicipio('<?php echo $municipio['rowquid']; ?>')" data-toggle="modal"
                                        data-target="#modal-municipios"
                                    <?php if (!validarPermisos('municipios.edit')) {
                                        echo 'disabled';
                                    } ?> >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info"
                                        onclick="destroyMunicipio('<?php echo $municipio['rowquid'] ?>')"
                                        id="btn_eliminar_<?php echo $municipio['rowquid']; ?>"
                                    <?php if (!validarPermisos('municipios.destroy')) {
                                        echo 'disabled';
                                    } ?>>
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
        <?php
        if (empty($controller->keyword)) {
            echo $links;
        } else {
            echo "Mostrando " . $x;
        }
        ?>
        <input type="hidden" value="<?php echo $x; ?>" id="input_hidden_municipios_valor_x">
    </div>
    <?php verCargando(); ?>
</div>