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

        if (!$existeEmpresa){
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
        }else{
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

    public function edit($id): array
    {
        $model = new Empresa();
        $empresa = $model->find($id);
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
        $response['id'] = $empresa['id'];

        return $response;
    }

    public function update($rif, $nombre, $responsable, $telefono, $id): array
    {
        $model = new Empresa();
        $empresa = $model->find($id);
        $cambios = false;

        $db_rif = $empresa['rif'];
        $db_nombre = $empresa['nombre'];
        $db_responsable = $empresa['responsable'];
        $db_telefono = $empresa['telefono'];

        $existe = $model->existe('rif', '=', $rif, $id, 1);

        if (!$existe){

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

            if ($cambios){
                $response = crearResponse(
                    null,
                    true,
                    'Editado Exitosamente.',
                    'La empresa se ha editado Exitosamente.'
                );
                $empresa = $model->find($id);
                $response['rif'] = $empresa['rif'];
                $response['nombre'] = $empresa['nombre'];
                $response['responsable'] = '<small>'.$empresa['responsable'].'<br>'.$empresa['telefono'].'</small>';
                $response['telefono'] = $empresa['telefono'];
                $response['id'] = $empresa['id'];

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
                'Rif ya registrado.',
                'warning'
            );
        }
        return $response;

    }

    public function destroy($id): array
    {
        $model = new Empresa();
        $modelVehiculo = new Vehiculo();
        $modelChoferes = new Chofer();

        $empresa = $model->find($id);
        $vinculado = false;

        $choferes = $modelChoferes->first('empresas_id', '=', $id);
        $vehiculos = $modelVehiculo->first('empresas_id', '=', $id);

        if ($choferes || $vehiculos){
            $vinculado = true;
        }

        if ($vinculado){
            $response = crearResponse('vinculado');
        }else{
            if ($empresa){
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
            }else{
                $response = crearResponse(
                    'no_empresa',
                    false,
                    'Empresa NO encontrada."',
                    'El id de la Empresa no esta disponible.',
                    'warning',
                    true
                );
            }
        }
        return $response;
    }

    public function search($keyword): void
    {
        $model = new Empresa();
        $this->totalRows = $model->count(1);
        $sql = "SELECT * FROM empresas WHERE (rif LIKE '%$keyword%' OR nombre LIKE '%$keyword%' OR responsable LIKE '%$keyword%' OR telefono LIKE '%$keyword%') AND band = 1;";
        $this->rows = $model->sqlPersonalizado($sql, 'getAll');
        $this->keyword = $keyword;
    }

}