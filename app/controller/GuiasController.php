<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Chofere;
use app\model\Empresa;
use app\model\Guia;
use app\model\GuiasCarga;
use app\model\GuiasTipo;
use app\model\Municipio;
use app\model\Parametro;
use app\model\Parroquia;
use app\model\Ruta;
use app\model\RutasTerritorio;
use app\model\Vehiculo;
use app\model\VehiculoTipo;

class GuiasController extends Admin
{
    public string $TITTLE = 'Guias';
    public string $MODULO = 'guias.index';

    public $rows;
    public $totalRows;
    public $links;
    public $limit;
    public $offset;
    public $keyword;
    public $prueba;

    public int $GUIAS_NUM_INIT = 1;
    public int $ID_GUIAS_NUM_INIT = 0;
    public string $FORMATO_GUIA_PDF = 'null';
    public int $ID_FORMATO_GUIA = 0;


    //variables exclusivas para el pdf
    public $codigo, $guias_tipos_id, $tipos_nombre, $vehiculos_id, $vehiculos_tipo, $vehiculos_marca,
        $vehiculos_placa_batea, $vehiculos_placa_chuto, $vehiculos_color, $vehiculos_capacidad, $choferes_id,
        $choferes_cedula, $choferes_nombre, $choferes_telefono, $territorios_origen, $territorios_destino, $rutas_id,
        $rutas_origen, $rutas_destino, $rutas_ruta, $fecha, $user_id, $band, $created_at, $auditoria, $deleted_at,
        $pdf_id, $pdf_impreso, $estatus, $precinto, $precinto_2, $precinto_3, $version, $origen_municipio, $destino_municipio, $trayecto,
        $color_cargamento = [], $listarCargamento;


    public function isAdmin()
    {
        parent::isAdmin(); // TODO: Change the autogenerated stub
        if (!validarPermisos($this->MODULO)) {
            header('location: ' . ROOT_PATH . 'admin\\');
        }
        $this->getNumeroGuia();
        $this->index();
        $this->getFormato();
    }

    public function getVehiculo($id): array
    {
        $model = new Vehiculo();
        $modelEmpresa = new Empresa();
        $vehiculos = $model->find($id);
        $empresas = $modelEmpresa->find($vehiculos['empresas_id']);
        $choferes = new ChoferesController();
        $tipo = $choferes->getTipo($vehiculos['tipo']);

        $response = crearResponse(
            false,
            true,
            'Get Chofer',
            'Get Chofer',
            'success',
            false,
            true
        );
        $response['placa_batea'] = $vehiculos['placa_batea'];
        $response['marca'] = $vehiculos['marca'];
        $response['tipo'] = $tipo['nombre'];
        $response['color_vehiculo'] = $vehiculos['color'];
        $response['placa_chuto'] = $vehiculos['placa_chuto'];
        $response['rif'] = $empresas['rif'];
        $response['nombre'] = verUtf8($empresas['nombre']);
        $response['responsable'] = verUtf8($empresas['responsable']);
        $response['telefono'] = $empresas['telefono'];

        return $response;
    }

    public function getEmpresas(): array
    {
        $model = new Empresa();
        return $model->getAll('1');
    }

    public function getColor(): array
    {
        $model = new Parametro();
        $color = [0, 0, 0];
        $parametro = $model->first('nombre', '=', 'guias_color_rgb');
        if ($parametro) {
            switch ($parametro['valor']) {
                case 'black':
                    $r = 0;
                    $g = 0;
                    $b = 0;
                    break;

                case 'blue':
                    $r = 0;
                    $g = 0;
                    $b = 128;
                    break;


                default:

                    $valor = strpos($parametro['valor'], ',');
                    if ($valor === false) {
                        $r = 0;
                        $g = 0;
                        $b = 0;
                    } else {
                        $explode = explode(',', $parametro['valor']);
                        if (count($explode) === 3) {
                            if (is_numeric($explode[0]) && ($explode[0] >= 0) && ($explode[0] <= 255)) {
                                $r = $explode[0];
                            } else {
                                $r = 0;
                            }

                            if (is_numeric($explode[1]) && ($explode[1] >= 0) && ($explode[1] <= 255)) {
                                $g = $explode[1];
                            } else {
                                $g = 0;
                            }

                            if (is_numeric($explode[2]) && ($explode[2] >= 0) && ($explode[2] <= 255)) {
                                $b = $explode[1];
                            } else {
                                $b = 0;
                            }

                        } else {
                            $r = 0;
                            $g = 0;
                            $b = 0;
                        }
                    }

                    break;
            }
            $color = [$r, $g, $b];
        }
        return $color;
    }

