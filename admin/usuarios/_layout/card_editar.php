<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Datos a Editar</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="edit()">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
        <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <label for="edit_name">Nombre</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nombre completo" name="name" id="edit_name">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
            <div class="invalid-feedback" id="error_edit_name"></div>
        </div>

        <label for="edit_email">Email</label>
        <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" id="edit_email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            <div class="invalid-feedback" id="error_edit_email"></div>
        </div>

        <label for="edit_telefono">Teléfono</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Número de teléfono" name="telefono" id="edit_telefono">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-mobile-alt"></i>
                </div>
            </div>
            <div class="invalid-feedback" id="error_edit_telefono"></div>
        </div>

        <label for="edit_tipo">Tipo</label>
        <div class="input-group mb-3">
            <?php $controller->getRoles(); ?>
            <select class="custom-select rounded-0 select_roles_usuarios" name="tipo" id="edit_tipo">
                <?php foreach ($controller->roles as $role) { ?>
                    <option value="<?php echo $role['rowquid'] ?>"><?php echo ucfirst($role['nombre']); ?></option>
                <?php } ?>
            </select>

            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>

            <div class="invalid-feedback" id="error_edit_tipo"></div>
        </div>


    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <input type="hidden" name="opcion" value="update" id="edit_opcion">
        <input type="hidden" name="id" id="edit_id">
        <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
    </div>
</div>
