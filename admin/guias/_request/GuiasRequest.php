<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\GuiasController;
$controller = new GuiasController();

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
                    require '../_layout/guias/table.php';
                    break;

                case 'get_vehiculo':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $response = $controller->getVehiculo($id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_empresas':

                    $response = crearResponse(
                        null,
                        true,
                        null,
                        null,
                        'success',
                        false,
                        true);

                    foreach ($controller->getEmpresas() as $empresa) {
                        $id = $empresa['id'];
                        $nombre = mb_strtoupper($empresa['rif']." - ".$empresa['nombre']);
                        $response['listarEmpresas'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    break;

                case 'incrementar_contador':
                    if (!empty($_POST['guias_num_init'])){
                        $num_guia = $_POST['guias_num_init'];
                        $response = $controller->setNumeroGuia($num_guia);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'search':
                    if (!empty($_POST['keyword'])){
                        $paginate = true;
                        $keyword = $_POST['keyword'];
                        $controller->search($keyword);
                        require '../_layout/guias/table.php';
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
