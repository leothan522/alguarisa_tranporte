<!-- Modal -->
<form id="form_parametros">
    <div class="modal fade" id="modal-parametros">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="parametro_title">Nuevo</h4>
                    <button type="button" class="close" onclick="" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ml-2 mr-2">
                    <?php require 'form.php' ?>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="opcion" value="store" id="opcion">
                    <input type="hidden" name="id" id="id">
                    <button type="reset" class="btn btn-default float-right" data-dismiss="modal" id="btn_cancelar">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
                <?php verCargando(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>
<!-- /.modal -->