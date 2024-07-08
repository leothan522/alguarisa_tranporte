<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Parroquia;


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


}