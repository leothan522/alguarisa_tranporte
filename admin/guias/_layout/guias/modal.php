<!-- Modal -->
<div class="modal fade" id="modal_create_guia">
    <div class="modal-dialog modal-lg modal-dialog-centered" id="modal_size">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row col-md-12">

                    <div class="col-md-6">
                        <h4 class="modal-title">
                            Guias
                        </h4>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body table-responsive" style=" height: 63vh;">


                <div class="row justify-content-center" id="row_form_guias">
                    <div class="col-md-8">
                        <?php require 'form.php'; ?>
                    </div>
                </div>

                <div class="row justify-content-center d-none" id="row_show_guias">
                    <div class="col-12">
                        <?php require 'show_guia.php'?>
                    </div>
                </div>





            </div>
            <div class="modal-footer justify-content-end">
                <div class="row col-12 justify-content-between m-0 p-0">
                    <div class="justify-content-center d-none">
                        <button type="button" class="btn btn-danger" id="modal_ruta_btn_editar" >
                            <i class="fas fa-ban"></i> Anular
                        </button>
                        <button type="button" class="btn btn-info" id="modal_ruta_btn_editar" >
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button type="button" class="btn btn-primary" id="modal_ruta_btn_editar" >
                            <i class="far fa-file-alt"></i> Descargar
                        </button>
                    </div>
                    <div class="justify-content-center">
                        <button type="button" class="btn btn-primary" id="modal_ruta_btn_editar" >
                            Guardar
                        </button>
                    </div>

                    <button type="reset" class="btn btn-default">Cerrar</button>

                </div>
            </div>
            <?php verCargando(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->