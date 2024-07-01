<?php
use app\controller\VehiculosController;
$controller = new VehiculosController();
?>
<!-- Modal -->
<div class="modal fade" id="modal_table-vehiculos">
    <div class="modal-dialog modal-lg modal-dialog-centered" id="modal_size">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row col-md-12">

                    <div class="col-md-6">
                        <h4 class="modal-title">
                            Vehiculos
                        </h4>
                    </div>
                    <div class="col-md-5 justify-content-end">
                        <form id="form_vehiculos_buscar">
                            <div class="input-group close">
                                <input type="search" class="form-control" placeholder="Buscar" name="keyword" required>
                                <input type="hidden" name="opcion" value="search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-md-12" id="card_table_vehiculos">
                        <?php
                            $controller->index();
                            require 'card_table_vehiculos.php';
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end d-none">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_modal_table_vehiculos">Cerrar</button>
            </div>
            <?php verCargando(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->