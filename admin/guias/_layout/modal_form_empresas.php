<?php
use app\controller\ChoferesController;
$controller = new ChoferesController();
$empresas = $controller->getEmpresas();
$vehiculos = $controller->getVehiculos();
?>
<!-- Modal -->
<div class="modal fade" id="modal_form-choferes">
    <div class="modal-dialog modal-lm modal-dialog-centered">
        <form id="choferes_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Choferes</h4>
                    <div>

                        <button type="button" class="close pt-4" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="card_form_choferes">
                            <?php require 'card_form_choferes.php' ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" placeholder="id" name="choferes_id" id="choferes_id">
                    <input type="hidden" name="opcion" value="store" id="choferes_opcion">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-default" id="btn_modal_form_choferes" data-dismiss="modal"
                            onclick="cambiarTable()">Cancelar
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