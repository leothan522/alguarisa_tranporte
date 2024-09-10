<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Chofer;
use app\model\Empresa;
use app\model\Guia;
use app\model\Vehiculo;
use app\model\VehiculoTipo;


class ChoferesController extends Admin
{
    public $rows;
    public $totalRows;
    public $links;
    public $limit;
    public $offset;
    public $keyword;

    public function index(
        $baseURL = '_request/ChoferesRequest.php',
        $tableID = 'table_choferes',
        $limit = null,
        $totalRows = null,
        $offset = null,
        $opcion = 'paginate',
        $contentDiv = 'div_choferes'
    ): void
    {

        $model = new Chofer();
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

    public function store($empresas, $vehiculos, $cedula, $nombre, $telefono): array
    {
        $model = new Chofer();
        $existeChofer = $model->existe('cedula', '=', $cedula);

        if (!$existeChofer) {
            $data = [
                $empresas,
                $vehiculos,
                $cedula,
                $nombre,
                $telefono,
                getFecha(),
                getRowquid($model)
            ];

            $model->save($data);
            $response = crearResponse(
                false,
                true,
                'Guardado Exitosamente',
                'Se Guardo Exitosamente'
            );
            $response['total'] = $model->count();

        } else {
            $response = crearResponse(
                'existe_chofer',
                false,
                'Chofer ya registrado.',
                'El chofer ya esta registrado.',
                'warning'
            );
        }

        return $response;

    }

    public function vehiculos($id)
    {
        $model = new Vehiculo();
        return $model->first('id', '=', $id);
    }

    public function getTipo($id)
    {
        $model = new VehiculoTipo();
        return $model->first('id', '=', $id);
    }

    public function getVehiculos(): array
    {
        $model = new Vehiculo();
        return $model->getAll(1);
    }

    public function edit($id): array
    {
        $model = new Chofer();
        $chofer = $model->find($id);
        $response = crearResponse(
            false,
            true,
            'Editar Chofer',
            'Editar Chofer',
            'success',
            false,
            true
        );
        $response['empresas_id'] = $chofer['empresas_id'];
        $response['vehiculos_id'] = $chofer['vehiculos_id'];
        $response['cedula'] = formatoMillares($chofer['cedula']);
        $response['nombre'] = $chofer['nombre'];
        $response['telefono'] = $chofer['telefono'];
        $response['id'] = $chofer['id'];

        return $response;
    }

    public function update($empresas, $vehiculos, $cedula, $nombre, $telefono, $id): array
    {
        $model = new Chofer();
        $modelVehiculo = new Vehiculo();
        $cambios = false;
        $choferes = $model->find($id);

        $db_empresa = $choferes['empresas_id'];
        $db_vehiculo = $choferes['vehiculos_id'];
        $db_cedula = $choferes['cedula'];
        $db_nombre = $choferes['nombre'];
        $db_telefono = $choferes['telefono'];

        $existe = $model->existe('cedula', '=', $cedula, $id, 1);

        if (!$existe){
            if ($db_empresa != $empresas) {
                $cambios = true;
                $model->update($id, 'empresas_id', $empresas);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_vehiculo != $vehiculos) {
                $cambios = true;
                $model->update($id, 'vehiculos_id', $vehiculos);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_cedula != $cedula) {
                $cambios = true;
                $model->update($id, 'cedula', $cedula);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_nombre != $nombre) {
                $cambios = true;
                $model->update($id, 'nombre', $nombre);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_telefono != $telefono) {
                $cambios = true;
                $model->update($id, 'telefono', $telefono);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($cambios){
                $response = crearResponse(
                    null,
                    true,
                    'Editado Exitosamente.',
                    'El jefe se ha guardado Exitosamente.'
                );
                $choferes = $model->find($id);
                $vehiculo = $modelVehiculo->find($choferes['vehiculos_id']);
                $response['empresas_id'] = $choferes['empresas_id'];
                $response['vehiculos_id'] = $choferes['vehiculos_id'];
                $response['cedula'] = formatoMillares($choferes['cedula'], 0);
                $response['nombre'] = mb_strtoupper($choferes['nombre']);
                $response['telefono'] = $choferes['telefono'];
                $response['placa'] = mb_strtoupper($vehiculo['placa_batea']);
                $response['id'] = $choferes['id'];


            }else{
                $response = crearResponse(
                    'sin_cambios',
                    false,
                    'Sin cambios',
                    'no se realizó ningun cambio',
                    'info',
                    true
                );
            }

        }else{
            $response = crearResponse(
                'datos_duplicados',
                false,
                'Datos Duplicados',
                'Datos Duplicados',
                'warning'
            );
        }
        return $response;
    }

    function delete($id): array
    {
        $model = new Chofer();
        $modelGuias = new Guia();

        $chofer = $model->find($id);
        $vinculado = false;

        $guias = $modelGuias->first('choferes_id', '=', $id);
        if ($guias){
            $vinculado = true;
        }

        if ($vinculado){
            $response = crearResponse('vinculado');
        }else{
            if ($chofer){
                $model->update($id, 'band', 0);
                $model->update($id, 'updated_at', date("Y-m-d"));
                $response = crearResponse(
                    null,
                    true,
                    'Chofer Eliminado.',
                    'Chofer Eliminado.'
                );
                //datos extras para el $response
                $response['total'] = $model->count(1);
            }else{
                $response = crearResponse(
                    'no_chofer',
                    false,
                    'Chofer NO encontrado."',
                    'El id del Chofer no esta disponible.',
                    'warning',
                    true
                );
            }
        }


        return $response;
    }

    public function search($keyword): void
    {
        $model = new Chofer();
        $this->totalRows = $model->count(1);
        $sql_count = "choferes WHERE (cedula LIKE '%$keyword%' OR nombre LIKE '%$keyword%' OR telefono LIKE '%$keyword%') AND band = 1;";
        $sql = "SELECT * FROM choferes WHERE (cedula LIKE '%$keyword%' OR nombre LIKE '%$keyword%' OR telefono LIKE '%$keyword%') AND band = 1;";
        $this->rows = $model->sqlPersonalizado($sql, 'getAll');
        $this->keyword = $keyword;
        $this->totalRows = $model->sqlPersonalizado($sql_count, 'count');

        //$this->links = 'Resultados Encontrados: <span class="text-bold text-danger">'. $this->totalRows.'</span>';

    }

}