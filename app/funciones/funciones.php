<?php

use app\model\Parametro;
use Carbon\Carbon;
use Dotenv\Dotenv;

init();

function init(): void
{
    try {
        $dotenv = Dotenv::createImmutable(dirname(__FILE__, 3));
        $dotenv->load();
    }catch (Exception $e){
        echo $e->getMessage();
        exit();
    }

    define('ROOT_PATH', $_ENV['APP_URL']);

    //Definimois valores por defecto para las variebles de entorno
    define('APP_NAME', env('APP_NAME'));
    $key = 'id';
    if (env('APP_KEY')){
        $key = str_replace(':', '', env('APP_KEY'));
        $key = str_replace('=', '', $key);
    }
    define('APP_KEY', $key);
    define('APP_DEBUG', env('APP_DEBUG', true));
    define('APP_URL', env('APP_URL', getURLActual()));
    define('APP_DOMINIO', env('APP_DOMINIO', getURLActual()));
    define('APP_TIMEZONE', env('APP_TIMEZONE', "America/Caracas"));
    define('APP_REGISTER', env('APP_REGISTER', false));

    //database
    define('DB_CONNECTION', env('DB_CONNECTION', "mysql"));
    define('DB_HOST', env('DB_HOST', "127.0.0.1"));
    define('DB_PORT', env('DB_PORT', 3306));
    define('DB_DATABASE', env('DB_DATABASE', "nombre_database"));
    define('DB_USERNAME', env('DB_USERNAME', "root"));
    define('DB_PASSWORD', env('DB_PASSWORD'));

    //mail
    define('MAIL_MAILER', env('MAIL_MAILER', "smtp"));
    define('MAIL_HOST', env('MAIL_HOST', "mailpit"));
    define('MAIL_PORT', env('MAIL_PORT', 1025));
    define('MAIL_USERNAME', env('MAIL_USERNAME'));
    define('MAIL_PASSWORD', env('MAIL_PASSWORD'));
    define('MAIL_ENCRYPTION', env('MAIL_ENCRYPTION'));
    define('MAIL_FROM_ADDRESS', env('MAIL_FROM_ADDRESS', "hello@example.com"));
    define('MAIL_FROM_NAME', env('MAIL_FROM_NAME', APP_NAME));
}

function env($env, $default = null): mixed
{
    if (isset($_ENV[mb_strtoupper($env)])){
        $response = $_ENV[mb_strtoupper($env)];
    }else{
        $response = $default;
    }
    return $response;
}

function asset($url, $noCache = false): void
{
    $version = null;
    if ($noCache){
        if (env('APP_DEBUG')){
            $version = "?v=".rand();
        }
    }
    echo APP_URL . '/' . $url . $version;
}

function public_path($url): string
{
    return ROOT_PATH."/".$url;
}

function getURLActual(): string
{
    // Obtener el protocolo (http o https)
    $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    // Obtener el nombre del host
    $host = $_SERVER['HTTP_HOST'];
    // Obtener la URI de la solicitud
    $uri = $_SERVER['REQUEST_URI'];
    // Combinar todo para obtener la URL completa
    return $protocolo . $host . $uri;
}

function generar_string_aleatorio($largo = 10, $espacio = false): string
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $caracteres = $espacio ? $caracteres . ' ' : $caracteres;
    $string = '';
    for ($i = 0; $i < $largo; $i++) {
        $string .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $string;
}

function verUtf8($string, $safeNull = false): string
{
    //$utf8_string = "Some UTF-8 encoded BATE QUEBRADO ÑñíÍÁÜ niño ó Ó string: é, ö, ü";
    $response = null;
    $text = 'NULL';
    if ($safeNull){
        $text = '';
    }
    if (!is_null($string)){
        $response = mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
    }
    if (!is_null($response)){
        $text = "$response";
    }
    return $text;
}

