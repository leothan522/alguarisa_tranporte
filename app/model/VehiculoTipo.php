<?php

namespace app\model;

class VehiculoTipo extends Model
{

    public function __construct()
    {
        $this->TABLA = "vehiculos_tipo";
        $this->DATA = [
            'nombre',
        ];
    }
}