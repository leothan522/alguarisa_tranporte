<?php
$listarChoferes = $controller->rows;
$links = $controller->links;
$i = $controller->offset;
$x = 0;
?>
<div class="card card-primary">
    <div class="card-header">

        <h3 class="card-title">Registrados [ <span class="text-warning text-bold"><?php echo $controller->totalRows?></span> ]</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal_form-choferes" id="btn_modal_form"
                    onclick="cambiarForm()">
                <i class="fas fa-file-alt"></i> Nuevo
            </button>

        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive" style="height: 60vh; ">
            <table class="table table-sm table-head-fixed table-hover text-nowrap"  id="table_choferes">
                <thead>
                <tr class="text-center">
                    <th style="width: 10px">#</th>
                    <th>Cédula</th>
                    <th>Nombre y Apellido</th>
                    <th>Teléfono</th>
                    <th>Placa Batea</th>
                    <th style="width: 5px;"> </th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarChoferes as $chofer){
                    $vehiculo = $controller->vehiculos($chofer['vehiculos_id']);
                    $i++;

                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td class="text-right pr-2" ><?php echo formatoMillares($chofer['cedula']); ?></td>
                    <td class="text-left pl-2"><?php echo $chofer['nombre']; ?></td>
                    <td><?php echo $chofer['telefono']; ?> </td>
                    <td><span class="btn btn-link" data-toggle="modal"
                              data-target="#modal_datos_vehiculos" onclick="cambiarForm(); datosVehiculo(<?php echo $vehiculo['id'] ?>)"><?php echo $vehiculo['placa_batea']; ?></span></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-info"
                                    onclick="editChofer(<?php echo $chofer['id']; ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-info"
                                    onclick="destroyChofer(<?php echo $chofer['id']; ?>)"
                                    id="btn_eliminar_chofer_<?php echo $chofer['id']; ?>">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php  } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <?php echo $links; ?>
    </div>
</div>