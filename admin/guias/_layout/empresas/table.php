<div class="card card-primary">
    <div class="card-header">

        <h3 class="card-title">
            <?php if (isset($keyword) && $keyword){ ?>
                 Búsqueda { <span class="text-warning text-bold"><?php echo $keyword ?></span> }
                 <button type="button" class="btn btn btn-tool" onclick="initEmpresas()">
                    <i class=" fas fa-times-circle"></i>
                </button>
            <?php }else{ ?>
                Registrados [
                <span class="text-warning text-bold">
                    <?php
                    if (isset($totalRowsEmpresas)) {
                        echo formatoMillares($totalRowsEmpresas, 0);
                    }
                    ?>
                </span> ]
            <?php } ?>

        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="initEmpresas()">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool" onclick="createEmpresas()" <?php if (!validarPermisos('empresas.create')){ echo 'disabled'; } ?>>
                <i class="fas fa-file-alt"></i> Nuevo
            </button>

        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive" style="height: 60vh; ">
            <table class="table table-sm table-head-fixed table-hover text-nowrap"  id="table_empresas">
                <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th>Rif</th>
                    <th>Nombre</th>
                    <th>Responsable</th>
                    <th class="d-none">Teléfono</th>
                    <th style="width: 5%;"> </th>
                </tr>
                </thead>
                <tbody>
                <?php
                    if (isset($listarEmpresas) && $listarEmpresas)
                        foreach ($listarEmpresas as $empresa){
                            $i++;
                            $x++;
                            ?>
                            <tr class="text-sm" id="tr_item_empresas_<?php echo $empresa['id']; ?>">
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="empresa_rif text-bold"><?php echo $empresa['rif']; ?></td>
                                <td class="empresa_nombre"><?php echo $empresa['nombre']; ?></td>
                                <td class="empresa_responsable">
                                    <small>
                                        <?php echo $empresa['responsable']; ?> <br>
                                        <?php echo $empresa['telefono']; ?>
                                    </small>
                                </td>
                                <td class="empresa_telefono d-none"><?php echo $empresa['telefono']; ?> </td>

                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-info"
                                                onclick="editEmpresa(<?php echo $empresa['id']; ?>)"
                                                <?php if (!validarPermisos('empresas.edit')){ echo 'disabled'; } ?>>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-info"
                                                onclick="destroyEmpresa(<?php echo $empresa['id']; ?>)"
                                                id="btn_eliminar_empresa_<?php echo $empresa['id']; ?>"
                                                <?php if (!validarPermisos('empresas.destroy')){ echo 'disabled'; } ?>>
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
        <input type="hidden" placeholder="valor_$x" value="<?php echo $x ?>" name="empresa_input_hidden_x" id="empresa_input_hidden_x">
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