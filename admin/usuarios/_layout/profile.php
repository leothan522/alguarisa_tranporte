<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                 src="<?php asset('public/img/user_blank.png'); ?>"
                 alt="User profile picture" id="profile_imagen">
        </div>

        <h3 class="profile-username text-center" id="profile_name">Nina Mcintire</h3>

        <p class="text-muted text-center" id="profile_tipo">Usuario Publico</p>

        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Email</b> <a class="float-right" id="profile_email">correo@email.com</a>
            </li>
            <li class="list-group-item">
                <b>Teléfono</b> <a class="float-right" id="profile_telefono">(9999) 999.99.99</a>
            </li>
            <li class="list-group-item">
                <b>Estatus</b> <a class="float-right" id="profile_estatus"><span class="text-success">Activo</span></a>
            </li>
            <li class="list-group-item">
                <b>Fecha Registro</b> <a class="float-right" id="profile_fecha">19/08/2023</a>
            </li>
            <li class="list-group-item d-none" id="ver_new_password">
                <b>Nueva Contraseña</b>
                <span class="float-right">
                    <input size="13" type="text" placeholder="Nueva Contraseña" id="profile_new_password">
                </span>
            </li>
        </ul>

        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-primary btn-block" onclick="resetPassword()" id="btn_profile_reset_password">
                    <b>Restablecer</b><br><b>Contraseña</b>
                </button>
            </div>

            <div class="col-6">
                <span id="btn_profile_band_user">
                <!-- imprimo el btn con js -->
                </span>
            </div>
        </div>

    </div>
    <!-- /.card-body -->
</div>