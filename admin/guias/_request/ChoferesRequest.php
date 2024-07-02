<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\ChoferesController;
$controller = new ChoferesController();

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
                    $listarChoferes = $controller->rows;
                    $totalRowsChoferes = $controller->totalRows;
                    $links = $controller->links;
                    $i = $controller->offset;
                    $keyword = $controller->keyword;
                    $x = 0;
                    require '../_layout/choferes/table.php';

                    break;

                case 'index':
                    $paginate = true;
                    $controller->index();
                    $listarChoferes = $controller->rows;
                    $totalRowsChoferes = $controller->totalRows;
                    $links = $controller->links;
                    $i = $controller->offset;
                    $keyword = $controller->keyword;
                    $x = 0;
                    require '../_layout/choferes/table.php';
                    break;

                case 'store':
                    if (!empty($_POST['empresas_id']) &&
                        !empty($_POST['vehiculos_id']) &&
                        !empty($_POST['cedula']) &&
                        !empty($_POST['nombre']) &&
                        !empty($_POST['telefono'])
                    ){
                        $empresas = $_POST['empresas_id'];
                        $vehiculos = $_POST['vehiculos_id'];
                        $cedula = $_POST['cedula'];
                        $nombre = $_POST['nombre'];
                        $telefono = $_POST['telefono'];

                        $response = $controller->store($empresas, $vehiculos, $cedula, $nombre, $telefono);
                        if ($response['result']){
                            $paginate = true;
                            $controller->index();
                            $listarChoferes = $controller->rows;
                            $totalRowsChoferes = $controller->totalRows;
                            $links = $controller->links;
                            $i = $controller->offset;
                            $keyword = $controller->keyword;
                            $x = 0;
                            require '../_layout/choferes/table.php';
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
                    if (!empty($_POST['empresas_id']) &&
                        !empty($_POST['vehiculos_id']) &&
                        !empty($_POST['cedula']) &&
                        !empty($_POST['nombre']) &&
                        !empty($_POST['telefono']) &&
                        !empty($_POST['choferes_id'])
                    ){
                        $empresas = $_POST['empresas_id'];
                        $vehiculos = $_POST['vehiculos_id'];
                        $cedula = $_POST['cedula'];
                        $nombre = $_POST['nombre'];
                        $telefono = $_POST['telefono'];
                        $id = $_POST['choferes_id'];

                        $response = $controller->update($empresas, $vehiculos, $cedula, $nombre, $telefono, $id);

                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'destroy':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $response = $controller->delete($id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'search':
                    if (!empty($_POST['keyword'])){
                        $paginate = true;
                        $keyword = $_POST['keyword'];
                        $controller->search($keyword);
                        $listarChoferes = $controller->rows;
                        $totalRowsChoferes = $controller->totalRows;
                        $links = $controller->links;
                        $i = $controller->offset;
                        $keyword = $controller->keyword;
                        $x = 0;
                        require '../_layout/choferes/table.php';

                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_vehiculos':
                    $response = crearResponse(
                        null,
                        true,
                        null,
                        null,
                        'success',
                        false,
                        true);

                    foreach ($controller->getVehiculos() as $vehiculo) {
                        $id = $vehiculo['id'];
                        $tipo = $controller->getTipo($vehiculo['tipo']);
                        $nombre = mb_strtoupper($vehiculo['placa_batea']." - ".$tipo['nombre']);
                        $response['listarVehiculos'][] = array("id" => $id, "nombre" => $nombre);
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
