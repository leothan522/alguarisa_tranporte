<?php

namespace app\model;

class RutasTerritorio extends Model
{
    public function __construct()
    {
        $this->TABLA = "rutas_territorio";
        $this->DATA = [
            'municipio',
            'parroquia'
        ];
    }

}