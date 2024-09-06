<?php
namespace app\database;

use PDO;
use PDOException;

header("Access-Control-Allow-Origin: *");
date_default_timezone_set(APP_TIMEZONE);
class Conexion{

    public PDO $CONEXION;
    public function __construct()
    {

        try {
            $db_conexion = DB_CONNECTION;
            $db_host = DB_HOST;
            $db_port = DB_PORT;
            $db_database = DB_DATABASE;
            $db_username = DB_USERNAME;
            $db_password = DB_PASSWORD;
            $db_dns = "$db_conexion:host=$db_host;dbname=$db_database";
            $this->CONEXION = new PDO($db_dns, $db_username, $db_password);
        }catch (PDOException $e){
            $response['result'] = false;
            $response['icon'] = "error";
            $response['title'] = 'Error de CONEXION';
            $response['text'] = "PDOException {$e->getMessage()}";
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }

    }


}
