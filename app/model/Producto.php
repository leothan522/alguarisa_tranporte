<?php

namespace app\model;

class Producto extends Model
{
    public function __construct()
    {
        $this->TABLA = "productos";
        $this->DATA = [
            'casos_id',
            'producto',
            'cantidad'
        ];
    }

}