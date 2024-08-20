<!-- Modal -->
<form id="form_guias">
<div class="modal fade" id="modal_create_guia">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
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
            <div class="modal-body table-responsive">


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

                    <!--data-dismiss="modal"-->
                    <button type="reset" class="btn btn-default"  id="btn_cerrar_modal_guia">Cerrar</button>

                    <div class="justify-content-center" id="div_btn_show">
                        <button type="button" class="btn btn-danger d-none" id="modal_guia_btn_eliminar">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                        <span class="d-none" id="texto_guia_anulada">hola...mundo</span>
                        <button type="button" class="btn btn-danger" id="modal_guia_btn_anular" <?php if (!validarPermisos('guias.anular')){ echo 'disabled'; } ?>>
                            <i class="fas fa-ban"></i> Anular
                        </button>
                        <button type="button" class="btn btn-info"  id="modal_guia_btn_editar" <?php if (!validarPermisos('guias.edit')){ echo 'disabled'; } ?>>
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button type="button" class="btn btn-primary" id="modal_guia_btn_descargar" <?php if (!validarPermisos('guias.descargar')){ echo 'disabled'; } ?>>
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                    </div>
                    <div class="justify-content-center" id="div_btn_form">
                        <button type="submit" form="form_guias" class="btn btn-primary" id="modal_guia_btn_guardar" >
                            Guardar
                        </button>
                    </div>


                </div>
            </div>
            <?php verCargando(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</form>
<!-- /.modal -->