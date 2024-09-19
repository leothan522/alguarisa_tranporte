<?php
session_start();
require_once "../../../vendor/autoload.php";
use app\controller\GuiasController;


$controller = new GuiasController();
$controller->isAdmin();

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

                case 'index':
                    $paginate = true;
                    $controller->index();
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
                        $id = $empresa['rowquid'];
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

                case 'create':
                    $response  = $controller->create();
                    break;

                case 'edit':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $create = $controller->create();
                        $edit = $controller->edit($id);
                        $response = array_merge($create, $edit);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'show':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $response = $controller->showGuia($id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'get_codigo':
                    if (
                        !empty($_POST['tipos_id'])
                    ){
                        $tipos_id = $_POST['tipos_id'];
                        $id = $_POST['id'];
                        $response = $controller->getCodigo($tipos_id, $id);
                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'store':
                    if (
                        !empty($_POST['guias_tipo_id']) &&
                        !empty($_POST['codigo']) &&
                        !empty($_POST['vehiculos_id']) &&
                        !empty($_POST['choferes_id']) &&
                        !empty($_POST['territorios_origen']) &&
                        !empty($_POST['territorios_destino']) &&
                        !empty($_POST['fecha']) &&
                        isset($_POST['precinto']) &&
                        isset($_POST['precinto_2']) &&
                        isset($_POST['precinto_3'])
                    )
                    {
                        $guias_tipos_id = $_POST['guias_tipo_id'];
                        $codigo = $_POST['codigo'];
                        $vehiculos_id = $_POST['vehiculos_id'];
                        $choferes_id = $_POST['choferes_id'];
                        $territorios_origen = $_POST['territorios_origen'];
                        $territorios_destino = $_POST['territorios_destino'];
                        $fecha = $_POST['fecha'];
                        $users_id = $controller->USER_ID;
                        $cantidad = $_POST['cantidad_1'];
                        $descripcion = $_POST['descripcion_1'];
                        $contador = $_POST['contador_guia'];

                        if (empty($_POST['precinto'])){
                            $precinto = null;
                        }else{
                            $precinto = $_POST['precinto'];
                        }

                        if (empty($_POST['precinto_2'])){
                            $precinto_2 = null;
                        }else{
                            $precinto_2 = $_POST['precinto_2'];
                        }

                        if (empty($_POST['precinto_3'])){
                            $precinto_3 = null;
                        }else{
                            $precinto_3 = $_POST['precinto_3'];
                        }

                        $response = $controller->store($guias_tipos_id, $codigo, $vehiculos_id, $choferes_id, $territorios_origen, $territorios_destino, $fecha, $users_id, $precinto, $precinto_2, $precinto_3, $contador);
                        if ($response['result']){
                            $paginate = true;
                            $controller->index();
                            require '../_layout/guias/table.php';
                        }

                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'update':
                    if (
                        !empty($_POST['guias_tipo_id']) &&
                        !empty($_POST['codigo']) &&
                        !empty($_POST['vehiculos_id']) &&
                        !empty($_POST['choferes_id']) &&
                        !empty($_POST['territorios_origen']) &&
                        !empty($_POST['territorios_destino']) &&
                        !empty($_POST['fecha']) &&
                        !empty($_POST['guias_id']) &&
                        isset($_POST['precinto']) &&
                        isset($_POST['precinto_2']) &&
                        isset($_POST['precinto_3'])
                    ) {
                        $guias_tipos_id = $_POST['guias_tipo_id'];
                        $codigo = $_POST['codigo'];
                        $vehiculos_id = $_POST['vehiculos_id'];
                        $choferes_id = $_POST['choferes_id'];
                        $territorios_origen = $_POST['territorios_origen'];
                        $territorios_destino = $_POST['territorios_destino'];
                        $fecha = $_POST['fecha'];
                        $users_id = $controller->USER_ID;

                        $id = $_POST['guias_id'];
                        $contador = $_POST['contador_guia'];

                        if (empty($_POST['precinto'])){
                            $precinto = null;
                        }else{
                            $precinto = $_POST['precinto'];
                        }

                        if (empty($_POST['precinto_2'])){
                            $precinto_2 = null;
                        }else{
                            $precinto_2 = $_POST['precinto_2'];
                        }

                        if (empty($_POST['precinto_3'])){
                            $precinto_3 = null;
                        }else{
                            $precinto_3 = $_POST['precinto_3'];
                        }

                        $response = $controller->update($id, $guias_tipos_id, $codigo, $vehiculos_id, $choferes_id, $territorios_origen, $territorios_destino, $fecha, $users_id, $precinto, $precinto_2, $precinto_3, $contador);


                    }else{
                        $response = crearResponse('faltan_datos');
                    }
                    break;

                case 'destroy':
                    if (!empty($_POST['id'])){
                        $id = $_POST['id'];
                        $opt = $_POST['opt'];
                        $response = $controller->destroy($id, $opt);
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
