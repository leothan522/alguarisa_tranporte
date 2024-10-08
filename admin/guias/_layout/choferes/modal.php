<!-- Modal -->

<div class="modal fade" id="modal_table-choferes">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" id="modal_size">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row col-md-12">

                    <div class="col-md-6">
                        <h4 class="modal-title">
                            Choferes
                        </h4>
                    </div>
                    <div class="col-md-5 justify-content-end">
                        <form id="form_choferes_buscar">
                            <div class="input-group close">
                                <input type="search" class="form-control" placeholder="Buscar" name="keyword"
                                       required id="keyword_choferes">
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
                <form id="form_choferes">

                    <div class="row" id="row_table_choferes">
                        <div class="col-12" id="div_choferes">
                            <?php require "table.php" ?>
                        </div>
                    </div>


                    <div class="row m-5 justify-content-center" id="row_form_choferes">
                        <div class="col-md-8">
                            <?php require "form.php"; ?>
                        </div>
                    </div>

                    <div class="row m-5 justify-content-center" id="row_show_vehiculos">
                        <div class="col-12">
                            <?php require "_layout/show_vehiculo.php"; ?>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_btn_modal_choferes">
                    Cerrar
                </button>
            </div>
            <?php verCargando(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- /.modal -->