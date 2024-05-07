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