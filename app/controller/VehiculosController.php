<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Chofere;
use app\model\Empresa;
use app\model\Guia;
use app\model\Vehiculo;
use app\model\VehiculoTipo;

class VehiculosController extends Admin
{
    public $rows;
    public $totalRows;
    public $links;
    public $limit;
    public $offset;
    public $keyword;

    public function index(
        $baseURL = '_request/VehiculosRequest.php',
        $tableID = 'table_vehiculos',
        $limit = null,
        $totalRows = null,
        $offset = null,
        $opcion = 'paginate',
        $contentDiv = 'div_vehiculos'
    )
    {

        $model = new Vehiculo();
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

    public function getTipo($id = null)
    {
        $model = new VehiculoTipo();

        if ($id) {
            return $model->first('id', '=', $id);
        }

        return $model->getAll();
    }

    public function get_datos_vehiculo($id)
    {
        $model = new Vehiculo();
        $modelEmpresa = new Empresa();
        $vehiculos = $model->find($id);
        $empresas = $modelEmpresa->find($vehiculos['empresas_id']);
        $tipo = $this->getTipo($vehiculos['tipo']);

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

    public function getTipos()
    {
        $model = new VehiculoTipo();
        return $model->getAll();
    }

    public function store($empresas_id, $placa_batea, $placa_chuto, $tipo, $marca, $color, $capacidad)
    {
        $model = new Vehiculo();
        $existeBatea = $model->existe('placa_batea', '=', $placa_batea, null, 1);
        $existeChuto = $model->existe('placa_chuto', '=', $placa_chuto, null, 1);

        if (!$existeBatea || !$existeChuto){
           $data = [
               $empresas_id,
               $tipo,
               $marca,
               $placa_batea,
               $placa_chuto,
               $color,
               $capacidad,
               date("Y-m-d")
           ];

           $model->save($data);
            $response = crearResponse(
                false,
                true,
                'Guardado Exitosamente',
                'Se Guardo Exitosamente'
            );
            $response['total'] = $model->count();

        }else{
            $response = crearResponse(
                'existe_vehiculo',
                false,
                'Vehiculo ya registrado.',
                'El vehiculo ya esta registrado.',
                'warning'
            );
        }

        return $response;
    }

    public function edit($id)
    {
        $model = new Vehiculo();
        $vehiculos = $model->find($id);
        $response = crearResponse(
            false,
            true,
            'Editar Vehiculo',
            'Editar Vehiculo',
            'success',
            false,
            true
        );
        $response['empresas_id'] = $vehiculos['empresas_id'];
        $response['placa_batea'] = $vehiculos['placa_batea'];
        $response['placa_chuto'] = $vehiculos['placa_chuto'];
        $response['tipo'] = $vehiculos['tipo'];
        $response['marca'] = $vehiculos['marca'];
        $response['color'] = $vehiculos['color'];
        $response['capacidad'] = $vehiculos['capacidad'];
        $response['id'] = $vehiculos['id'];

        return $response;
    }

    public function update($empresas_id, $placa_batea, $placa_chuto, $tipo, $marca, $color, $capacidad, $id)
    {
        $model = new Vehiculo();
        $cambios = false;
        $vehiculos = $model->find($id);

        $db_empresas_id = $vehiculos['empresas_id'];
        $db_placa_batea = $vehiculos['placa_batea'];
        $db_placa_chuto = $vehiculos['placa_chuto'];
        $db_tipo = $vehiculos['tipo'];
        $db_marca = $vehiculos['marca'];
        $db_color = $vehiculos['color'];
        $db_capacidad = $vehiculos['capacidad'];

        $existeBatea = $model->existe('placa_batea', '=', $placa_batea, $id, 1);
        $existeChuto = $model->existe('placa_chuto', '=', $placa_chuto, $id, 1);

        if (!$existeBatea || !$existeChuto){
            if ($db_empresas_id != $empresas_id){
                $cambios = true;
                $model->update($id, 'empresas_id', $empresas_id);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_placa_batea != $placa_batea){
                $cambios = true;
                $model->update($id, 'placa_batea', $placa_batea);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_placa_chuto != $placa_chuto){
                $cambios = true;
                $model->update($id, 'placa_chuto', $placa_chuto);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_tipo != $tipo){
                $cambios = true;
                $model->update($id, 'tipo', $tipo);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_marca != $marca){
                $cambios = true;
                $model->update($id, 'marca', $marca);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_color != $color){
                $cambios = true;
                $model->update($id, 'color', $color);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($db_capacidad != $capacidad){
                $cambios = true;
                $model->update($id, 'capacidad', $capacidad);
                $model->update($id, 'updated_at', date("Y-m-d"));
            }

            if ($cambios){
                $response = crearResponse(
                    null,
                    true,
                    'Editado Exitosamente.',
                    'El Vehiculo se ha Editado Exitosamente.'
                );
                $vehiculos = $model->find($id);
                $tipo = $this->getTipo($vehiculos['tipo']);
                $response['empresas_id'] = $vehiculos['empresas_id'];
                $response['placa_batea'] = mb_strtoupper($vehiculos['placa_batea']);
                $response['placa_chuto'] = mb_strtoupper($vehiculos['placa_chuto']);
                $response['tipo'] = mb_strtoupper($tipo['nombre']);
                $response['marca'] = mb_strtoupper($vehiculos['marca']);
                $response['color'] = mb_strtoupper($vehiculos['color']);
                $response['capacidad'] = $vehiculos['capacidad'];
                $response['id'] = $vehiculos['id'];

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

    public function destroy($id)
    {
        $model = new Vehiculo();
        $modelGuias = new Guia();
        $modelChoferes = new Chofere();
        $vehiculo = $model->find($id);
        $vinculado = false;

        $guias = $modelGuias->first('vehiculos_id', '=', $id);
        $choferes = $modelChoferes->first('vehiculos_id', '=', $id);

        if ($guias || $choferes){
            $vinculado = true;
        }

        if ($vinculado){
            $response = crearResponse('vinculado');
        }else{
            if ($vehiculo){
                $model->update($id, 'band', 0);
                $model->update($id, 'updated_at', date("Y-m-d"));
                $response = crearResponse(
                    null,
                    true,
                    'Vehiculo Eliminado.',
                    'Vehiculo Eliminado.'
                );
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

    public function search($keyword)
    {
        $model = new Vehiculo();
        $this->totalRows = $model->count(1);
        $sql = "SELECT * FROM vehiculos WHERE (placa_batea LIKE '%$keyword%' OR marca LIKE '%$keyword%' OR capacidad LIKE '%$keyword%') AND band = 1;";
        $this->rows = $model->sqlPersonalizado($sql, 'getAll');
        $this->keyword = $keyword;
    }

}