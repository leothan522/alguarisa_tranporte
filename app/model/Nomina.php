<?php

namespace app\model;

class Nomina extends Model
{
    public function __construct()
    {
        $this->TABLA = "nomina";
        $this->DATA = [
            'cedula',
            'nombre',
            'apellido',
            'cargos_id',
            'administrativa_id',
            'geografica_id',
            'cargo',
            'ubicacion_administrativa',
            'ubicacion_geografica',
            'created_at'
        ];
    }

}