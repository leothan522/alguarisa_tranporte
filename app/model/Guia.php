<?php

namespace app\model;

class Guia extends Model
{
    public function __construct()
    {
        $this->TABLA = "guias";
        $this->DATA = [
            'codigo',
            'guias_tipos_id',
            'tipos_nombre',
            'vehiculos_id',
            'vehiculos_tipo',
            'vehiculos_marca',
            'vehiculos_placa_batea',
            'vehiculos_placa_chuto',
            'vehiculos_color',
            'vehiculos_capacidad',
            'choferes_id',
            'choferes_cedula',
            'choferes_nombre',
            'choferes_telefono',
            'territorios_origen',
            'territorios_destino',
            'rutas_id',
            'rutas_origen',
            'rutas_destino',
            'rutas_ruta',
            'fecha',
            'users_id',
            'created_at',
            'pdf_id',
            'precinto',
            'precinto_2',
            'precinto_3',
            'version',
            'rowquid'
        ];
    }

}