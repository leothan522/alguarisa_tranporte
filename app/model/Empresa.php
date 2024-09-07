<?php

namespace app\model;

class Empresa extends Model
{
    public function __construct()
    {
        $this->TABLA = "empresas";
        $this->DATA = [
            'rif',
            'nombre',
            'responsable',
            'telefono',
            'created_at',
            'rowquid'
        ];
    }

}