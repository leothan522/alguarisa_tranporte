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
