<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Chofer;
use app\model\Empresa;
use app\model\Vehiculo;

class EmpresasController extends Admin
{
    public $rows;
    public $totalRows;
    public $links;
    public $limit;
    public $offset;
    public $keyword;

    public function index(
        $baseURL = '_request/EmpresasRequest.php',
        $tableID = 'table_empresas',
        $limit = null,
        $totalRows = null,
        $offset = null,
        $opcion = 'paginate',
        $contentDiv = 'div_empresas'
    ): void
    {

        $model = new Empresa();
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

    public function store($rif, $nombre, $responsable, $telefono): array
    {
        $model = new Empresa();
        $existeEmpresa = $model->existe('rif', '=', $rif, null, 1);

        if (!$existeEmpresa) {
            $data = [
                $rif,
                $nombre,
                $responsable,
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
                'existe_empresa',
                false,
                'Empresa ya registrada.',
                'Rif ya registrado.',
                'warning'
            );
        }

        return $response;
    }

    public function edit($rowquid): array
    {
        $empresa = $this->getEmpresas($rowquid);
        if ($empresa) {

            $response = crearResponse(
                false,
                true,
                'Editar Empresa',
                'Editar Empresa',
                'success',
                false,
                true
            );
            $response['rif'] = $empresa['rif'];
            $response['nombre'] = $empresa['nombre'];
            $response['responsable'] = $empresa['responsable'];
            $response['telefono'] = $empresa['telefono'];
            $response['id'] = $empresa['rowquid'];

        } else {
            $response = crearResponse('no_found');
        }

        return $response;
    }

    public function update($rif, $nombre, $responsable, $telefono, $rowquid): array
    {
        $model = new Empresa();
        $empresa = $this->getEmpresas($rowquid);
        $cambios = false;

        if ($empresa) {
            $id = $empresa['id'];
            $db_rif = $empresa['rif'];
            $db_nombre = $empresa['nombre'];
            $db_responsable = $empresa['responsable'];
            $db_telefono = $empresa['telefono'];

            $existe = $model->existe('rif', '=', $rif, $id, 1);

            if (!$existe) {

                if ($db_rif != $rif) {
                    $cambios = true;
                    $model->update($id, 'rif', $rif);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($db_nombre != $nombre) {
                    $cambios = true;
                    $model->update($id, 'nombre', $nombre);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($db_responsable != $responsable) {
                    $cambios = true;
                    $model->update($id, 'responsable', $responsable);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($db_telefono != $telefono) {
                    $cambios = true;
                    $model->update($id, 'telefono', $telefono);
                    $model->update($id, 'updated_at', date("Y-m-d"));
                }

                if ($cambios) {
                    $response = crearResponse(
                        null,
                        true,
                        'Editado Exitosamente.',
                        'La empresa se ha editado Exitosamente.'
                    );
                    $empresa = $model->find($id);
                    $response['rif'] = $empresa['rif'];
                    $response['nombre'] = $empresa['nombre'];
                    $response['responsable'] = '<small>' . $empresa['responsable'] . '<br>' . $empresa['telefono'] . '</small>';
                    $response['telefono'] = $empresa['telefono'];
                    $response['id'] = $empresa['rowquid'];

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
                    'Rif ya registrado.',
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
        $model = new Empresa();
        $modelVehiculo = new Vehiculo();
        $modelChoferes = new Chofer();
        $vinculado = false;

        $empresa = $this->getEmpresas($rowquid);

        if ($empresa) {
            $id = $empresa['id'];
            $choferes = $modelChoferes->first('empresas_id', '=', $id);
            $vehiculos = $modelVehiculo->first('empresas_id', '=', $id);

            if ($choferes || $vehiculos) {
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
                    'Empresa Eliminada.',
                    'Empresa Eliminada.'
                );
                //datos extras para el $response
                $response['total'] = $model->count(1);

            }
        } else {
            $response = crearResponse('no_found');
        }


        return $response;
    }

    public function search($keyword): void
    {
        $model = new Empresa();
        $this->totalRows = $model->count(1);
        $sql = "SELECT * FROM empresas WHERE (rif LIKE '%$keyword%' OR nombre LIKE '%$keyword%' OR responsable LIKE '%$keyword%' OR telefono LIKE '%$keyword%') AND band = 1;";
        $sql_count = "empresas WHERE (rif LIKE '%$keyword%' OR nombre LIKE '%$keyword%' OR responsable LIKE '%$keyword%' OR telefono LIKE '%$keyword%') AND band = 1;";
        $this->rows = $model->sqlPersonalizado($sql, 'getAll');
        $this->keyword = $keyword;
        $this->totalRows = $model->sqlPersonalizado($sql_count, 'count');
    }

    protected function getEmpresas($rowquid)
    {
        $response = null;
        $model = new Empresa();
        $empresa = $model->first('rowquid', '=', $rowquid);
        if ($empresa) {
            $response = $empresa;
        }
        return $response;
    }
}