function getFecha($fecha = null, $format = null): string
{
    if (is_null($fecha)){
        if (is_null($format)){
            $date = Carbon::now(APP_TIMEZONE)->toDateString();
        }else{
            $date = Carbon::now(APP_TIMEZONE)->format($format);
        }
    }else{
        if (is_null($format)){
            $date = Carbon::parse($fecha)->format('d/m/Y');
        }else{
            $date = Carbon::parse($fecha)->format($format);
        }
    }
    return $date;
}

function haceCuanto($fecha): string
{
    return Carbon::parse($fecha)->diffForHumans();
}

// Obtener la fecha en español
function fechaEnLetras($fecha, $isoFormat = null): string
{
    // dddd => Nombre del DIA ejemplo: lunes
    // MMMM => nombre del mes ejemplo: febrero
    $format = "dddd D [de] MMMM [de] YYYY"; // fecha completa
    if (!is_null($isoFormat)){
        $format = $isoFormat;
    }
    return Carbon::parse($fecha)->isoFormat($format);
}

function formatoMillares($cantidad, $decimal = 0): string
{
    if (!is_numeric($cantidad)){
        $cantidad = 0;
    }
    return number_format($cantidad, $decimal, ',', '.');
}

function listarDias(): array
{
    return ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"];
}

function ListarMeses(): array
{
    return ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
}

function numRowsPaginate(): int
{
    $num = 30;
    $model = new Parametro();
    $parametro = $model->first('nombre', '=', 'numRowsPaginate');
    if ($parametro) {
        if (is_numeric($parametro['valor'])) {
            $num = intval($parametro['valor']);
        }
    }
    return $num;
}

function cerosIzquierda($cantidad, $cantCeros = 2): int|string
{
    if ($cantidad == 0) {
        return 0;
    }
    return str_pad($cantidad, $cantCeros, "0", STR_PAD_LEFT);
}

function numSizeCodigo(): int
{
    $num = 5;
    $model = new Parametro();
    $parametro = $model->first('nombre', '=', 'size_codigo');
    if ($parametro) {
        if (is_int($parametro['tabla_id'])) {
            $num = intval($parametro['tabla_id']);
        }
    }
    return $num;
}

function leerJson($json, $key)
{
    if ($json == null) {
        return null;
    } else {
        $json = $json;
        $json = json_decode($json, true);
        if (array_key_exists($key, $json)) {
            return $json[$key];
        } else {
            return null;
        }
    }
}

function crearJson($array): bool|string
{
    $json = array();
    foreach ($array as $key) {
        $json[$key] = true;
    }
    return json_encode($json);
}

// Spinner Cargando
function verCargando(): void
{
    echo '
<div class="overlay-wrapper">
      <div class="overlay d-none ver_spinner_cargando">
          <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
          </div>
      </div>
 </div>
      ';
}

function verImagen($path, $user = false): string
{
    if (!empty($path)){

        $url = public_path($path);

        if (url_exists($url)){
            return $url;
        }else{
            if ($user){
                return public_path('public/img/user_blank.png');
            }else{
                return public_path('public/img/img_placeholder.jpeg');
            }
        }

    }else{
        if ($user){
            return public_path('public/img/user_blank.png');
        }else{
            return public_path('public/img/img_placeholder.jpeg');
        }
    }
}

function getRowquid($model): string
{
    do{
        $rowquid = generar_string_aleatorio(16);
        $existe = $model->existe('rowquid', '=', $rowquid);
    }while($existe);
    return $rowquid;
}

//**************************************************************** */

