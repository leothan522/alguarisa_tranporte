<?php

namespace app\model;

class Cargo extends Model
{
    public function __construct()
    {
        $this->TABLA = "cargos";
        $this->DATA = [
            'cargo'
        ];
    }

}