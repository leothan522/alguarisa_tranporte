<!-- Modal -->
<form id="form_create_user">
    <div class="modal fade" id="modal-create-user">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="users_title">Nuevo</h4>
                    <button type="button" class="close" onclick="" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ml-2 mr-2">
                    <?php require 'card_form.php' ?>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="opcion" value="store" id="opcion">
                    <button type="reset" class="d-none" id="btn_modal_create_reset"> resetear</button>
                    <button type="button" class="btn btn-default float-right" onclick="resetForm()" data-dismiss="modal"  id="btn_reset_create_user">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </div>
                <?php verCargando(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>
<!-- /.modal -->