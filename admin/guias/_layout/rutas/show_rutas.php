<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <span id="title_form_choferes">Detalles de la Ruta</span>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="displayRutas()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <div class="row col-md-12 justify-content-center">
            <div class="card" style="width:100%">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Origen:</strong> <span class="text-primary float-right" id="modal_ruta_ver_origen"> jefe </span></li>
                    <li class="list-group-item">
                        <strong>Trayecto:</strong>
                        <ul class="list-group list-group-flush" id="modal_ruta_ver_trayecto">
                            <!--<li class="list-group-item"> <span class="text-primary"> jefe </span></li>-->
                        </ul>
                    </li>
                    <li class="list-group-item"><strong>Destino:</strong> <span class="text-primary float-right" id="modal_ruta_ver_destino"> jefe </span></li>
                </ul>
            </div>
        </div>


    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <div class="row col-12 justify-content-between m-0 p-0">
            <button type="button" class="btn btn-link btn-sm" id="modal_ruta_btn_editar">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button type="reset" class="btn btn-default" onclick="displayRutas()">Cerrar</button>
        </div>
    </div>
</div>