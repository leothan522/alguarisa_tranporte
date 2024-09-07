<?php

namespace app\controller;

use app\middleware\Admin;
use app\model\Municipio;
use app\model\Parametro;
use app\model\User;

class UsersController extends Admin
{
    public string $TITTLE = 'Usuarios';
    public string $MODULO = 'usuarios.index';

    public $links;
    public $rows;
    public $limit;
    public $totalRows;
    public $offset;
    public $keyword;
    public $roles;

    public function isAdmin()
    {
        parent::isAdmin(); // TODO: Change the autogenerated stub
        if (!validarPermisos($this->MODULO)) {
            header('location: ' . ROOT_PATH . 'admin\\');
        }
    }

    public function index(
        $baseURL = '_request/UsersRequest.php',
        $tableID = 'tabla_usuarios',
        $limit = null,
        $totalRows = null,
        $offset = null
    )
    {
        $model = new User();

        if (is_null($limit)) {
            $this->limit = numRowsPaginate();
        } else {
            $this->limit = $limit;
        }
        if (is_null($totalRows)) {
            $this->totalRows = $model->count(1);
        } else {
            $this->totalRows = $totalRows;
        }
        $this->offset = $offset;

        $this->links = paginate(
            $baseURL,
            $tableID,
            $this->limit,
            $this->totalRows,
            $offset
        )->createLinks();

        $this->rows = $model->paginate(
            $this->limit,
            $offset,
            'id',
            'DESC',
            1
        );


    }

    public function store($name, $email, $password, $telefono, $tipo): array
    {

        $model = new User();
        $existeEmail = $model->existe('email', '=', $email, null, 1);

        if (!$existeEmail) {

            if ($tipo > 1 && $tipo < 99){
                $modelRol = new Parametro();
                $rol = $modelRol->find($tipo);
                $role_id = $rol['id'];
                $permisos = $rol['valor'];
                $tipo = 2;
            }else{
                $role_id = 0;
                $permisos = null;
            }

            $data = [
                $name,
                $email,
                $password,
                $telefono,
                $tipo,
                $role_id,
                $permisos,
                getFecha(),
                getRowquid($model)
            ];

            $model->save($data);

            $user = $model->first('email', '=', $email);
            $response = crearResponse(
                null,
                true,
                'Usuario Creado Exitosamente.',
                "Usuario Creado " . $name
            );
            //datos extras para el $response
            $response['id'] = $user['id'];
            $response['name'] = $user['name'];
            $response['email'] = $user['email'];
            $response['telefono'] = '<p class="text-center">' . $user['telefono'] . '</p>';
            $response['role'] = '<p class="text-center">' . $this->getRol($user['role'], $user['role_id']) . '</p>';
            $response['item'] = '<p class="text-center">' . $model->count(1) . '</p>';
            $response['estatus'] = '<p class="text-center">' . $this->verEstatusUsuario($user['estatus']) . '</p>';
            $response['total'] = $model->count(1);
            $response['btn_editar'] = validarPermisos('usuarios.edit');
            $response['btn_eliminar'] = validarPermisos('usuarios.destroy');
            $response['btn_permisos'] = validarPermisos();

        } else {
            $response = crearResponse(
                'email_duplicado',
                false,
                'Email Duplicado.',
                'El email ya esta registrado.',
                'warning'
            );
        }

        return $response;
    }

    public function edit($id): array
    {
        $model = new User();
        $user = $model->find($id);

        if ($user) {

            $response = crearResponse(
                null,
                true,
                'Editar Usuario.',
                "Mostrando Usuario " . $user['name'],
                'success',
                false,
                true
            );
            //datos extras para el $response
            $response['id'] = $user['id'];
            $response['name'] = $user['name'];
            $response['email'] = $user['email'];
            $response['telefono'] = $user['telefono'];
            $response['tipo'] = $this->getRol($user['role'], $user['role_id']);
            $response['estatus'] = $this->verEstatusUsuario($user['estatus'], false);
            $response['fecha'] = verFecha($user['created_at']);
            $response['band'] = $user['estatus'];
            if ($user['role'] == 2){
                $response['role'] = $user['role_id'];
            }else{
                $response['role'] = $user['role'];
            }
            $response['permisos'] = $user['permisos'];

        } else {
            $response = crearResponse(
                'no_user',
                false,
                'Usuario NO encontrado.',
                'El id del usuario no esta disponible.',
                'warning',
                true
            );
        }
        return $response;
    }

    public function setEstatus($id): array
    {
        $response = $this->edit($id);
        if ($response['result']){
            $estatus = $response['band'];
            $model = new User();
            if ($estatus) {
                $model->update($id, 'estatus', 0);
                $title = 'Usuario Inactivo';
                $icono = 'info';
                $newEstatus = 0;
                $verEstatus = $this->verEstatusUsuario(0, false);
            } else {
                $model->update($id, 'estatus', 1);
                $title = 'Usuario Activo';
                $icono = 'success';
                $newEstatus = 1;
                $verEstatus = $this->verEstatusUsuario(1, false);
            }
            $response['estatus'] = $verEstatus;
            $response['band'] = $newEstatus;
            $response['table_estatus'] = '<p class="text-center">' . $this->verEstatusUsuario($newEstatus) . '</p>';
        }
        return $response;
    }

