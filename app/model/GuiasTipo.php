<?php

namespace app\model;

class GuiasTipo extends Model
{
    public function __construct()
    {
        $this->TABLA = "guias_tipos";
        $this->DATA = [
            'nombre',
            'codigo'
        ];
    }

}