    public function getNumeroGuia()
    {
        $model = new Parametro();
        $parametro = $model->first('nombre', '=', 'guias_num_init');
        if ($parametro) {
            $this->GUIAS_NUM_INIT = $parametro['valor'];
            $this->ID_GUIAS_NUM_INIT = $parametro['id'];
        }
    }

    public function setNumeroGuia($num_guia): array
    {
        $this->getNumeroGuia();
        $actual = $this->GUIAS_NUM_INIT;
        $model = new Parametro();

        if ($num_guia != $actual) {
            if ($this->ID_GUIAS_NUM_INIT) {
                $model->update($this->ID_GUIAS_NUM_INIT, 'valor', $num_guia);
            } else {
                $data = [
                    'guias_num_init',
                    null,
                    $num_guia
                ];
                $model->save($data);
            }
            $response = crearResponse(
                false,
                true,
                'Numero de Guia Actualizado.'
            );
        } else {
            if ($num_guia == $actual) {
                $response = crearResponse(
                    'sin_cambios',
                    false,
                    'Proximo Número de Guía',
                    'No se realizo ningun cambio.',
                    'warning',
                    true
                );
            }

        }
        return $response;

    }

    public function index(
        $baseURL = '_request/GuiasRequest.php',
        $tableID = 'table_guias',
        $limit = null,
        $totalRows = null,
        $offset = null,
        $opcion = 'paginate',
        $contentDiv = 'div_guias'
    )
    {

        $model = new Guia();
        if (is_null($limit)) {
            $this->limit = numRowsPaginate();
        } else {
            $this->limit = $limit;
        }
        if (is_null($totalRows)) {
            $this->totalRows = $model->count(1);
        } else {
            $this->totalRows = $totalRows;
        }
        $this->offset = $offset;

        $this->links = paginate(
            $baseURL,
            $tableID,
            $this->limit,
            $this->totalRows,
            $offset,
            $opcion,
            $contentDiv
        )->createLinks();

        $this->rows = $model->paginate($this->limit, $offset, 'id', 'DESC', 1);
    }

    public function getGuiaPrint($id)
    {
        $redireccionar = false;
        if (empty($id)) {
            $redireccionar = true;
        }
        $model = new Guia();
        $modelCargamento = new GuiasCarga();

        $guia = $model->find($id);

        if ($guia) {
            //sigo procesando
            $this->codigo = $guia['codigo'];
            $this->guias_tipos_id = $guia['guias_tipos_id'];
            $this->tipos_nombre = mb_strtoupper(verUtf8($guia['tipos_nombre']));
            $this->vehiculos_id = $guia['vehiculos_id'];
            $this->vehiculos_tipo = verUtf8($guia['vehiculos_tipo']);
            $this->vehiculos_marca = mb_strtoupper(verUtf8($guia['vehiculos_marca']));
            $this->vehiculos_placa_batea = mb_strtoupper(verUtf8($guia['vehiculos_placa_batea']));
            $this->vehiculos_placa_chuto = mb_strtoupper(verUtf8($guia['vehiculos_placa_chuto']));
            $this->vehiculos_color = mb_strtoupper(verUtf8($guia['vehiculos_color']));
            $this->vehiculos_capacidad = mb_strtoupper($guia['vehiculos_capacidad']);
            $this->choferes_id = $guia['choferes_id'];
            $this->choferes_cedula = formatoMillares($guia['choferes_cedula']);
            $this->choferes_nombre = mb_strtoupper($guia['choferes_nombre']);
            $this->choferes_telefono = $guia['choferes_telefono'];
            $this->territorios_origen = $guia['territorios_origen'];
            $this->territorios_destino = $guia['territorios_destino'];
            $this->rutas_id = $guia['rutas_id'];
            $this->rutas_origen = mb_strtoupper(verUtf8($guia['rutas_origen']));
            $this->rutas_destino = mb_strtoupper(verUtf8($guia['rutas_destino']));
            $this->rutas_ruta = $guia['rutas_ruta'];
            $this->fecha = verFecha($guia['fecha']);
            $this->user_id = $guia['users_id'];
            $this->band = $guia['band'];
            $this->created_at = $guia['created_at'];
            $this->auditoria = $guia['auditoria'];
            $this->deleted_at = $guia['deleted_at'];
            $this->pdf_id = $guia['pdf_id'];
            $this->pdf_impreso = $guia['pdf_impreso'];
            $this->estatus = $guia['estatus'];
            if ($guia['precinto']) {
                $this->precinto = mb_strtoupper(verUtf8($guia['precinto']));
            }
            if ($guia['precinto_2']) {
                $this->precinto_2 = mb_strtoupper(verUtf8($guia['precinto_2']));
            }
            if ($guia['precinto_3']) {
                $this->precinto_3 = mb_strtoupper(verUtf8($guia['precinto_3']));
            }
            $this->version = $guia['version'];
            $this->origen_municipio = $this->getGuiaMunicipio($this->territorios_origen, $this->version);
            $this->destino_municipio = $this->getGuiaMunicipio($this->territorios_destino, $this->version);


            $ruta = "";
            if (is_array(json_decode($this->rutas_ruta))) {
                $listarTerritorios = json_decode($guia['rutas_ruta']);
                foreach ($listarTerritorios as $lugar) {
                    $ruta .= ucfirst($lugar) . ", ";
                }
            }

            $this->trayecto = $ruta;

            switch ($guia['guias_tipos_id']) {
                case 2:
                    $r = 255;
                    $g = 95;
                    $b = 53;
                    $this->color_cargamento = [$r, $g, $b];
                    break;
                default:
                    $r = 51;
                    $g = 246;
                    $b = 255;
                    $this->color_cargamento = [$r, $g, $b];
                    break;
            }

            $this->listarCargamento = $modelCargamento->getList('guias_id', '=', $guia['id']);
            //$model->update($id, 'pdf_impreso', 1);


        } else {
            $redireccionar = true;
        }


        if ($redireccionar) {
            header('location: ' . ROOT_PATH . 'admin\\');
        }
    }

