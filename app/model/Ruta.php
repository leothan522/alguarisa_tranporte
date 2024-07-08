<?php

namespace app\model;

class Ruta extends Model
{
    public function __construct()
    {
        $this->TABLA = "rutas";
        $this->DATA = [
            'origen',
            'destino',
            'ruta',
            'version',
            'created_at'
        ];
    }

}