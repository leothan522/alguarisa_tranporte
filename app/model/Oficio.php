<?php

namespace app\model;

class Oficio extends Model
{
    public function __construct()
    {
        $this->TABLA = "oficios";
        $this->DATA = [
            'instituciones_id',
            'personas_id',
            'fecha',
            'requerimientos',
            'status'
        ];
    }

}