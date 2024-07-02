<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\VehiculosController;
$controller = new VehiculosController();

$response = array();
$paginate = false;

if ($_POST) {

    if (!empty($_POST['opcion'])) {

        $opcion = $_POST['opcion'];

        try {

            switch ($opcion) {

                //definimos las opciones a procesar

                case 'paginate':

                    $paginate = true;

                    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
                    $limit = !empty($_POST['limit']) ? $_POST['limit'] : 10;
                    $baseURL = !empty($_POST['baseURL']) ? $_POST['baseURL'] : 'getData.php';
                    $totalRows = !empty($_POST['totalRows']) ? $_POST['totalRows'] : 0;
                    $tableID = !empty($_POST['tableID']) ? $_POST['tableID'] : 'table_database';
                    $contenDiv = !empty($_POST['contentDiv']) ? $_POST['contentDiv'] : 'dataContainer';

                    $controller->index($baseURL, $tableID, $limit, $totalRows, $offset, $opcion, $contenDiv);
                    require '../_layout/card_table_vehiculos.php';

                    break;

                case 'index':
                    $paginate = true;
                    $controller->index();
                    require '../_layout/card_table_vehiculos.php';
                    break;

                case 'store':
                    if (
                        !empty($_POST['vehiculos_select_empresa']) &&
                        !empty($_POST['vehiculos_input_placa_batea']) &&
                        !empty($_POST['vehiculos_select_tipo']) &&
                        !empty($_POST['vehiculos_input_marca']) &&
                        !empty($_POST['vehiculos_input_color']) &&
                        !empty($_POST['vehiculos_input_capacidad'])
                    ){
                        $empresas_id = $_POST['vehiculos_select_empresa'];
                        $placa_batea = $_POST['vehiculos_input_placa_batea'];
                        $placa_chuto = $_POST['vehiculos_input_placa_chuto'];
                        $tipo = $_POST['vehiculos_select_tipo'];
                        $marca = $_POST['vehiculos_input_marca'];
                        $color = $_POST['vehiculos_input_color'];
                        $capacidad = $_POST['vehiculos_input_capacidad'];

                        $response = $controller->store($empresas_id, $placa_batea, $placa_chuto, $tipo, $marca, $color, $capacidad);
                        if ($response['result']){
                            $paginate = true;
                            $controller->index();
                            require '../_layout/card_table_vehiculos.php';
                        }
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'edit':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $response = $controller->edit($id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'update':
                    if (
                        !empty($_POST['vehiculos_select_empresa']) &&
                        !empty($_POST['vehiculos_input_placa_batea']) &&
                        !empty($_POST['vehiculos_select_tipo']) &&
                        !empty($_POST['vehiculos_input_marca']) &&
                        !empty($_POST['vehiculos_input_color']) &&
                        !empty($_POST['vehiculos_input_capacidad'])
                    ){
                        $empresas_id = $_POST['vehiculos_select_empresa'];
                        $placa_batea = $_POST['vehiculos_input_placa_batea'];
                        $placa_chuto = $_POST['vehiculos_input_placa_chuto'];
                        $tipo = $_POST['vehiculos_select_tipo'];
                        $marca = $_POST['vehiculos_input_marca'];
                        $color = $_POST['vehiculos_input_color'];
                        $capacidad = $_POST['vehiculos_input_capacidad'];
                        $id = $_POST['vehiculos_id'];

                        $response = $controller->update($empresas_id, $placa_batea, $placa_chuto, $tipo, $marca, $color, $capacidad, $id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_datos_vehiculo':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $response = $controller->get_datos_vehiculo($id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'destroy':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $response = $controller->destroy($id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'search':
                    if (!empty($_POST['keyword'])){
                        $paginate = true;
                        $keyword = $_POST['keyword'];
                        $controller->search($keyword);
                        require '../_layout/card_table_vehiculos.php';
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;


                //Por defecto
                default:
                    $response = crearResponse('no_opcion', false, null, $opcion);
                    break;
            }

        } catch (PDOException $e) {
            $response = crearResponse('error_excepcion', false, null, "PDOException {$e->getMessage()}");
        } catch (Exception $e) {
            $response = crearResponse('error_excepcion', false, null, "General Error: {$e->getMessage()}");
        }

    } else {
        $response = crearResponse('error_opcion');
    }
} else {
    $response = crearResponse('error_method');
}

if (!$paginate){
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
