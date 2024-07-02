<?php
use app\controller\VehiculosController;
$controller = new VehiculosController();
$empresas = $controller->getEmpresas();
$tipos = $controller->getTipo();
?>
<!-- Modal -->
<div class="modal fade" id="modal_form-vehiculos">
    <div class="modal-dialog modal-lm modal-dialog-centered">
        <form id="vehiculos_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Vehiculos</h4>
                    <div>

                        <button type="button" class="close pt-4" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="card_form_vehiculos">
                            <?php require 'card_form_vehiculos.php'; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" placeholder="id" name="vehiculos_id" id="vehiculos_id">
                    <input type="hidden" name="opcion" value="store" id="vehiculos_opcion">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-default" id="btn_modal_form_vehiculos" data-dismiss="modal"
                            onclick="volverModal('btn_modal_vehiculos')">Cancelar
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