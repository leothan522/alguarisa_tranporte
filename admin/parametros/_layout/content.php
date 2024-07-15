<div class="row justify-content-center">
    <div class="col-md-4" id="col_form">
        <?php require_once "form.php"?>
    </div>
    <div class="col-md-8">
        <div id="dataContainerParametros">
        <?php
        $controller->index();
        require_once "table.php";
        ?>
        </div>
    </div>
    <div class="col-12">
        <label>Parametros manuales</label>
        <ul>
            <li>numRowsPaginate[null|int]</li>
            <li>guias_color_rgb[null|black/blue/(r,g,b)]</li>
            <li>guias_num_init[null|int]</li>
            <li>guias_formatos_pdf[null|string]</li>
        </ul>
    </div>
</div>