<?php

function permisos(): array
{
    return $permisos = [
        [
            'permiso' => 'usuarios.index',
            'text' => 'Usuarios',
            'opciones' => [
                [
                    'permiso' => 'usuarios.create',
                    'text' => 'Crear Usuarios'
                ],
                [
                    'permiso' => 'usuarios.edit',
                    'text' => 'Editar Usuarios'
                ],
                [
                    'permiso' => 'usuarios.estatus',
                    'text' => 'Cambiar Estatus'
                ],
                [
                    'permiso' => 'usuarios.reset',
                    'text' => 'Reset Password'
                ],
                [
                    'permiso' => 'usuarios.destroy',
                    'text' => 'Borrar Usuarios'
                ]
            ]
        ],
        [
            'permiso' => 'territorio.index',
            'text' => 'Territorio',
            'opciones' => [
                [
                    'permiso' => 'municipios.create',
                    'text' => 'Crear Municipios'
                ],
                [
                    'permiso' => 'municipios.edit',
                    'text' => 'Editar Municipios'
                ],
                [
                    'permiso' => 'municipios.destroy',
                    'text' => 'Borrar Municipios'
                ],
                [
                    'permiso' => 'municipios.estatus',
                    'text' => 'Estatus Municipios'
                ],
                [
                    'permiso' => 'parroquias.create',
                    'text' => 'Crear Parroquias'
                ],
                [
                    'permiso' => 'parroquias.edit',
                    'text' => 'Editar Parroquias'
                ],
                [
                    'permiso' => 'parroquias.destroy',
                    'text' => 'Borrar Parroquias'
                ],
                [
                    'permiso' => 'parroquias.estatus',
                    'text' => 'Estatus Parroquias'
                ]
            ]
        ],
        [ 'permiso' => 'guias.index',
            'text' => 'Guias',
            'opciones' => [
                [
                    'permiso' => 'guias.create',
                    'text' => 'Crear chofer'
                ],
                [
                    'permiso' => 'guias.edit',
                    'text' => 'Editar Guia'
                ],
                [
                    'permiso' => 'guias.anular',
                    'text' => 'Anular Guia'
                ],
                [
                    'permiso' => 'guias.descargar',
                    'text' => 'Descargar Guia'
                ]
            ]
        ],
        [ 'permiso' => 'choferes.index',
            'text' => 'Choferes',
            'opciones' => [
                [
                    'permiso' => 'choferes.create',
                    'text' => 'Crear choferes'
                ],
                [
                    'permiso' => 'choferes.edit',
                    'text' => 'Editar Choferes'
                ],
                [
                    'permiso' => 'choferes.destroy',
                    'text' => 'Borrar Choferes'
                ],
                [
                    'permiso' => 'choferes.descargar',
                    'text' => 'Descargar QR'
                ],
                [
                    'permiso' => 'choferes.estatus',
                    'text' => 'Choferes Estatus'
                ]
            ]
        ],
        [ 'permiso' => 'vehiculos.index',
            'text' => 'Vehículos',
            'opciones' => [
                [
                    'permiso' => 'vehiculos.create',
                    'text' => 'Crear Vehículos'
                ],
                [
                    'permiso' => 'vehiculos.edit',
                    'text' => 'Editar Vehículos'
                ],
                [
                    'permiso' => 'vehiculos.destroy',
                    'text' => 'Borrar Vehículos'
                ]
            ]
        ],
        [ 'permiso' => 'empresas.index',
            'text' => 'Empresas',
            'opciones' => [
                [
                    'permiso' => 'empresas.create',
                    'text' => 'Crear Empresas'
                ],
                [
                    'permiso' => 'empresas.edit',
                    'text' => 'Editar Empresas'
                ],
                [
                    'permiso' => 'empresas.destroy',
                    'text' => 'Borrar Empresas'
                ]
            ]
        ],
        [ 'permiso' => 'rutas.index',
            'text' => 'Rutas',
            'opciones' => [
                [
                    'permiso' => 'rutas.create',
                    'text' => 'Crear Rutas'
                ],
                [
                    'permiso' => 'rutas.edit',
                    'text' => 'Editar Rutas'
                ],
                [
                    'permiso' => 'rutas.destroy',
                    'text' => 'Borrar Rutas'
                ]
            ]
        ]

        /*
         * Ejemplo de permiso
         *
         *
        [ 'permiso' => 'usuarios.index',
            'text' => 'Usuarios',
            'opciones' => [
                [
                    'permiso' => 'usuarios.create',
                    'text' => 'Crear Usuarios'
                ],
                [
                    'permiso' => 'usuarios.edit',
                    'text' => 'Editar Usuarios'
                ]
            ]
        ]

        */
    ];
}