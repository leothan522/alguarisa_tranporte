<?php

namespace app\model;

class Chofere extends Model
{
    public function __construct()
    {
        $this->TABLA = "choferes";
        $this->DATA = [
            'empresas_id',
            'vehiculos_id',
            'cedula',
            'nombre',
            'telefono',
            'created_at'
        ];
    }

}