<?php

namespace app\model;

class GuiasFormato extends Model
{
    public function __construct()
    {
        $this->TABLA = "guias_formatos_pdf";
        $this->DATA = [
            'nombre',
            'text_color'
        ];
    }

}