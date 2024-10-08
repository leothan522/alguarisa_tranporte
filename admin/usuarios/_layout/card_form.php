<label for="name">Nombre</label>
<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Nombre completo" name="name" id="name">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user"></span>
        </div>
    </div>
    <div class="invalid-feedback" id="error_name"></div>
</div>

<label for="email">Email</label>
<div class="input-group mb-3">
    <input type="email" class="form-control" placeholder="Email" name="email" id="email">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-envelope"></span>
        </div>
    </div>
    <div class="invalid-feedback" id="error_email"></div>
</div>

<label for="password">Contraseña</label>
<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Contraseña" name="password" id="password">
    <div class="input-group-append" style="cursor: pointer;" onclick="generarClave()">
        <div class="input-group-text">
            <i class="fas fa-key"></i>
        </div>
    </div>
    <div class="invalid-feedback" id="error_password"></div>
</div>

<label for="telefono">Teléfono</label>
<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Número de teléfono" name="telefono" id="telefono">
    <div class="input-group-append">
        <div class="input-group-text">
            <i class="fas fa-mobile-alt"></i>
        </div>
    </div>
    <div class="invalid-feedback" id="error_telefono"></div>
</div>

<label for="telefono">Tipo</label>
<div class="input-group mb-3">
    <?php $controller->getRoles(); ?>
    <select class="custom-select rounded-0 select_roles_usuarios" name="tipo" id="tipo">

    </select>

    <div class="input-group-append">
        <div class="input-group-text">
            <i class="fas fa-user-shield"></i>
        </div>
    </div>

    <div class="invalid-feedback" id="error_tipo"></div>
</div>

