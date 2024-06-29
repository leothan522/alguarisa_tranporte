<?php
$listarEmpresas = $controller->rows;
$links = $controller->links;
$i = $controller->offset;
$keyword = $controller->keyword;
$x = 0;
?>
<div class="card card-primary">
    <div class="card-header">

        <h3 class="card-title">
            <?php if ($keyword){ ?>
                 Búsqueda { <span class="text-warning text-bold"><?php echo $controller->keyword ?></span> }
                 <button type="button" class="btn btn btn-tool" onclick="reconstruirTablaEmpresa()">
                    <i class=" fas fa-times-circle"></i>
                </button>
            <?php }else{ ?>
                Registrados [ <span class="text-warning text-bold"><?php echo $controller->totalRows?></span> ]
            <?php } ?>

        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal_form-empresas"
                    onclick="cerrarTable()" id="modal_form_empresas">
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
                    <th style="width: 10px">#</th>
                    <th>Rif</th>
                    <th>Nombre</th>
                    <th>Responsable</th>
                    <th>Teléfono</th>
                    <th style="width: 5px;"> </th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($listarEmpresas as $empresa){
                        $i++;
                        $x++;
                ?>
                <tr id="tr_item_empresas_<?php echo $empresa['id']; ?>">
                    <td><?php echo $i; ?></td>
                    <td class="empresa_rif"><?php echo $empresa['rif']; ?></td>
                    <td class="empresa_nombre"><?php echo $empresa['nombre']; ?></td>
                    <td class="empresa_responsable"><?php echo $empresa['responsable']; ?> </td>
                    <td class="empresa_telefono"><?php echo $empresa['telefono']; ?> </td>

                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-info"
                                    onclick="editEmpresa(<?php echo $empresa['id']; ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-info"
                                    onclick="elimEmpresa(<?php echo $empresa['id']; ?>)"
                                    id="btn_eliminar_empresa_<?php echo $empresa['id']; ?>">
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
        if ($keyword){
            echo 'Resultados Encontrados: <span class="text-bold text-danger">'. $i.'</span>';
        }else{
            echo $links;
        }
        ?>
    </div>

</div>