<div class="row justify-content-center">
    <div class="col-md-4 col-lg-3" id="col_form">
        <label>Parametros manuales</label>
        <ul>
            <li class="text-wrap">
                numRowsPaginate
                [null|int]
            </li>
            <li class="text-wrap">
                guias_color_rgb
                [null|black/blue/(r,g,b)]
            </li>
            <li class="text-wrap">
                guias_num_init
                [null|int]
            </li>
            <li class="text-wrap">
                guias_formatos_pdf
                [null|string]
            </li>
            <li class="text-wrap">
                id_capital_estado
                [int|null]
            </li>
            <li class="text-wrap">
                size_codigo
                [int|null]
            </li>
        </ul>
    </div>
    <div class="col-md-8 col-lg-9">
        <div id="dataContainerParametros">
        <?php
        $controller->index();
        require_once "table.php";
        ?>
        </div>
    </div>
    <?php require 'modal.php' ?>
</div>