    public function getGuiaMunicipio($id, $version): string
    {
        $municipio = '';
        if ($version) {
            //consulta las tablas nuevas
            $model = new Parroquia();
            $modelMunicipio = new Municipio();
            $modelParametro = new Parametro();
            $ruta = $model->find($id);
            $get_municipio = $modelMunicipio->find($ruta['municipios_id']);

            if ($ruta) {
                $capital = '';
                $parametro = $modelParametro->first('nombre', '=', 'id_capital_estado');
                if ($parametro) {
                    if ($parametro['tabla_id'] == $get_municipio['id']) {
                        $capital = ' CAPITAL';
                    }
                }
                $municipio = mb_strtoupper(verUtf8($get_municipio['nombre'] . $capital));
            }

        } else {
            //consulto la tabla vieja
            $model = new RutasTerritorio();
            $ruta = $model->find($id);

            if ($ruta) {
                $municipio = mb_strtoupper(verUtf8($ruta['municipio']));
            }

        }
        return $municipio;
    }

    public function getFormato()
    {
        $formato = getFormato();
        $this->FORMATO_GUIA_PDF = $formato[0];
        $this->ID_FORMATO_GUIA = $formato[1];

    }
    
    public function search($keyword)
    {

        $sql_fecha =  ''; //"fecha LIKE '%$keyword%'";
        $sql_codigo = ''; //"codigo LIKE '%$keyword%'";
        $sql_destino = ''; //"rutas_destino LIKE '%$keyword%'";
        $sql_chofer = ''; //"choferes_nombre LIKE '%$keyword%'";
        $sql_placa = ''; //"vehiculos_placa_batea LIKE '%$keyword%' ";

        $or_1 = '';
        $or_2 = '';
        $or_3 = '';
        $or_4 = '';
        $and = '';

        //validamos si es una fecha
        if (strtotime($keyword)){
            $fecha = verFecha($keyword, "Y-m-d");
            $sql_fecha = " fecha LIKE '%$fecha%' ";
        }else{

            $explode = explode('-', $keyword, 2);
            if (count($explode) > 1){
                //$this->prueba = count($explode);
                $mes = null;
                $year = null;
                if (validateSizeNumber($explode[1], 4)){
                    $year = $explode[1];
                }

                if (mesEspanol($explode[0])){
                    $mes = cerosIzquierda(mesEspanol($explode[0]), 2);
                }

                if ($mes && $year){
                    $sql_fecha = " fecha LIKE '%$year-$mes%' ";
                }else{
                    $sql_codigo = " codigo LIKE '%$keyword%' ";
                    $sql_destino = " rutas_destino LIKE '%$keyword%' ";
                    $sql_chofer = " choferes_nombre LIKE '%$keyword%' ";
                    $sql_placa = " vehiculos_placa_batea LIKE '%$keyword%' ";
                }

            }else{
                $sql_codigo = " codigo LIKE '%$keyword%' ";
                $sql_destino = " rutas_destino LIKE '%$keyword%' ";
                $sql_chofer = " choferes_nombre LIKE '%$keyword%' ";
                $sql_placa = " vehiculos_placa_batea LIKE '%$keyword%' ";
            }
        }


        if (!empty($sql_fecha) && !empty($sql_codigo)){
            $or_1 = 'OR';
        }

        if (!empty($sql_codigo) && !empty($sql_destino)){
            $or_2 = 'OR';
        }

        if (!empty($sql_destino) && !empty($sql_chofer)){
            $or_3 = 'OR';
        }

        if (!empty($sql_chofer) && !empty($sql_placa)){
            $or_4 = 'OR';
        }

        if (!empty($sql_fecha) || !empty($sql_codigo) || !empty($sql_destino) || !empty($sql_chofer) || !empty($sql_placa)){
            $and = 'AND';
        }

        $model = new Guia();
        $sql = "SELECT * FROM guias WHERE 
        $sql_fecha 
        $or_1
        $sql_codigo 
        $or_2
        $sql_destino
        $or_3
        $sql_chofer
        $or_4
        $sql_placa
        $and
        band = 1;";

        $this->rows = $model->sqlPersonalizado($sql, 'getAll');
        $this->keyword = $keyword;
    }

