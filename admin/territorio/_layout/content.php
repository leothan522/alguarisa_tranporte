<div class="row justify-content-center">
    <div class="col-md-8">

        <ul class="nav nav-tabs d-none" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                   href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                   aria-selected="true">
                    Municipios
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                   href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                   aria-selected="false">
                    Parroquias
                </a>
            </li>
        </ul>

        <div class="tab-content" id="custom-tabs-one-tabContent">

            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                 aria-labelledby="custom-tabs-one-home-tab">
                <div id="dataContainerMunicipio">
                    <?php
                    $controller->index();
                    require_once "card_table_municipios.php"
                    ?>
                </div>
                <?php require_once "modal_municipios.php" ?>
            </div>

            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                 aria-labelledby="custom-tabs-one-profile-tab">
                <div id="dataContainerParroquia">
                    <?php
                    $controller->index('parroquias');
                    require_once "card_table_parroquias.php"
                    ?>
                </div>
                <?php require_once "modal_parroquias.php" ?>
            </div>

        </div>
        
    </div>
</div>












