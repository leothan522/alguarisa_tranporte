<?php

namespace app\model;

class GuiasCarga extends Model
{
    public function __construct()
    {
        $this->TABLA = "guias_carga";
        $this->DATA = [
            'guias_id',
            'cantidad',
            'descripcion'
        ];
    }

}