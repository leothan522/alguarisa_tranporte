<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Choferes;
use app\model\Empresa;
use app\model\Vehiculos;
use app\model\VehiculoTipo;


class ChoferesController extends Admin
{
    public $rows;
    public $totalRows;
    public $links;
    public $limit;
    public $offset;

    public function index(
        $baseURL = '_request/ChoferesRequest.php',
        $tableID = 'table_choferes',
        $limit = null,
        $totalRows = null,
        $offset = null,
        $opcion = 'paginate',
        $contentDiv = 'card_table_choferes'
    ){

        $model = new Choferes();
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

        $this->rows = $model->paginate($this->limit,$offset, 'id','DESC', 1);
    }

    public function store($empresas, $vehiculos, $cedula, $nombre, $telefono)
    {
        $model = new Choferes();
        $existeChofer = $model->existe('cedula', '=', $cedula);

        if (!$existeChofer){
            $data = [
                $empresas,
                $vehiculos,
                $cedula,
                $nombre,
                $telefono,
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
                'existe_chofer',
                false,
                'Chofer ya registrado.',
                'El chofer ya esta registrado.',
                'warning'
            );
        }

        return $response;

    }

    public function vehiculos($id){
        $model = new Vehiculos();
        return $model->first('id', '=', $id);
    }

    public function getTipo($id){
        $model = new VehiculoTipo();
        return $model->first('id', '=', $id);
    }

    public function getEmpresas(){
        $model = new Empresa();
        return $model->getAll('1');
    }

    public function getVehiculos(){
        $model = new Vehiculos();
        return $model->getAll(1);
    }

    public function edit($id)
    {
        $model = new Choferes();
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
        $response['empresas'] = $chofer['empresas_id'];
        $response['vehiculo'] = $chofer['vehiculos_id'];
        $response['id'] = $chofer['id'];

        /*$modalEmpresa = new Empresa();
        $response['empresas'] = array();
        foreach ($modalEmpresa->getAll() as $empresa) {
            $id = $empresa['id'];
            $nombre = $empresa['nombre'];
            $response['empresas'][] = array("id" => $id, "nombre" => $nombre);
        }

        $modalVehiculo = new Vehiculos();

        $response['vehiculos'] = array();
        foreach ($modalVehiculo->getAll() as $vehiculo) {
            $tipo = $this->getTipo($vehiculo['tipo']);
            $id = $vehiculo['id'];
            $tipo_vehiculo = $tipo['nombre'];

            $response['vehiculos'][] = array("id" => $id, "tipo_vehiculo" => $tipo_vehiculo);
        }*/

        return $response;
    }

    public function get_datos_vehiculo($id){
        $model = new Vehiculos();
        $modelEmpresa = new Empresa();
        $vehiculos = $model->find($id);
        $empresas = $modelEmpresa->find($vehiculos['empresas_id']);
        $tipo = $this->getTipo($vehiculos['tipo']);

        $response = crearResponse(
            false,
            true,
            'Editar Chofer',
            'Editar Chofer',
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

    function delete($id)
    {
        $model = new Choferes();
        $chofer = $model->find($id);
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
        return $response;
    }

}