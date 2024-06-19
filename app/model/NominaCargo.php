<?php

namespace app\model;

class NominaCargo extends Model
{
    public function __construct()
    {
        $this->TABLA = "nomina_cargos";
        $this->DATA = [
            'cargo'
        ];
    }

}