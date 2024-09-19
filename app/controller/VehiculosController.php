<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Chofer;
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
    ): void
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

    public function getTipos(): array
    {
        $model = new VehiculoTipo();
        return $model->getAll();
    }

    public function store($empresas_id, $placa_batea, $placa_chuto, $tipo, $marca, $color, $capacidad): array
    {
        $model = new Vehiculo();
        $modelEmpresa = new Empresa();
        $modelTipos = new VehiculoTipo();
        $empresas = $modelEmpresa->first('rowquid', '=', $empresas_id);
        $tipos = $modelTipos->first('rowquid', '=', $tipo);
        $empresas_id = $empresas['id'];
        $tipo_id = $tipos['id'];
        $existeBatea = $model->existe('placa_batea', '=', $placa_batea, null, 1);
        $existeChuto = $model->existe('placa_chuto', '=', $placa_chuto, null, 1);

        if (!$existeBatea || !$existeChuto) {
            $data = [
                $empresas_id,
                $tipo_id,
                $marca,
                $placa_batea,
                $placa_chuto,
                $color,
                $capacidad,
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
                'existe_vehiculo',
                false,
                'Vehiculo ya registrado.',
                'El vehiculo ya esta registrado.',
                'warning'
            );
        }

        return $response;
    }

    public function edit($rowquid): array
    {
        $modelEmpresas = new Empresa();
        $modelTipo = new VehiculoTipo();
        $vehiculos = $this->getVehiculos($rowquid);
        $empresas = $modelEmpresas->first('id', '=', $vehiculos['empresas_id']);
        $tipos = $modelTipo->first('id', '=', $vehiculos['tipo']);


        if ($vehiculos) {
            $response = crearResponse(
                false,
                true,
                'Editar Vehiculo',
                'Editar Vehiculo',
                'success',
                false,
                true
            );
            $response['empresas_id'] = $empresas['rowquid'];
            $response['placa_batea'] = $vehiculos['placa_batea'];
            $response['placa_chuto'] = $vehiculos['placa_chuto'];
            $response['tipo'] = $tipos['rowquid'];
            $response['marca'] = $vehiculos['marca'];
            $response['color'] = $vehiculos['color'];
            $response['capacidad'] = $vehiculos['capacidad'];
            $response['id'] = $vehiculos['rowquid'];
        } else {
            $response = crearResponse('no_found');
        }
        return $response;
    }

    public function update($empresas_id, $placa_batea, $placa_chuto, $tipo, $marca, $color, $capacidad, $rowquid): array
    {
        $model = new Vehiculo();
        $modelEmpresa = new Empresa();
        $modeltipos = new VehiculoTipo();
        $cambios = false;
        $vehiculos = $this->getVehiculos($rowquid);
        $empresas = $modelEmpresa->first('rowquid', '=', $empresas_id);
        $tipos = $modeltipos->first('rowquid', '=', $tipo);

        if ($vehiculos) {
            $id = $vehiculos['id'];
            $empresas_id = $empresas['id'];
            $tipos_id = $tipos['id'];
            $db_empresas_id = $vehiculos['empresas_id'];
            $db_placa_batea = $vehiculos['placa_batea'];
            $db_placa_chuto = $vehiculos['placa_chuto'];
            $db_tipo = $vehiculos['tipo'];
            $db_marca = $vehiculos['marca'];
            $db_color = $vehiculos['color'];
            $db_capacidad = $vehiculos['capacidad'];

            $existeBatea = $model->existe('placa_batea', '=', $placa_batea, $id, 1);
            $existeChuto = $model->existe('placa_chuto', '=', $placa_chuto, $id, 1);

            if (!$existeBatea || !$existeChuto) {
                if ($db_empresas_id != $empresas_id) {
                    $cambios = true;
                    $model->update($id, 'empresas_id', $empresas_id);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($db_placa_batea != $placa_batea) {
                    $cambios = true;
                    $model->update($id, 'placa_batea', $placa_batea);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($db_placa_chuto != $placa_chuto) {
                    $cambios = true;
                    $model->update($id, 'placa_chuto', $placa_chuto);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($db_tipo != $tipos_id) {
                    $cambios = true;
                    $model->update($id, 'tipo', $tipos_id);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($db_marca != $marca) {
                    $cambios = true;
                    $model->update($id, 'marca', $marca);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($db_color != $color) {
                    $cambios = true;
                    $model->update($id, 'color', $color);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($db_capacidad != $capacidad) {
                    $cambios = true;
                    $model->update($id, 'capacidad', $capacidad);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($cambios) {
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
                    $response['id'] = $vehiculos['rowquid'];

                } else {
                    $response = crearResponse(
                        'sin_cambios',
                        false,
                        'Sin cambios',
                        'no se realizó ningun cambio',
                        'info',
                        true
                    );
                }

            } else {
                $response = crearResponse(
                    'datos_duplicados',
                    false,
                    'Datos Duplicados',
                    'Datos Duplicados',
                    'warning'
                );
            }
        } else {
            $response = crearResponse('no_found');
        }

        return $response;
    }

    public function destroy($rowquid): array
    {
        $model = new Vehiculo();
        $modelGuias = new Guia();
        $modelChoferes = new Chofer();
        $vehiculo = $this->getVehiculos($rowquid);
        $vinculado = false;

        if ($vehiculo){
            $id = $vehiculo['id'];
            $guias = $modelGuias->first('vehiculos_id', '=', $id);
            $choferes = $modelChoferes->first('vehiculos_id', '=', $id);

            if ($guias || $choferes) {
                $vinculado = true;
            }

            if ($vinculado) {
                $response = crearResponse('vinculado');
            } else {

                $model->update($id, 'band', 0);
                $model->update($id, 'updated_at', date("Y-m-d"));
                $response = crearResponse(
                    null,
                    true,
                    'Vehiculo Eliminado.',
                    'Vehiculo Eliminado.'
                );
                $response['total'] = $model->count(1);

            }
        }else{
            $response = crearResponse('no_found');
        }
        return $response;
    }

    public function search($keyword): void
    {
        $model = new Vehiculo();
        $this->totalRows = $model->count(1);
        $sql = "SELECT * FROM vehiculos WHERE (placa_batea LIKE '%$keyword%' OR marca LIKE '%$keyword%' OR capacidad LIKE '%$keyword%') AND band = 1;";
        $sql_count = "vehiculos WHERE (placa_batea LIKE '%$keyword%' OR marca LIKE '%$keyword%' OR capacidad LIKE '%$keyword%') AND band = 1;";
        $this->rows = $model->sqlPersonalizado($sql, 'getAll');
        $this->keyword = $keyword;
        $this->totalRows = $model->sqlPersonalizado($sql_count, 'count');
    }

    protected function getVehiculos($rowquid)
    {
        $response = null;
        $model = new Vehiculo();
        $vehiculo = $model->first('rowquid', '=', $rowquid);
        if ($vehiculo) {
            $response = $vehiculo;
        }
        return $response;
    }

}