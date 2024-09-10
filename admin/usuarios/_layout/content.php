

<div class="row justify-content-center">



    <div class="col-12">
        <div id="dataContainer">
            <?php
            $controller->index();
            require_once 'card_table.php';
            ?>
        </div>
        <?php require_once "modal_edit.php"; ?>
        <?php require_once "modal_permisos.php"; ?>
        <?php require_once "modal_roles.php"; ?>
        <?php require_once "modal_acceso.php"; ?>
        <?php require_once "modal_create.php"; ?>
    </div>
</div>