    public function getTipoVehiculo($id = null)
    {
        $model = new VehiculoTipo();

        if ($id) {
            return $model->first('id', '=', $id);
        }

        return $model->getAll();
    }

    public function create(): array
    {
        $model = new Guia();
        $modelTerritorio = new Parroquia();
        $modelGuiasTipo = new GuiasTipo();
        $modelVehiculos = new Vehiculo();
        $modelChofer = new Chofere();

        //$guia = $model->getAll(1);
        $sql = "SELECT * FROM parroquias WHERE estatus = '1';";
        $parroquias = $modelTerritorio->sqlPersonalizado($sql, 'getAll');
        $guiasTipo = $modelGuiasTipo->getAll();
        $vehiculos = $modelVehiculos->getAll(1);
        $choferes = $modelChofer->getAll(1);


        $response = crearResponse(
            null,
            true,
            null,
            null,
            'success',
            false,
            true);

        foreach ($parroquias as $lugar) {
            $id = $lugar['id'];
            $nombre = $lugar['nombre'];
            $response['listarTerritorios'][] = array("id" => $id,"nombre" => $nombre);
        }

        foreach ($guiasTipo as $tipo){
            $id = $tipo['id'];
            $nombre = $tipo['nombre'];
            $codigo = $tipo['codigo'];
            $response['listarTipos'][] = array("id" => $id, "nombre" => $nombre, "codigo" => $codigo);
        }

        foreach ($vehiculos as $vehiculo) {
            $id = $vehiculo['id'];
            $placa = $vehiculo['placa_batea'];
            $tipo = $this->getTipoVehiculo($vehiculo['tipo']);
            $nombre = $tipo['nombre'];
            $response['listarVehiculos'][] = array("id" => $id, "placa" => $placa, "tipo" => $nombre);
        }

        foreach ($choferes as $chofer){
            $id = $chofer['id'];
            $cedula = $chofer['cedula'];
            $nombre = $chofer['nombre'];
            $response['listarChofer'][] = array("id" => $id, "nombre" => $nombre, "cedula" => $cedula);
        }

        $response['hoy'] = date("Y-m-d");

        return $response;

    }

