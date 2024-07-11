<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Empresa;
use app\model\Parametro;
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

    public function getColor(): array
    {
        $model = new Parametro();
        $color = [0,0,0];
        $parametro = $model->first('nombre', '=', 'guias_color_rgb');
        if ($parametro){
           switch ($parametro['valor']){
               case 'black':
                   $r = 0;
                   $g = 0;
                   $b = 0;
                   break;

               case 'blue':
                   $r = 0;
                   $g = 0;
                   $b = 128;
                   break;


               default:

                   $valor = strpos($parametro['valor'], ',');
                   if ($valor === false){
                       $r = 0;
                       $g = 0;
                       $b = 0;
                   }else{
                       $explode = explode(',', $parametro['valor']);
                       if (count($explode) === 3){
                           if (is_numeric($explode[0]) && ($explode[0] >= 0) && ($explode[0] <= 255)){
                              $r = $explode[0];
                           }else{
                               $r = 0;
                           }

                           if (is_numeric($explode[1]) && ($explode[1] >= 0) && ($explode[1] <= 255)){
                               $g = $explode[1];
                           }else{
                               $g = 0;
                           }

                           if (is_numeric($explode[2]) && ($explode[2] >= 0) && ($explode[2] <= 255)){
                               $b = $explode[1];
                           }else{
                               $b = 0;
                           }

                       }else{
                           $r = 0;
                           $g = 0;
                           $b = 0;
                       }
                   }

               break;
           }
           $color = [$r,$g,$b];
        }
        return $color;
    }

}