function crearResponse($error = null, $result = false, $title = null, $message = null, $icon = 'success', $alerta = false, $noToast = null ): array
{
    $response = array();


    switch ($error){

        case 'error_method':
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = 'error_method';
            $response['icon'] = "error";
            $response['title'] = "Error Method.";
            $response['message'] = "Deben enviarse los datos por el method POST.";
            break;

        case 'error_opcion':
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = "error_opcion";
            $response['icon'] = "error";
            $response['title'] = "Error Opcion.";
            $response['message'] = "La variable \"opcion\" no esta definida.";
            break;

        case 'error_excepcion':
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = 'error_excepcion';
            $response['icon'] = "error";
            $response['title'] = 'Error Exception.';
            $response['message'] = $message;
            break;

        case 'no_opcion':
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = "no_opcion";
            $response['icon'] = "warning";
            $response['title'] = "Opción no Programada.";
            $response['message'] = "No se ha programado la logica para la opción \"$message\"";
            break;

        case 'faltan_datos':
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = "faltan_datos";
            $response['icon'] = "warning";
            $response['title'] = "Faltan datos.";
            $response['message'] = "Algunos campos son requeridos, es decir obligatorios.";
            break;

        case 'no_cambios':
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = "no_cambios";
            $response['icon'] = "info";
            $response['title'] = "Sin Cambios.";
            $response['message'] = "No se realizo ningun cambio.";
            break;

        case 'no_permisos':
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = "no_permisos";
            $response['icon'] = "warning";
            $response['title'] = "Permiso Denegado.";
            $response['message'] = "El usuario actual no tiene permisos suficientes para realizar esta acción. Contacte con su Administrador.";
            break;

        case 'vinculado':
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = "si_vinculado";
            $response['icon'] = "warning";
            $response['title'] = "¡No se puede Borrar!";
            $response['message'] = "El registro que intenta borrar ya se encuentra vinculado con otros procesos.";

            break;

        case 'no_found':
            $response['result'] = false;
            $response['alerta'] = true;
            $response['error'] = "no_found";
            $response['icon'] = "warning";
            $response['title'] = "¡No encontrado!";
            $response['message'] = "El registro no se encuentra en nuestra Base de Datos.";

            break;

        default:
            $response['result'] = $result;
            $response['alerta'] = $alerta;
            $response['error'] = $error;
            if (!is_null($noToast)){
                $response['toast'] = 'false';
            }
            $response['icon'] =  $icon;
            $response['title'] = $title;
            $response['message'] = $message;
            break;
    }

    return $response;
}

function verFecha($fecha, $format = null): string
{
    if (is_null($format)){ $format = "d-m-Y"; }
    $newDate = date($format, strtotime($fecha));
    return $newDate;
}