    public function store($guias_tipos_id, $codigo, $vehiculos_id, $choferes_id, $territorios_origen, $territorios_destino, $fecha, $users_id, $precinto, $precinto_2, $precinto_3, $contador): array
    {
        $model = new Guia();
        $modelGuiasTipo = new GuiasTipo();
        $modelGuiasCarga = new GuiasCarga();
        $modelVehiculos = new Vehiculo();
        $modelVehiculosTipo = new VehiculoTipo();
        $modelChoferes = new Chofere();
        $modelRutas = new Ruta();
        $modelRutasTerritorio = new Parroquia();
        $modelParametro = new Parametro();

        $tipoGuia = $modelGuiasTipo->find($guias_tipos_id);
        $tipoNombre = $tipoGuia['nombre'];

        $vehiculo = $modelVehiculos->find($vehiculos_id);
        $vehiculos_tipo_id = $vehiculo['tipo'];
        $vehiculo_marca = $vehiculo['marca'];
        $vehiculo_placa_batea = $vehiculo['placa_batea'];
        $vehiculo_placa_chuto = $vehiculo['placa_chuto'];
        $vehiculo_color = $vehiculo['color'];
        $vehiculo_capacidad = $vehiculo['capacidad'];
        $tipoVehiculo = $this->getTipoVehiculo($vehiculos_tipo_id);
        $vehiculo_tipo_nombre = $tipoVehiculo['nombre'];

        $chofer = $modelChoferes->find($choferes_id);
        $chofer_cedula = $chofer['cedula'];
        $chofer_nombre = $chofer['nombre'];
        $chofer_telefono = $chofer['telefono'];

        $ruta = $this->existeRuta($territorios_origen, $territorios_destino);

        if ($ruta){
            $rutas_id = $ruta['id'];
            $rutas_ruta = $ruta['ruta'];


            $origen = $modelRutasTerritorio->find($territorios_origen);
            $destino = $modelRutasTerritorio->find($territorios_destino);
            $rutas_origen = $origen['nombre'];
            $rutas_destino = $destino['nombre'];

            $pdf_id = $this->ID_FORMATO_GUIA;

            if ($pdf_id){
                $data = [
                    $codigo,
                    $guias_tipos_id,
                    $tipoNombre,
                    $vehiculos_id,
                    $vehiculo_tipo_nombre,
                    $vehiculo_marca,
                    $vehiculo_placa_batea,
                    $vehiculo_placa_chuto,
                    $vehiculo_color,
                    $vehiculo_capacidad,
                    $choferes_id,
                    $chofer_cedula,
                    $chofer_nombre,
                    $chofer_telefono,
                    $territorios_origen,
                    $territorios_destino,
                    $rutas_id,
                    $rutas_origen,
                    $rutas_destino,
                    $rutas_ruta,
                    $fecha,
                    $users_id,
                    date("Y-m-d"),
                    $pdf_id,
                    $precinto,
                    $precinto_2,
                    $precinto_3,
                    '1'
                ];

                $numeroGuia = explode('-', $codigo);

                $sql = "SELECT * FROM guias WHERE codigo LIKE '%$numeroGuia[1]%' AND band = 1 AND estatus = 1;";
                $existe = $model->sqlPersonalizado($sql);


                if (!$existe){
                    $model->save($data);
                    $response = crearResponse(
                        false,
                        true,
                        'Guardado Exitosamente',
                        'Guardado Exitosamente'
                    );
                    $sql = 'SELECT * FROM guias ORDER BY id DESC;';
                    $guia = $model->sqlPersonalizado($sql);
                    $id = $guia['id'];

                    $guias_num_init = $this->GUIAS_NUM_INIT + 1;
                    $existe_parametro = $modelParametro->existe('nombre', '=', 'guias_num_init');

                    if ($existe_parametro){
                        $editar = $modelParametro->update($existe_parametro['id'], 'valor', $guias_num_init);
                    }else{
                        $dataParametro = [
                            'guias_num_init',
                            0,
                            $guias_num_init
                        ];
                        $nuevo = $modelParametro->save($dataParametro);
                    }

                    $array = array();
                    for ($i = 1; $i <= $contador; $i++){
                        if (isset($_POST['cantidad_'. $i])){
                            $array[$i]['cantidad'] = $_POST['cantidad_'. $i];
                            $array[$i]['descripcion'] = $_POST['descripcion_'. $i];
                        }
                    }

                    foreach ($array as $carga){
                        $cantidad = $carga['cantidad'];
                        $descripcion = $carga['descripcion'];

                        $dataCarga = [
                            $id,
                            $cantidad,
                            $descripcion
                        ];

                        $guardarCarga = $modelGuiasCarga->save($dataCarga);
                    }


                }else {
                    $response = crearResponse(
                        'existe_guia',
                        false,
                        'Guía Duplicada.',
                        'Guía Duplicada.',
                        'warning'
                    );
                }

            }else{
                $response = crearResponse(
                    'no_formato',
                    false,
                    'Formato NO válido',
                    'NO SE HA DEFINIDO NINGÚN FORMATO DE GUIA EN LA BASE DE DATOS, CONTACTE CON SU ADMINISTRADOR.',
                    'warning',
                    true,
                    true
                );
            }
        }else{
            $response = crearResponse(
                'no_ruta',
                false,
                'Ruta NO válida',
                'NO EXISTE LA RUTA, DEBE CREARLA.',
                'warning',
                true,
                true
            );
        }

        return $response;

    }

