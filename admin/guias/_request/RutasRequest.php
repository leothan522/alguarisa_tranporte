<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\RutasController;
$controller = new RutasController();

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
                    $listarRutas = $controller->rows;
                    $totalRowsRutas = $controller->totalRows;
                    $links = $controller->links;
                    $i = $controller->offset;
                    $keyword = $controller->keyword;
                    $x = 0;
                    require '../_layout/rutas/table.php';

                    break;

                case 'index':
                    $paginate = true;
                    $controller->index();
                    $listarRutas = $controller->rows;
                    $totalRowsRutas = $controller->totalRows;
                    $links = $controller->links;
                    $i = $controller->offset;
                    $keyword = $controller->keyword;
                    $x = 0;
                    require '../_layout/rutas/table.php';
                    break;

                case 'get_parroquias':
                    $response = crearResponse(
                        null,
                        true,
                        null,
                        null,
                        'success',
                        false,
                        true);

                    foreach ($controller->getParroquias() as $parroquia) {
                        $id = $parroquia['id'];
                        $nombre = mb_strtoupper($parroquia['nombre']);
                        $response['listarParroquias'][] = array("id" => $id, "nombre" => $nombre);
                    }

                    break;

                case 'store':
                    if (
                        !empty($_POST['origen']) &&
                        !empty($_POST['contador']) &&
                        !empty($_POST['destino'])
                    ){
                        $origen = $_POST['origen'];
                        $contador = $_POST['contador'];
                        $destino = $_POST['destino'];

                        $response = $controller->store($origen, $contador, $destino);
                        if ($response['result']){
                            $paginate = true;
                            $controller->index();
                            $listarRutas = $controller->rows;
                            $totalRowsRutas = $controller->totalRows;
                            $links = $controller->links;
                            $i = $controller->offset;
                            $keyword = $controller->keyword;
                            $x = 0;
                            require '../_layout/rutas/table.php';
                        }

                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_ruta':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $response = $controller->getRuta($id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'update':
                    if (
                        !empty($_POST['origen']) &&
                        !empty($_POST['contador']) &&
                        !empty($_POST['destino']) &&
                        !empty($_POST['rutas_id'])
                    ){
                        $origen = $_POST['origen'];
                        $contador = $_POST['contador'];
                        $destino = $_POST['destino'];
                        $id = $_POST['rutas_id'];

                        $response = $controller->update($origen, $contador, $destino, $id);

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
                        $keyword = $_POST['keyword'];

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
