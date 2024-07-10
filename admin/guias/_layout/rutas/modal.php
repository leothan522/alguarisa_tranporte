<!-- Modal -->
<div class="modal fade" id="modal_table-rutas">
    <div class="modal-dialog modal-lg modal-dialog-centered" id="modal_size">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row col-md-12">

                    <div class="col-md-6">
                        <h4 class="modal-title">
                            Rutas
                        </h4>
                    </div>
                    <div class="col-md-5 justify-content-end d-none">
                        <form id="form_rutas_buscar">
                            <div class="input-group close">
                                <input type="search" class="form-control" placeholder="Buscar" name="keyword" required id="keyword_rutas">
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




                <div class="row" id="row_table_rutas">
                    <div class="col-12" id="div_rutas">
                        <?php require "table.php" ?>
                    </div>
                </div>


                <div class="row m-5 justify-content-center" id="row_form_rutas">
                    <div class="col-md-8">
                        <?php require "form.php";?>
                    </div>
                </div>

                <div class="row m-5 justify-content-center" id="row_show_rutas">
                    <div class="col-8">
                        <?php require 'show_rutas.php'; ?>
                    </div>
                </div>


            </div>
            <div class="modal-footer justify-content-end d-none">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_btn_modal_rutas">Cerrar</button>
            </div>
            <?php verCargando(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->