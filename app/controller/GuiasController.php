<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Empresa;
use app\model\Vehiculo;

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

    public function getVehiculo($id)
    {
        $model = new Vehiculo();
        $modelEmpresa = new Empresa();
        $vehiculos = $model->find($id);
        $empresas = $modelEmpresa->find($vehiculos['empresas_id']);
        $choferes = new ChoferesController();
        $tipo = $choferes->getTipo($vehiculos['tipo']);

        $response = crearResponse(
            false,
            true,
            'Get Chofer',
            'Get Chofer',
            'success',
            false,
            true
        );
        $response['placa_batea'] = $vehiculos['placa_batea'];
        $response['marca'] = $vehiculos['marca'];
        $response['tipo'] = $tipo['nombre'];
        $response['color_vehiculo'] = $vehiculos['color'];
        $response['placa_chuto'] = $vehiculos['placa_chuto'];
        $response['rif'] = $empresas['rif'];
        $response['nombre'] = verUtf8($empresas['nombre']);
        $response['responsable'] = verUtf8($empresas['responsable']);
        $response['telefono'] = $empresas['telefono'];

        return $response;
    }

    public function getEmpresas()
    {
        $model = new Empresa();
        return $model->getAll('1');
    }

}