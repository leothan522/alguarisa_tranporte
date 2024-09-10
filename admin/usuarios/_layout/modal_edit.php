<!--Disparador-->
<!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
    Launch Default Modal
</button>-->


<!-- Modal -->
<form id="form_editar_user">
    <div class="modal fade" id="modal_edit_usuarios">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Profile Image -->
                            <?php require_once "profile.php"; ?>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <?php require_once "card_editar.php"; ?>
                        </div>
                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" id="btn_modal_eliminar">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_cerrar_modal_edit">Cerrar</button>
                </div>

                <?php verCargando(); ?>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>
<!-- /.modal -->