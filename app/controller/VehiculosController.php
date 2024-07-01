<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Empresa;
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
        $contentDiv = 'card_table_vehiculos'
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

    public function getEmpresas()
    {
        $model = new Empresa();
        return $model->getAll('1');
    }
}