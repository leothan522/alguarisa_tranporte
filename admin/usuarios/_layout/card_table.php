<?php
$listarUsuarios = $controller->rows;
$links = $controller->links;
$userRole = $controller->USER_ROLE;
$i = $controller->offset;
$x = 0;
?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <?php if (empty($controller->keyword)) { ?>
                Registrados [ <span class="text-danger text-bold"><?php echo $controller->totalUsers ?></span> ]
            <?php } else { ?>
                Búsqueda { <strong class="text-danger"><?php echo $controller->keyword; ?></strong> } [ <span
                        class="text-danger text-bold"><?php echo $controller->totalUsers ?></span> ]
                <button type="button" class="btn btn-tool" onclick="reconstruirTabla()">
                    <i class="fas fa-times-circle"></i>
                </button>
            <?php } ?>
        </h3>

        <div class="card-tools">
            <?php if (empty($controller->keyword)) { ?>
                <button type="button" class="btn btn-tool" onclick="reconstruirTabla()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            <?php } else { ?>
                <button type="button" class="btn btn-tool"
                        onclick="reconstruirBuscar('<?php echo $controller->keyword ?>')">
                    <i class="fas fa-sync-alt"></i>
                </button>
            <?php } ?>
            <button class="btn btn-tool" onclick="resetForm()" data-toggle="modal" data-target="#modal-create-user"
                <?php if (!validarPermisos('usuarios.create')){ echo 'disabled'; } ?>>
                <i class="far fa-file-alt"></i> Nuevo
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table table-responsive mt-3">
            <table class="table table-sm" id="tabla_usuarios">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Estatus</th>
                    <th style="width: 10%" class="text-center d-none d-lg-table-cell">Creado</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarUsuarios as $user) {
                    $i++;
                    $x++;
                    ?>
                    <tr id="tr_item_<?php echo $user['id']; ?>">
                        <td class="text-center"><?php echo $i ?></td>
                        <td class="nombre"><?php echo $user['name'] ?></td>
                        <td class="email"><?php echo $user['email'] ?></td>
                        <td class="telefono text-center"><?php echo $user['telefono'] ?></td>
                        <td class="role text-center"><?php echo $controller->getRol($user['role'], $user['role_id']) ?></td>
                        <td class="estatus text-center"><?php echo $controller->verEstatusUsuario($user['estatus']) ?></td>
                        <td class="created_at text-center d-none d-lg-table-cell"><?php echo getFecha($user['created_at']); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" onclick="edit(<?php echo $user['id'] ?>)"
                                        data-toggle="modal" data-target="#modal_edit_usuarios"
                                    <?php if (($controller->USER_ID == $user['id']) || ($user['role'] == 100) || (!validarPermisos('usuarios.edit')) || ($user['role'] > $userRole && $userRole != 100)) {
                                        echo 'disabled';
                                    } ?> >
                                    <i class="fas fa-user-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#modal_permisos" onclick="getPermisos(<?php echo $user['id'] ?>)"
                                    <?php if (($controller->USER_ID == $user['id']) || ($user['role'] == 100) || (!validarPermisos())) {
                                        echo 'disabled';
                                    } ?>>
                                    <i class="fas fa-user-shield"></i>
                                </button>
                                <button type="button" class="btn btn-info d-none"
                                        onclick="destroy(<?php echo $user['id']; ?>)"
                                        id="btn_eliminar_<?php echo $user['id'] ?>"
                                    <?php if (($controller->USER_ID == $user['id']) || ($user['role'] == 100) || (!validarPermisos('usuarios.destroy')) || ($user['role'] > $userRole && $userRole != 100)) {
                                        echo 'disabled';
                                    } ?> >
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
        <input type="hidden" value="<?php echo $x ?>" placeholder="valor_x" name="valor_x" id="input_hidden_valor_x">
        <!--<ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>-->
    </div>

    <?php verCargando(); ?>

</div>