    public function showGuia($id, $anular = false): array
    {
        $model = new Guia();
        $modelCarga = new GuiasCarga();
        $modelGuiasTipo = new GuiasTipo();
        $guia = $model->find($id);
        $cargamento = $modelCarga->getList('guias_id', '=', $id);
        $tipoGuia = $modelGuiasTipo->find($guia['guias_tipos_id']);
        $response = crearResponse(
            false,
            true,
            'show Guia',
            'show Guia',
            'success',
            false,
            true
        );
        $response['id'] = $guia['id'];
        $response['destino'] = $anular ? $this->showValue($guia['rutas_destino'], $guia['estatus']) : $guia['rutas_destino'];
        $response['codigo'] = $anular ? $this->showValue($guia['codigo'], $guia['estatus'], true) : $guia['codigo'];
        $response['fecha'] = $anular ? $this->showValue(verFecha($guia['fecha']), $guia['estatus']) : verFecha($guia['fecha']);
        $response['tipo'] = $tipoGuia['nombre'];
        $response['origen'] = $guia['rutas_origen'];
        if (!empty($cargamento)){
            foreach ($cargamento as $carga){
                $id = $carga['id'];
                $cantidad = is_numeric($carga['cantidad']) ? formatoMillares($carga['cantidad']) : $carga['cantidad'];
                $descripcion = $carga['descripcion'];
                $response['listarCarga'][] = array("id" => $id, "cantidad" => mb_strtoupper($cantidad), "descripcion" => mb_strtoupper($descripcion));
            }
        }else{
            $response['listarCarga'] = 'cargamento_vacio';
        }

        $response['vehiculo_tipo'] = $guia['vehiculos_tipo'];
        $response['vehiculo_placa_batea'] = $anular ? $this->showValue($guia['vehiculos_placa_batea'], $guia['estatus']) : $guia['vehiculos_placa_batea'];
        $response['vehiculo_placa_chuto'] = $guia['vehiculos_placa_chuto'];
        $response['vehiculo_marca'] = $guia['vehiculos_marca'];
        $response['vehiculo_color'] = $guia['vehiculos_color'];
        $response['vehiculo_capacidad'] =  is_numeric($guia['vehiculos_capacidad']) ? formatoMillares($guia['vehiculos_capacidad']) : $guia['vehiculos_capacidad'];
        $response['chofer'] = $anular ? $this->showValue($guia['choferes_nombre'], $guia['estatus']) : $guia['choferes_nombre'];
        $response['chofer_cedula'] = formatoMillares($guia['choferes_cedula']);
        $response['chofer_telefono'] = $anular ? $this->showValue($guia['choferes_telefono'], $guia['estatus']) : $guia['choferes_telefono'];
        $response['estatus'] = $guia['estatus'];
        $response['role'] = $this->USER_ROLE;
        $response['precinto_1'] = empty($guia['precinto']) ? 'precinto_vacio' : $guia['precinto'];
        $response['precinto_2'] = empty($guia['precinto_2']) ? 'precinto_vacio' : $guia['precinto_2'];
        $response['precinto_3'] = empty($guia['precinto_3']) ? 'precinto_vacio' : $guia['precinto_3'];
        $response['impreso'] = $guia['pdf_impreso'];

        return $response;
    }

    public function getCodigo($tipos_id, $id): array
    {
        $response = crearResponse(
            false,
            true,
            '',
            '',
            'success',
            false,
            false
        );

        $model = new GuiasTipo();
        $modelParametro = new Parametro();
        $modelGuia = new Guia();

        $getTipo = $model->find($tipos_id);
        $codigo = $getTipo['codigo'];
        $year = date("Y");

        if (empty($id)){
            //create

            $getParametro = $modelParametro->first('nombre', '=', 'guias_num_init');

            if ($getParametro){

                $numero = $getParametro['valor'];

            }else{
                $numero = 1;
            }

            $repetido = false;
            $sql = 'SELECT * FROM guias ORDER BY id DESC;';
            $getGuia = $modelGuia->sqlPersonalizado($sql);
            if ($getGuia){
                $explode = explode('-', $getGuia['codigo']);
                $ultimoNumero = intval($explode[1]);
            }else{
                $ultimoNumero = 0;
            }


            do{
                $codigoGuia = $codigo.'-'.cerosIzquierda($numero, numSizeCodigo()).'-'.$year;
                $sql = "SELECT * FROM guias WHERE codigo LIKE '%$numero%' AND band = 1 AND estatus = 1;";
                $existe = $modelGuia->sqlPersonalizado($sql);

                if ($existe){
                    $repetido = true;
                    if ($numero <= $ultimoNumero){
                        $numero = $ultimoNumero + 1;
                    }else{
                        $numero = $numero + 1;
                    }

                }else{
                    $repetido = false;
                }
            }while($repetido);

            $response['codigo'] = mb_strtoupper($codigoGuia);

        }else{
            //edit
            $guia = $modelGuia->find($id);
            $getCodigo = $guia['codigo'];
            $explode = explode('-', $getCodigo);
            $codigoGuia = $codigo.'-'.$explode[1].'-'.$explode[2];
            $response['codigo'] = mb_strtoupper($codigoGuia);
        }
        return $response;
    }

    public function edit($id): array
    {
        $model = new Guia();
        $modelCarga = new GuiasCarga();
        $guia = $model->find($id);
        $cargamento = $modelCarga->getList('guias_id', '=', $id);

        $response['id'] = $guia['id'];
        $response['tipo'] = $guia['guias_tipos_id'];
        $response['codigo'] = $guia['codigo'];
        $response['vehiculo'] = $guia['vehiculos_id'];
        $response['chofer'] = $guia['choferes_id'];
        $response['origen'] = $guia['territorios_origen'];
        $response['destino'] = $guia['territorios_destino'];
        $response['fecha'] = $guia['fecha'];
        $response['precinto'] = $guia['precinto'];
        $response['precinto_2'] = $guia['precinto_2'];
        $response['precinto_3'] = $guia['precinto_3'];
        foreach ($cargamento as $carga){
            $id = $carga['id'];
            $cantidad = $carga['cantidad'];
            $descripcion = $carga['descripcion'];
            $response['listarCarga'][] = array("id" => $id, "cantidad" => $cantidad, "descripcion" => $descripcion);
        }

        return $response;
    }

