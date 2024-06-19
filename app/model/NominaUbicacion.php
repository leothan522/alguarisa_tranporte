<?php

namespace app\model;

class NominaUbicacion extends Model
{
    public function __construct()
    {
        $this->TABLA = "nomina_ubicaciones";
        $this->DATA = [
            'tipo',
            'nombre'
        ];
    }

}