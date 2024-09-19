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
                    $listarvehiculos = $controller->rows;
                    $totalRowsVehiculos = $controller->totalRows;
                    $links = $controller->links;
                    $i = $controller->offset;
                    $keyword = $controller->keyword;
                    $x = 0;
                    require '../_layout/vehiculos/table.php';

                    break;

                case 'index':
                    $paginate = true;
                    $controller->index();
                    $listarvehiculos = $controller->rows;
                    $totalRowsVehiculos = $controller->totalRows;
                    $links = $controller->links;
                    $i = $controller->offset;
                    $keyword = $controller->keyword;
                    $x = 0;
                    require '../_layout/vehiculos/table.php';
                    break;

                case 'get_tipos':
                    $response = crearResponse(
                        null,
                        true,
                        null,
                        null,
                        'success',
                        false,
                        true);

                    foreach ($controller->getTipos() as $tipo) {
                        $id = $tipo['rowquid'];
                        $nombre = mb_strtoupper($tipo['nombre']);
                        $response['listarTipos'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    break;

                case 'store':
                    if (
                        !empty($_POST['empresas_id']) &&
                        !empty($_POST['placa_batea']) &&
                        !empty($_POST['tipos_id']) &&
                        !empty($_POST['marca']) &&
                        !empty($_POST['color']) &&
                        !empty($_POST['capasidad'])
                    ){
                        $empresas_id = $_POST['empresas_id'];
                        $placa_batea = $_POST['placa_batea'];
                        $placa_chuto = $_POST['placa_chuto'];
                        $tipo = $_POST['tipos_id'];
                        $marca = $_POST['marca'];
                        $color = $_POST['color'];
                        $capacidad = $_POST['capasidad'];

                        $response = $controller->store($empresas_id, $placa_batea, $placa_chuto, $tipo, $marca, $color, $capacidad);
                        if ($response['result']){
                            $paginate = true;
                            $controller->index();
                            $listarvehiculos = $controller->rows;
                            $totalRowsVehiculos = $controller->totalRows;
                            $links = $controller->links;
                            $i = $controller->offset;
                            $keyword = $controller->keyword;
                            $x = 0;
                            require '../_layout/vehiculos/table.php';
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
                        !empty($_POST['empresas_id']) &&
                        !empty($_POST['placa_batea']) &&
                        !empty($_POST['tipos_id']) &&
                        !empty($_POST['marca']) &&
                        !empty($_POST['color']) &&
                        !empty($_POST['capasidad'])
                    ){
                        $empresas_id = $_POST['empresas_id'];
                        $placa_batea = $_POST['placa_batea'];
                        $placa_chuto = $_POST['placa_chuto'];
                        $tipo = $_POST['tipos_id'];
                        $marca = $_POST['marca'];
                        $color = $_POST['color'];
                        $capacidad = $_POST['capasidad'];
                        $id = $_POST['vehiculos_id'];

                        $response = $controller->update($empresas_id, $placa_batea, $placa_chuto, $tipo, $marca, $color, $capacidad, $id);
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
                        $listarvehiculos = $controller->rows;
                        $totalRowsVehiculos = $controller->totalRows;
                        $links = $controller->links;
                        $i = $controller->offset;
                        $keyword = $controller->keyword;
                        $x = 0;
                        require '../_layout/vehiculos/table.php';
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
