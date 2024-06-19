<?php

namespace app\model;

class Caso extends Model
{
    public function __construct()
    {
        $this->TABLA = "casos";
        $this->DATA = [
            'personas_id',
            'fecha',
            'hora',
            'donativo',
            'tipo',
            'status',
            'observacion',
            'created_at'
        ];
    }

}