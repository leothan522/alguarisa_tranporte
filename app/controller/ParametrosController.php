<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Cargo;
use app\model\Caso;
use app\model\Chofer;
use app\model\Empresa;
use app\model\Firmante;
use app\model\Guia;
use app\model\GuiasCarga;
use app\model\GuiasTipo;
use app\model\Institucion;
use app\model\Municipio;
use app\model\Nomina;
use app\model\NominaCargo;
use app\model\NominaUbicacion;
use app\model\Oficio;
use app\model\Parametro;
use app\model\Parroquia;
use app\model\Persona;
use app\model\Producto;
use app\model\Ruta;
use app\model\RutasTerritorio;
use app\model\User;
use app\model\Vehiculo;
use app\model\VehiculoTipo;

class ParametrosController extends Admin
{
    public $TITTLE = "Parametros";
    public $MODULO = "parametros.index";

    public $links;
    public $totalRows;
    public $limit;
    public $rows;
    public $offset;
    public $keyword;

    public function isAdmin()
    {
        parent::isAdmin(); // TODO: Change the autogenerated stub
        if ($this->USER_ROLE != 100){
            header('location: '. ROOT_PATH.'admin\\');
        }
    }


    public function index(
        $baseURL = '_request/ParametrosRequest.php',
        $tableID = 'table_parametros',
        $limit = null,
        $totalRows = null,
        $offset = null,
        $opcion = 'paginate',
        $contentDiv = 'dataContainerParametros'
    ){

        $model = new Parametro();
        if (is_null($limit)) { $this->limit = numRowsPaginate(); }else{ $this->limit = $limit; }
        if (is_null($totalRows)) { $this->totalRows = $model->count(); }else{ $this->totalRows = $totalRows; }
        if (is_null($offset)) { $this->offset = 0; }else{ $this->offset = $offset; }

        $this->links = paginate(
            $baseURL,
            $tableID,
            $this->limit,
            $this->totalRows,
            $offset,
            $opcion,
            $contentDiv
        )->createLinks();
        $this->rows = $model->paginate($this->limit,$offset, 'id','DESC');
    }

    public function store($name, $tabla_id, $valor)
    {
        $model = new Parametro();
        if (empty($tabla_id) && $tabla_id != 0) {
            $tabla_id = null;
        }


        $data = [
            $name,
            $tabla_id,
            $valor,
            getRowquid($model)
        ];

        $model->save($data);
    }

    public function edit($id)
    {
        $model = new Parametro();
        $row = $model->find($id);

        $response = crearResponse(
            null,
            true,
            'Editar Parametro.',
            'Editar Parametro.',
            'info'
        );

        //datos extras para el $response
        $response['id'] = $row['id'];
        $response['nombre'] = $row['nombre'];
        $response['tabla_id'] = $row['tabla_id'];
        $response['valor'] = $row['valor'];
        return $response;
    }

    public function update($id, $name, $tabla_id, $valor)
    {
        $model = new Parametro();

        if (empty($tabla_id)) {
            $tabla_id = null;
        }

        $parametro = $model->find($id);
        $db_nombre = $parametro['nombre'];
        $db_tabla_id = $parametro['tabla_id'];
        $db_valor = $parametro['valor'];

        $cambios = false;

        if ($db_nombre != $name) {
            $cambios = true;
            $model->update($id, "nombre", $name);
        }

        if ($db_tabla_id != $tabla_id) {
            $cambios = true;
            $model->update($id, "tabla_id", $tabla_id);
        }

        if ($db_valor != $valor) {
            $cambios = true;
            $model->update($id, 'valor', $valor);
        }

        if ($cambios) {

            $response = crearResponse(
                null,
                true,
                'Parametro Actualizado.',
                'Parametro Actualizado.'
            );

            //datos extras para el $response
            $response['id'] = $id;
            $response['nombre'] = $name;
            $response['tabla_id'] = $tabla_id;
            $response['valor'] = $valor;

        } else {
            $response = crearResponse('no_cambios');
        }

        return $response;

    }

    public function delete($id)
    {
        $model = new Parametro();
        $model->delete($id);
        $response = crearResponse(
            null,
            true,
            'Parametro Borrado.',
            'Parametro Borrado.'
        );
        //datos extras para el $response
        $response['total'] = $model->count();
        return $response;
    }

    public function search($keyword){
        $model = new Parametro();
        $this->totalRows = $model->count(null, 'nombre', 'LIKE', "%$keyword%");
        $this->rows = $model->getList('nombre', 'LIKE', "%$keyword%");
        $this->keyword = $keyword;
    }

    public function setRowquid(): array
    {
        $response = crearResponse(
            null,
            true,
            'Tablas Actualizadas.',
            'La columna Rowquid ha sido actualizada correctamente en todas las tablas.',
            'success',
            true
        );

        $users = new User();
        $this->setColumnTable($users);

        $cargos = new Cargo();
        $this->setColumnTable($cargos);

        $casos = new Caso();
        $this->setColumnTable($casos);

        $choferes = new Chofer();
        $this->setColumnTable($choferes);

        $empresas = new Empresa();
        $this->setColumnTable($empresas);

        $firmantes = new Firmante();
        $this->setColumnTable($firmantes);

        $guias = new Guia();
        $this->setColumnTable($guias);

        $cargar = new GuiasCarga();
        $this->setColumnTable($cargar);

        $tiposGuia = new GuiasTipo();
        $this->setColumnTable($tiposGuia);

        $instituciones = new Institucion();
        $this->setColumnTable($instituciones);

        $municipios = new Municipio();
        $this->setColumnTable($municipios);

        $nomina = new Nomina();
        $this->setColumnTable($nomina);

        $cargos = new NominaCargo();
        $this->setColumnTable($cargos);

        $ubicaciones = new NominaUbicacion();
        $this->setColumnTable($ubicaciones);

        $oficios = new Oficio();
        $this->setColumnTable($oficios);

        $parametros = new Parametro();
        $this->setColumnTable($parametros);

        $parroquias = new Parroquia();
        $this->setColumnTable($parroquias);

        $personas = new Persona();
        $this->setColumnTable($personas);

        $productos = new Producto();
        $this->setColumnTable($productos);

        $rutas = new Ruta();
        $this->setColumnTable($rutas);

        $territorios = new RutasTerritorio();
        $this->setColumnTable($territorios);

        $vehiculos = new Vehiculo();
        $this->setColumnTable($vehiculos);

        $vehiculosTipo = new VehiculoTipo();
        $this->setColumnTable($vehiculosTipo);

        return $response;
    }


    public function setColumnTable($model): void
    {
        $rows = $model->getAll();
        foreach ($rows as $row){
            $id = $row['id'];
            if (empty($row['rowquid'])){
                $model->update($id, 'rowquid', generar_string_aleatorio(16));
            }
        }
    }

}