    public function update($id, $guias_tipos_id, $codigo, $vehiculos_id, $choferes_id, $territorios_origen, $territorios_destino, $fecha, $users_id, $precinto, $precinto_2, $precinto_3, $contador): array
    {
        $model = new Guia();
        $cambios = false;
        $cambiosOrigen = false;
        $cambiosDestino = false;
        $modelGuiasTipo = new GuiasTipo();
        $modelGuiasCarga = new GuiasCarga();
        $modelVehiculos = new Vehiculo();
        $modelChoferes = new Chofere();
        $modelRutasTerritorio = new Parroquia();

        $guia = $model->find($id);

        $tipoGuia = $modelGuiasTipo->find($guias_tipos_id);
        $tipoNombre = $tipoGuia['nombre'];

        $vehiculo = $modelVehiculos->find($vehiculos_id);
        $vehiculos_tipo_id = $vehiculo['tipo'];
        $vehiculo_marca = $vehiculo['marca'];
        $vehiculo_placa_batea = $vehiculo['placa_batea'];
        $vehiculo_placa_chuto = $vehiculo['placa_chuto'];
        $vehiculo_color = $vehiculo['color'];
        $vehiculo_capacidad = $vehiculo['capacidad'];
        $tipoVehiculo = $this->getTipoVehiculo($vehiculos_tipo_id);
        $vehiculo_tipo_nombre = $tipoVehiculo['nombre'];

        $chofer = $modelChoferes->find($choferes_id);
        $chofer_cedula = $chofer['cedula'];
        $chofer_nombre = $chofer['nombre'];
        $chofer_telefono = $chofer['telefono'];

        $ruta = $this->existeRuta($territorios_origen, $territorios_destino);

        if ($ruta){
            $rutas_id = $ruta['id'];
            $rutas_ruta = $ruta['ruta'];

            $origen = $modelRutasTerritorio->find($territorios_origen);
            $destino = $modelRutasTerritorio->find($territorios_destino);
            $rutas_origen = $origen['nombre'];
            $rutas_destino = $destino['nombre'];

            $pdf_id = $this->ID_FORMATO_GUIA;

            if ($pdf_id){
                $db_tipo = $guia['guias_tipos_id'];
                $db_codigo = $guia['codigo'];
                $db_vehiculo = $guia['vehiculos_id'];
                $db_chofer = $guia['choferes_id'];
                $db_origen = $guia['territorios_origen'];
                $db_destino = $guia['territorios_destino'];
                $db_ruta = $guia['rutas_id'];
                $db_fecha = $guia['fecha'];
                $db_precinto = $guia['precinto'];
                $db_precinto_2 = $guia['precinto_2'];
                $db_precinto_3 = $guia['precinto_3'];

                if ($db_tipo != $guias_tipos_id){
                    $cambios = true;
                    $model->update($id, 'guias_tipos_id', $guias_tipos_id);
                    $model->update($id, 'tipos_nombre', $tipoNombre);
                }

                if ($db_codigo != $codigo){
                    $cambios = true;
                    $model->update($id, 'codigo', $codigo);
                }

                if ($db_vehiculo != $vehiculos_id){
                    $cambios = true;
                    $model->update($id, 'vehiculos_id', $vehiculos_id);
                    $model->update($id, 'vehiculos_tipo', $vehiculo_tipo_nombre);
                    $model->update($id, 'vehiculos_marca', $vehiculo_marca);
                    $model->update($id, 'vehiculos_placa_batea', $vehiculo_placa_batea);
                    $model->update($id, 'vehiculos_placa_chuto', $vehiculo_placa_chuto);
                    $model->update($id, 'vehiculos_color', $vehiculo_color);
                    $model->update($id, 'vehiculos_capacidad', $vehiculo_capacidad);
                }

                if ($db_chofer != $choferes_id){
                    $cambios = true;
                    $model->update($id, 'choferes_id', $choferes_id);
                    $model->update($id, 'choferes_cedula', $chofer_cedula);
                    $model->update($id, 'choferes_nombre', $chofer_nombre);
                    $model->update($id, 'choferes_telefono', $chofer_telefono);
                }

                if ($db_origen != $territorios_origen){
                    $cambios = true;
                    $cambiosOrigen = true;
                    $model->update($id, 'territorios_origen', $territorios_origen);
                    $model->update($id, 'rutas_origen', $rutas_origen);
                }

                if ($db_destino != $territorios_destino){
                    $cambios = true;
                    $cambiosDestino = true;
                    $model->update($id, 'territorios_destino', $territorios_destino);
                    $model->update($id, 'rutas_destino', $rutas_destino);
                }

                if ($db_ruta != $rutas_id){
                    $cambios = true;
                    $model->update($id, 'rutas_id', $rutas_id);
                    $model->update($id, 'rutas_ruta', $rutas_ruta);
                }

                if ($cambiosOrigen && $cambiosDestino){
                    $cambios = true;
                    $model->update($id, 'rutas_ruta', $rutas_ruta);
                }

                if ($db_fecha != $fecha){
                    $cambios = true;
                    $model->update($id, 'fecha', $fecha);
                }

                if ($db_precinto != $precinto){
                    $cambios = true;
                    $model->update($id, 'precinto', $precinto);
                }

                if ($db_precinto_2 != $precinto_2){
                    $cambios = true;
                    $model->update($id, 'precinto_2', $precinto_2);
                }

                if ($db_precinto_3 != $precinto_3){
                    $cambios = true;
                    $model->update($id, 'precinto_3', $precinto_3);
                }


                $guiasCarga = $modelGuiasCarga->getList('guias_id', '=', $id);
                foreach ($guiasCarga as $carga) {
                    $modelGuiasCarga->delete($carga['id']);
                }
                for ($i = 1; $i <= $contador; $i++) {
                    if (isset($_POST['cantidad_' . $i])) {
                        $cantidad = $_POST['cantidad_' . $i];
                        $descripcion = $_POST['descripcion_' . $i];

                        $dataCarga = [
                            $id,
                            $cantidad,
                            $descripcion
                        ];

                        $modelGuiasCarga->save($dataCarga);
                        $cambios = true;
                    }

                }


                if ($cambios){
                    $model->update($id, 'users_id', $users_id);
                    //me treigo los datos de la guia
                    $guia = $this->showGuia($id);
                    // modifico el title
                    $response['title'] = 'Editado Exitosamente';
                    $response = array_merge($response, $guia);
                }else{
                    $response = crearResponse('no_cambios');
                }

            }else{
                $response = crearResponse(
                    'no_formato',
                    false,
                    'Formato NO válido',
                    'NO SE HA DEFINIDO NINGÚN FORMATO DE GUIA EN LA BASE DE DATOS, CONTACTE CON SU ADMINISTRADOR.',
                    'warning',
                    true,
                    true
                );
            }
        }else{
            $response = crearResponse(
                'no_ruta',
                false,
                'Ruta NO válida',
                'NO EXISTE LA RUTA, DEBE CREARLA.',
                'warning',
                true,
                true
            );
        }
        return $response;
    }

