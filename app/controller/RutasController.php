<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Guia;
use app\model\Parroquia;
use app\model\Ruta;


class RutasController extends Admin
{
    public $rows;
    public $totalRows;
    public $links;
    public $limit;
    public $offset;
    public $keyword;

    public function getParroquias()
    {
        $model = new Parroquia();
        return $model->getAll();
    }

    public function store($origen, $contador, $destino)
    {
        $model = new Ruta();

        $array = array();
        for ($i = 1; $i <= $contador; $i++) {
            if (isset($_POST['ruta_' . $i])) {
                $item = $_POST['ruta_' . $i];
                array_push($array, $item);
            }
        }
        $ruta = json_encode($array);

        $sql = "SELECT * FROM rutas WHERE `origen` = '$origen' AND `destino` = '$destino' AND `version` = '1' AND `band` = '1';";
        $existe = $model->sqlPersonalizado($sql);

        $sql = "SELECT * FROM rutas WHERE `origen` = '$destino' AND `destino` = '$origen' AND `version` = '1' AND `band` = '1';";
        $inverso = $model->sqlPersonalizado($sql);

        if (!$existe && !$inverso){
            $data = [
                $origen,
                $destino,
                $ruta,
                1,
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
            'ruta_duplicada',
            false,
            'La ruta que intentas crear ya esta registrada.',
            'La ruta que intentas crear ya esta registrada.',
            'warning',
            false,
            true
            );
        }

        return $response;

    }

    public function index(
        $baseURL = '_request/RutasRequest.php',
        $tableID = 'table_rutas',
        $limit = null,
        $totalRows = null,
        $offset = null,
        $opcion = 'paginate',
        $contentDiv = 'div_rutas'
    )
    {

        $model = new Ruta();
        if (is_null($limit)) {
            $this->limit = numRowsPaginate();
        } else {
            $this->limit = $limit;
        }
        if (is_null($totalRows)) {
            $this->totalRows = $model->count(1, 'version', '=', 1);
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

        $this->rows = $model->paginate($this->limit, $offset, 'id', 'DESC', 1, 'version', '=', 1);
    }

    public function getParroquia($id)
    {
        $model = new Parroquia();
        $parroquia = $model->find($id);
        return mb_strtoupper($parroquia['nombre']);
    }

    public function getRuta($id)
    {
        $model = new Ruta();
        $ruta = $model->find($id);
        $response = crearResponse(
            false,
            true,
            'get ruta',
            'get ruta',
            'success',
            false,
            true
        );
        $response['origen'] = $this->getParroquia($ruta['origen']);
        $response['id_origen'] = $ruta['origen'];
        $response['id_destino'] = $ruta['destino'];
        $response['destino'] = $this->getParroquia($ruta['destino']);
        $trayecto = json_decode($ruta['ruta']);
        foreach ($trayecto as $lugar) {
            $response['listarLugares'][] = array("lugar" => mb_strtoupper($lugar));
        }

        return $response;
    }

    public function update($origen, $contador, $destino, $id)
    {
        $model = new Ruta();
        $ruta = $model->find($id);
        $db_origen = $ruta['origen'];
        $db_destino = $ruta['destino'];
        $db_trayecto = $ruta['ruta'];
        $procesar = false;


        $nuevo = array();
        for ($i = 1; $i <= $contador; $i++) {
            if (isset($_POST['ruta_' . $i])) {
                $item = $_POST['ruta_' . $i];
                array_push($nuevo, $item);
            }
        }
        $trayecto = json_encode($nuevo);

        $viejo = json_decode($db_trayecto);
        $tm_nuevo = count($nuevo);
        $tm_viejo = count($viejo);


        if ($db_origen != $origen){
            $procesar = true;
        }

        if ($tm_nuevo != $tm_viejo){
            $procesar = true;
        }else{
            //seguimos validando
            foreach ($nuevo as $value){
                if (!in_array($value, $viejo)){
                    $procesar = true;
                }
            }

        }

        if ($db_destino != $destino){
            $procesar = true;
        }

        $sql = "SELECT * FROM rutas WHERE `origen` = '$origen' AND `destino` = '$destino' AND `version` = '1' AND `band` = '1' AND id != '$id';";
        $existe = $model->sqlPersonalizado($sql);

        $sql = "SELECT * FROM rutas WHERE `origen` = '$destino' AND `destino` = '$origen' AND `version` = '1' AND `band` = '1' AND id != '$id';";
        $inverso = $model->sqlPersonalizado($sql);

        if ($existe || $inverso){
            $procesar = false;
        }

        if ($procesar){
            $model->update($id, 'origen', $origen);
            $model->update($id, 'destino', $destino);
            $model->update($id, 'ruta', $trayecto);
            $response = crearResponse(
                null,
                true,
                'Editado Exitosamente.',
                'El jefe se ha guardado Exitosamente.'
            );
            $ruta = $model->find($id);
            $response['id'] = $ruta['id'];
            $response['origen'] = $this->getParroquia($ruta['origen']);
            $response['id_origen'] = $ruta['origen'];
            $response['id_destino'] = $ruta['destino'];
            $response['destino'] = $this->getParroquia($ruta['destino']);
            $trayecto = json_decode($ruta['ruta']);
            foreach ($trayecto as $lugar) {
                $response['listarLugares'][] = array("lugar" => mb_strtoupper($lugar));
            }
        }else{
            if ($existe || $inverso){
                $response = crearResponse(
                    'ruta_duplicada',
                    false,
                    'La ruta que intentas crear ya esta registrada.',
                    'La ruta que intentas crear ya esta registrada.',
                    'warning',
                    false,
                    true
                );
            }else{
                $response = crearResponse('no_cambios');
            }

        }


        /*$sql = "SELECT * FROM rutas WHERE `origen` = '$origen' AND `destino` = '$destino' AND `version` = '1' AND `band` = '1';";
        $existe = $model->sqlPersonalizado($sql);

        $sql = "SELECT * FROM rutas WHERE `origen` = '$destino' AND `destino` = '$origen' AND `version` = '1' AND `band` = '1';";
        $inverso = $model->sqlPersonalizado($sql);

        if (!$existe && !$inverso){
            $data = [
                $origen,
                $destino,
                $trayecto,
                1,
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
                'ruta_duplicada',
                false,
                'La ruta que intentas crear ya esta registrada.',
                'La ruta que intentas crear ya esta registrada.',
                'warning',
                false,
                true
            );
        }

        return $response;*/

        return $response;

    }

    public function destroy($id)
    {
        $model = new Ruta();
        $modelGuias = new Guia();
        $ruta = $model->find($id);
        $vinculado = false;
        $guias = $modelGuias->first('rutas_id', '=', $id);
        if ($guias){
            $vinculado = true;
        }

        if ($vinculado){
            $response = crearResponse('vinculado');
        }else{
            $model->delete($id);
            $response = crearResponse(
                false,
                true,
                'Ruta Eliminada',
                'Ruta Eliminada',
                'success'
            );
            $response['total'] = $model->count(1);
        }


        return $response;
    }


}