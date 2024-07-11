<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-file-alt"></i>  GUÍAS</h1>
        </div>

        <div class="col-sm-6">
            <form class="row col-12 justify-content-end" id="formulari_guia_init">
                <div class="col-sm-8 col-lg-10 text-right">
                    <a href="_storage/guia_manual.php" target="_blank">
                        <i class="far fa-file-alt"></i>
                        Formato Guía Manual
                    </a>
                </div>
                <div class="col-sm-4 col-lg-2">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="guias_num_init" value="<?php echo $controller->GUIAS_NUM_INIT; ?>" size="6" placeholder="Num. Sig." id="guias_num_init">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="fas fa-save"></i></button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="opcion" value="incrementar_contador">
            </form>
        </div>

    </div>
</div><!-- /.container-fluid -->