    public function setPassword($id, $password): array
    {
        $response = $this->edit($id);
        if ($response['result']){
            $model = new User();
            if (empty($password)) {
                $password = generar_string_aleatorio();
            }
            $db_password = password_hash($password, PASSWORD_DEFAULT);
            $model->update($id, 'password', $db_password);
            $response['toast'] = false;
            $response['title'] = 'Contraseña Guardada.';
            $response['message'] = $password;
        }
        return $response;
    }

    public function update($id, $name, $email, $telefono, $tipo): array
    {
        $model = new User();
        $updated_at = date('Y-m-d');

        $existeEmail = $model->existe('email', '=', $email, $id, 1);

        if (!$existeEmail) {

            $user = $model->find($id);
            $db_name = $user['name'];
            $db_email = $user['email'];
            $db_telefono = $user['telefono'];
            $db_tipo = $user['role'];

            $cambios = false;

            if ($db_name != $name) {
                $cambios = true;
                $model->update($id, 'name', $name);
            }

            if ($db_email != $email) {
                $cambios = true;
                $model->update($id, 'email', $email);
            }

            if ($db_telefono != $telefono) {
                $cambios = true;
                $model->update($id, 'telefono', $telefono);
            }

            if ($db_tipo != $tipo) {
                $cambios = true;
                if ($tipo > 1 && $tipo < 99){
                    $modelRol = new Parametro();
                    $rol = $modelRol->find($tipo);
                    $role_id = $rol['id'];
                    $permisos = $rol['valor'];
                    $tipo = 2;
                }else{
                    $role_id = 0;
                    $permisos = null;
                }
                $model->update($id, 'role', $tipo);
                $model->update($id, 'role_id', $role_id);
                $model->update($id, 'permisos', $permisos);
            }

            if ($cambios) {

                $model->update($id, 'updated_at', $updated_at);
                $response = $this->edit($id);
                $response['toast'] = false;
                $response['title'] = 'Cambios Guardados.';
                $response['message'] = $name . " Actualizado.";
                $response['table_telefono'] = '<p class="text-center">' . $response['telefono'] . '</p>';
                $response['table_role'] = '<p class="text-center">' . $this->getRol($response['role'], $response['role']) . '</p>';
            } else {
                $response = crearResponse('no_cambios');
            }

        } else {
            $response = crearResponse(
                'email_duplicado',
                false,
                'Email Duplicado.',
                'El email ya esta registrado.',
                'warning'
            );
        }
        return $response;
    }

    public function delete($id)
    {
        $model = new User();
        $user = $model->find($id);
        if ($user) {
            $model->update($id, 'band', 0);
            $model->update($id, 'deleted_at', date("Y-m-d"));
            $response = crearResponse(
                null,
                true,
                'Usuario Eliminado.',
                'Usuario Eliminado.'
            );
            //datos extras para el $response
            $response['total'] = $model->count(1);
        } else {
            $response = crearResponse(
                'no_user',
                false,
                'Usuario NO encontrado."',
                'El id del usuario no esta disponible.',
                'warning',
                true
            );
        }
        return $response;
    }

    public function setPermisos($id, $permisos): array
    {
        $model = new User();
        $model->update($id, 'permisos', crearJson($permisos));
        $response = $this->edit($id);
        if (!is_null($response['permisos'])) {
            $response['user_permisos'] = json_decode($response['permisos']);
        } else {
            $response['user_permisos'] = null;
        }
        $permisos = verPermisos();
        $response['permisos'] = $permisos[1];
        $response['toast'] = false;
        $response['title'] = 'Permisos Guardados.';
        $response['message'] = "Mostrando Usuario " . $response['name'];
        return $response;
    }

    public function getRoles()
    {
        $model = new Parametro();
        $this->roles = $model->getList('tabla_id', '=', -1);
    }

    public function getRol($role, $role_id): mixed
    {
        switch ($role) {
            case 0:
                $verRole = 'Público';
                break;
            case 1:
                $verRole = 'Estandar';
                break;
            case 99:
                $verRole = 'Administrador';
                break;
            case 100:
                $verRole = 'Root';
                break;
            default:
                $model = new Parametro();
                $rol = $model->find($role_id);
                $verRole = $rol['nombre'];
                break;
        }

        return $verRole;
    }

    public  function verEstatusUsuario($estatus, $icon = true): string
    {
        if (!$icon) {
            $suspendido = "Suspendido";
            $activado = "Activo";
        } else {
            $suspendido = '<i class="fas fa-user-times"></i>';
            $activado = '<i class="fa fa-user-check"></i>';
        }

        $status = [
            '0' => '<span class="text-danger">' . $suspendido . '</span>',
            '1' => '<span class="text-success">' . $activado . '</span>'/*,
        '2' => '<span class="text-success">Confirmado</span>'*/
        ];
        return $status[$estatus];
    }

    public function search($keyword){
        $model = new User();
        $this->keyword = $keyword;
        $sql = "SELECT * FROM users WHERE name LIKE '%$keyword%' OR email LIKE '%$keyword%' OR telefono LIKE '%$keyword%' LIMIT 100;";
        $this->rows = $model->sqlPersonalizado($sql, 'getAll');
    }

}