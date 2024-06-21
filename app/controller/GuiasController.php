<?php

namespace app\controller;

use app\middleware\Admin;

class GuiasController extends Admin
{
    public string $TITTLE = 'Guias';
    public string $MODULO = 'guias.index';

    public function isAdmin()
    {
        parent::isAdmin(); // TODO: Change the autogenerated stub
        if (!validarPermisos($this->MODULO)) {
            header('location: ' . ROOT_PATH . 'admin\\');
        }
    }

}