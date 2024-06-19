<?php

namespace app\model;

class Persona extends Model
{
    public function __construct()
    {
        $this->TABLA = "personas";
        $this->DATA = [
            'cedula',
            'nombre',
            'telefono',
            'direccion',
            'created_at'
        ];
    }

}