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
                    require "../_layout/card_table_choferes.php";

                    break;

                case 'index':
                    $paginate = true;
                    $controller->index();
                    require '../_layout/card_table_choferes.php';
                    break;

                case 'store':
                    if (!empty($_POST['choferes_select_empresa']) &&
                        !empty($_POST['choferes_select_vehiculo']) &&
                        !empty($_POST['choferes_input_cedula']) &&
                        !empty($_POST['choferes_input_nombre']) &&
                        !empty($_POST['choferes_input_telefono'])
                    ){
                        $empresas = $_POST['choferes_select_empresa'];
                        $vehiculos = $_POST['choferes_select_vehiculo'];
                        $cedula = $_POST['choferes_input_cedula'];
                        $nombre = $_POST['choferes_input_nombre'];
                        $telefono = $_POST['choferes_input_telefono'];

                        $response = $controller->store($empresas, $vehiculos, $cedula, $nombre, $telefono);
                        if ($response['result']){
                            $paginate = true;
                            $controller->index();
                            require '../_layout/card_table_choferes.php';
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
                    if (!empty($_POST['choferes_select_empresa']) &&
                        !empty($_POST['choferes_select_vehiculo']) &&
                        !empty($_POST['choferes_input_cedula']) &&
                        !empty($_POST['choferes_input_nombre']) &&
                        !empty($_POST['choferes_input_telefono']) &&
                        !empty($_POST['choferes_id'])
                    ){
                        $empresas = $_POST['choferes_select_empresa'];
                        $vehiculos = $_POST['choferes_select_vehiculo'];
                        $cedula = $_POST['choferes_input_cedula'];
                        $nombre = $_POST['choferes_input_nombre'];
                        $telefono = $_POST['choferes_input_telefono'];
                        $id = $_POST['choferes_id'];

                        $response = $controller->update($empresas, $vehiculos, $cedula, $nombre, $telefono, $id);

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
                        require '../_layout/card_table_choferes.php';

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