function mesEspanol($numMes = null): array|int|string|null
{
    $meses = ["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];
    if (!is_null($numMes)){
        if (is_int($numMes) && $numMes > 0 && $numMes <= 12){
            $mes = $meses[$numMes - 1];
            return $mes;
        }else{
            if (in_array(strtolower($numMes), $meses)){
                return array_search(strtolower($numMes), $meses) + 1;
            }
            return null;
        }

    }else{
        return $meses;
    }
}

function verHora($hora): string
{
    $newHora = date("g:i a", strtotime($hora));
    return $newHora;
}

 function getFormato(): array
 {
    $ID_FORMATO_GUIA = 1;
    $model = new Parametro();
    $parametro = $model->first('nombre', '=', 'guias_formatos_pdf');

    if ($parametro) {
        //sequimos
        if (!empty($parametro['valor']) && is_string($parametro['valor'])) {
            if (url_exists(public_path('admin/guias/_storage/formatos/' . $parametro['valor'] . '/'))) {
                $FORMATO_GUIA_PDF = public_path('admin/guias/_storage/formatos/' . $parametro['valor'] . '/');
                $ID_FORMATO_GUIA = $parametro['id'];
            } else {
                $FORMATO_GUIA_PDF = public_path('admin/guias/_storage/formatos/default/');
            }
        } else {
            $FORMATO_GUIA_PDF = public_path('admin/guias/_storage/formatos/default/');
        }
    } else {
        $FORMATO_GUIA_PDF = public_path('admin/guias/_storage/formatos/default/');
    }
    return [$FORMATO_GUIA_PDF, $ID_FORMATO_GUIA];
}

function verFechaLetras($fecha): string
{
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $numero_ES = array("Uno", "Dos", "Tres", "Cuatro", "Cinco", "Seis", "Siete", "Ocho", "Nueve", "Diez", "Once", "Doce", "Trece", "Catorce", "Quince", "Dieciséis", "Diecisiete", "Dieciocho", "Diecinueve", "Veinte", "Veintiuno", "Veintidos", "Veintitres", "Veinticuatro", "Veinticinco", "Veintiseis", "Veintisiete", "Veintiocho", "Veintinueve", "Treinta", "Treinta y Uno");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    //return $nombredia . " " . $numeroDia . " de " . $nombreMes . " de " . $anio;
    return verUtf8("A los " . strtoupper($numero_ES[$numeroDia - 1]) . " (" . $numeroDia . ") DEL MES DE " . strtoupper($nombreMes) . " DEL AÑO " . $anio . ".");
}

function compararFechas($fechaInicial, $fechaFinal): float
{
    // Declaramos nuestras fechas inicial y final
    //$fechaInicial = date('2023-05-18');
    //$fechaFinal = date('2023-05-19');

    // Las convertimos a segundos
    $fechaInicialSegundos = strtotime($fechaInicial);
    $fechaFinalSegundos = strtotime($fechaFinal);

    // Hacemos las operaciones para calcular los dias entre las dos fechas y mostramos el resultado
    $dias = ($fechaFinalSegundos - $fechaInicialSegundos) / 86400;
    //echo "La diferencia entre la fecha : " . $fechaInicial . " y " . $fechaFinal . " es de: " . round($dias, 0, PHP_ROUND_HALF_UP)  . " dias.";

    //Resultado de los dias de diferencia entre dos fechas

    /*
*   La diferencia entre la fecha : 2022-01-01 y 2023-01-01 es de: 365 dias.
*/
    return round($dias, 0, PHP_ROUND_HALF_UP);
}

function validateJSON(string $json): bool
{
    try {
        $test = json_decode($json, null, JSON_THROW_ON_ERROR);
        if (is_object($test)) return true;
        return false;
    } catch (Exception $e) {
        return false;
    }
}

function url_exists( $url = NULL ) {

    if( empty( $url ) ){
        return false;
    }

    $options['http'] = array(
        'method' => "HEAD",
        'ignore_errors' => 1,
        'max_redirects' => 0
    );
    $body = @file_get_contents( $url, NULL, stream_context_create( $options ) );

    // Ver http://php.net/manual/es/reserved.variables.httpresponseheader.php
    if( isset( $http_response_header ) ) {
        sscanf( $http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode );

        // Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
        $accepted_response = array( 200, 301, 302 );
        if( in_array( $httpcode, $accepted_response ) ) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function subirImagen($file, $nombre, $dir = 'public/img/', $path_file = '../../../'){
    $imagen = $file; // Acceder al archivo de imagen
    $nombreImagen = $imagen['name']; // Obtener el nombre del archivo
    $extension = pathinfo($nombreImagen, PATHINFO_EXTENSION); //obtengo la extension del archivo si el punto
    $nombre = $nombre.'.'.$extension;
    $temporal = $imagen['tmp_name']; // Obtener el nombre temporal del archivo


    // Definir la ruta donde se guardará la imagen
    $carpetaDestino = $path_file.$dir;
    $rutaDestino = $carpetaDestino . $nombre;
    $path = $dir . $nombre;

    if ($file['size'] > 2097152){
        $resultado = [false, null, 'error_size', 'El tamaño de la imagen no puede ser mayor a 2MB.'];
    }else{
        // Mover el archivo de la ubicación temporal a la carpeta de destino
        if(move_uploaded_file($temporal, $rutaDestino)){
            $resultado = [true, $path, null, null];
        } else {
            $resultado = [false, null ,'error_subir', 'Error de servidor. contacte a su administrador.'];
        }
    }
    return $resultado;

}

function borrarArchivos($path){
    if (!empty($path)){
        if (file_exists($path)){
            unlink($path);
        }
    }
}

function validateSizeNumber($number=0, $lenght=0){

    if( is_numeric($number) AND is_numeric($lenght) AND (strlen($number)==$lenght)) return true;

    return false;

}

