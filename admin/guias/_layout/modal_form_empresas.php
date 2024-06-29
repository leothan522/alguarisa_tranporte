<?php

?>
<!-- Modal -->
<div class="modal fade" id="modal_form-empresas">
    <div class="modal-dialog modal-lm modal-dialog-centered">
        <form id="empresas_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Empresas</h4>
                    <div>

                        <button type="button" class="close pt-4" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="card_form_empresas">
                            <?php require 'card_form_empresas.php'; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" placeholder="id" name="empresas_id" id="empresas_id">
                    <input type="hidden" name="opcion" value="store" id="empresas_opcion">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            onclick="cambiarTableEmpresa()" id="btn_modal_form_empresas">Cancelar
                    </button>
                </div>
                <?php verCargando(); ?>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->