    public function destroy($id, $opt): array
    {
        $model = new Guia();
        if ($opt == 'anular'){
            $model->update($id, 'estatus', 0);
            $model->update($id, 'updated_at', date("Y-m-d"));
            $title = 'Guia Anulada';
        }else{
            $model->update($id, 'band', 0);
            $model->update($id, 'deleted_at', date("Y-m-d"));
            $title = 'Guia Eliminada';
        }

        $guia = $this->showGuia($id, true);
        $response['title'] = $title;
        $response['opt'] = $opt;
        $response['total'] = $this->totalRows;
        $response['role'] = $this->USER_ROLE;
        return array_merge($guia, $response);
    }

    public function existeRuta($origen, $destino){
        $model = new Ruta();
        $sql = "SELECT * FROM rutas WHERE `origen` = '$origen' AND `destino` = '$destino' AND `band` = '1' AND `version` = '1';";
        $ruta = $model->sqlPersonalizado($sql);
        if ($ruta){
            return $ruta;
        }else{
            $sql = "SELECT * FROM rutas WHERE `origen` = '$destino' AND `destino` = '$origen' AND `band` = '1' AND `version` = '1';";
            $ruta = $model->sqlPersonalizado($sql);
            if ($ruta){
                $ruta['ruta'] = array_reverse(json_decode($ruta['ruta']));
                $ruta['ruta'] = json_encode($ruta['ruta']);
                return $ruta;
            }
        }

    }

    public function showValue($valor, $estatus, $codigo = false): string
    {
        $html = null;

        if ($estatus){
            $html = $valor;
        }else{
            $html = '<span class="font-italic text-gray">'.$valor.'</span>';
            if ($codigo){
                $html .= '&ensp;<i class="fas fa-backspace text-danger"></i>';
            }
        }
        return $html;
    }

}