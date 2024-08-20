
<div class="row justify-content-center" onclick="irGuias()">
    <?php require 'info-box.php'; ?>
</div>

<?php if (!empty($controller->LISTAR_GUIAS)){ ?>
<div class="row justify-content-center" id="row_table_ultimas_guias">
    <div class="col-sm-12 col-md-12 col-lg-8">
        <?php
        if (validarPermisos('guias.index')){
            require 'table.php';
        }
        ?>
    </div>
</div>
<?php } ?>