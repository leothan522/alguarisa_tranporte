<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-file-alt"></i>  GUÍAS</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <form class="row mr-2" action="guardar.php" method="post" id="formulari_guia_init">
                    <div class="col-8 p-0 m-0">
                        <div class="input-group">
                            <a href="formatos/guia_manual.php" class="btn btn-link float-right d-inline">
                                <i class="far fa-file-alt"></i>
                                Formato Guía Manual
                            </a>
                        </div>
                    </div>
                    <div class="col-4 p-0 m-0">
                        <div class="input-group">
                            <input type="text" class="form-control" name="guias_num_init" value="" size="6" placeholder="Num. Sig." id="guias_num_init">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-save"></i></button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="opcion" value="incrementar_contador">
                </form>
            </ol>
        </div>
    </div>
</div><!-- /.container-fluid -->