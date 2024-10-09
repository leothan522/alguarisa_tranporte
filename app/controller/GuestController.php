<?php

namespace app\controller;

use app\model\User;

class GuestController
{
    public $token;

    public function index(): void
    {
        if (isset($_SESSION[APP_KEY])) {
            header('location:' . ROOT_PATH . '\\admin');
        }
    }

    public function login($email, $password): array
    {
        $model = new User();
        $existeEmail = $model->existe('email', '=', $email, null, 1);
        if ($existeEmail) {

            $id = $existeEmail['id'];
            $name = $existeEmail['name'];
            $db_password = $existeEmail['password'];
            $band = $existeEmail['band'];
            $estatus = $existeEmail['estatus'];

            if (password_verify($password, $db_password)) {

                if ($estatus) {
                    $_SESSION[APP_KEY] = $id;
                    $response = crearResponse(
                        null,
                        true,
                        "Bienvenido " . $name,
                        "Bienvenido " . $name
                    );
                } else {
                    $response = crearResponse(
                        'no_activo',
                        false,
                        'Usuario Inactivo.',
                        'Usuario Inactivo. Contacte a su Administrador.',
                        'error',
                        false
                    );
                }

            } else {
                $response = crearResponse(
                    'no_password',
                    false,
                    'Contreseña invalida.',
                    'La contraseña es incorrecta.',
                    'error',
                    false
                );
            }

        } else {
            $response = crearResponse(
                'no_email',
                false,
                'Email NO encontrado.',
                'El Email NO se encuentra en nuestros registro.',
                'error',
                false);
        }
        return $response;
    }

    public function recover(): void
    {
        $this->index();

        if (isset($_GET['token']) && isset($_GET['email'])) {


            $token = $_GET['token'];
            $email = $_GET['email'];
            $model = new User();
            $existeEmail = $model->existe('email', '=', $email, null, 1);

            if ($existeEmail) {
                $db_token = $existeEmail['token'];
                $db_date_token = $existeEmail['date_token'];
                $id = $existeEmail['id'];
                $hoy = date("Y-m-d H:i:s");
                $this->token = compararFechas($db_date_token, $hoy);

                if (compararFechas($db_date_token, $hoy) == 0) {
                    if ($token == $db_token) {
                        $this->token = $token;
                    } else {
                        header('location:' . ROOT_PATH . 'login\\');
                    }

                } else {
                    $model->update($id, 'date_token', null);
                    $model->update($id, 'token', null);
                    header('location:' . ROOT_PATH . 'login\\');
                }


            } else {
                header('location:' . ROOT_PATH . 'login\\');
            }
        } else {
            header('location:' . ROOT_PATH . 'login\\');
        }
    }

    public function setPassword($token, $password, $created_at): array
    {
        $model = new User();
        $existeEmail = $model->existe('token', '=', $token, null, 1);
        if ($existeEmail) {

            $id = $existeEmail['id'];
            $model->update($id, 'password', $password);
            $model->update($id, 'token', null);
            $model->update($id, 'date_token', null);
            $model->update($id, 'updated_at', $created_at);

            $response = crearResponse(
                null,
                true,
                'Contraseña Actualizada.',
                'Su contraseña se ha restablecido correctamente. Inicie sesión con su nueva clave.',
                'success',
                true
            );


        } else {
            $response = crearResponse(
                'email_duplicado',
                false,
                'Token no encontrado.',
                'El token se encuentra vencido.',
                'warning',
                true
            );
        }
        return $response;
    }

    public function register($name, $email, $password, $telefono, $created_at): array
    {
        $model = new User();
        $existeEmail = $model->existe('email', '=', $email, null, 1);
        if (!$existeEmail) {

            $data = [
                $name,
                $email,
                $password,
                $telefono,
                0,
                $created_at
            ];

            $model->save($data);

            $user = $model->first('email', '=', $email);
            $_SESSION['id'] = $user['id'];
            $response = crearResponse(
                null,
                true,
                "Bienvenido " . $name,
                "Bienvenido " . $name
            );
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

    public function forgotPassword($email): array
    {
        $model = new User();
        $existeEmail = $model->existe('email', '=', $email);
        if ($existeEmail) {

            $token = generar_string_aleatorio(50);
            $email_url = str_replace('@', '%40', $email);
            $url = public_path('recover/') . '?token=' . $token . '&email=' . $email_url . '';
            $hoy = date("Y-m-d H:i:s");

            //definir variables
            $asunto = verUtf8('Reestablecimiento de Clave');
            $html = '
            


<html lang="es">
                <head>
            
                </head>
            
                <body>
                   
  
  <div style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;;font-size:14px;line-height:1.5;color:#24292e;background-color:#fff;margin:0" bgcolor="#fff">
    <table align="center" width="100%" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;max-width:544px;margin-right:auto;margin-left:auto;width:100%!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
        <td align="center" valign="top" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:16px">
          <center style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
            <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;max-width:768px;margin-right:auto;margin-left:auto;width:100%!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">
              <table style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      <td height="16" style="font-size:16px;line-height:16px;box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">&nbsp;</td>
    </tr>
  </tbody>
</table>

              <table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
                <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
                  <td style="box-sizing:border-box;text-align:center!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0" align="center">
                    <img src="https://i.ibb.co/LJtwzzs/alguarisa-logo-original-transparete.png" width="250" alt="alguarisa-logo-original-transparete" border="0"><h2 style="box-sizing:border-box;margin-top:8px!important;margin-bottom:0;font-size:24px;font-weight:400!important;line-height:1.25!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
                        ¿Olvidó su Contraseña?

                    </h2>
                  </td>
                </tr>
              </tbody></table>
              <table style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      <td height="16" style="font-size:16px;line-height:16px;box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">&nbsp;</td>
    </tr>
  </tbody>
</table>

</td>
  </tr>
</tbody>
</table>
            <table width="100%" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;width:100%!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
              <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
                <td style="box-sizing:border-box;border-radius:6px!important;display:block!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0;border:1px solid #e1e4e8">
                  <table align="center" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;width:100%!important;text-align:center!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
                    <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
                      <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:16px">
                        <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;width:100%!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">
                          

<h3 style="box-sizing:border-box;margin-top:0;margin-bottom:0;font-size:20px;font-weight:600;line-height:1.25!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">Restablecer Contraseña</h3>
<table style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      <td height="16" style="font-size:16px;line-height:16px;box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">&nbsp;</td>
    </tr>
  </tbody>
</table>



<table style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;width:100%!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      
  <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">
  <table style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      <td style="box-sizing:border-box;text-align:left!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0" align="left">
      <p style="box-sizing:border-box;margin-top:0;margin-bottom:10px;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">Estimado Usuario:</p>
      <p style="text-justify box-sizing:border-box;margin-top:0;margin-bottom:10px;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">Recientemente hemos recibido una solicitud para restablecer la contraseña de su cuenta. Si fue usted quien realizó esta solicitud, por favor haga clic en el siguiente enlace para establecer una nueva contraseña:</p>

    <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;width:100%!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">
      <table border="0" cellspacing="0" cellpadding="0" width="100%" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
        <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
          <td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">
              <a href="'.$url.'" rel="noopener noreferrer" style="background-color:#1f883d!important;box-sizing:border-box;color:#fff;text-decoration:none;display:inline-block;font-size:inherit;font-weight:500;line-height:1.5;white-space:nowrap;vertical-align:middle;border-radius:.5em;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:.75em 1.5em;border:1px solid #1f883d">Restablecer su Contraseña</a>
          </td>
        </tr>
      </tbody></table>
    </td>
  </tr>
</tbody></table>

</td>
  </tr>
</tbody></table>

    <table style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      <td height="16" style="font-size:16px;line-height:16px;box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">&nbsp;</td>
    </tr>
  </tbody>
</table>


      <p style="box-sizing:border-box;margin-top:0;margin-bottom:10px;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
		<strong>Importante:</strong> Si no solicitó este cambio, simplemente ignore este correo y su contraseña actual seguirá activa.
	  </p>

</td>
      <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0"></td>
    </tr>
  </tbody></table>
</td>

    </tr>
  </tbody>
</table>


</td>
  </tr>
</tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
            </tbody></table>


            <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;width:100%!important;text-align:center!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">
              <table style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      <td height="16" style="font-size:16px;line-height:16px;box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">&nbsp;</td>
    </tr>
  </tbody>
</table>

              <table style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      <td height="16" style="font-size:16px;line-height:16px;box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">&nbsp;</td>
    </tr>
  </tbody>
</table>

              <p style="box-sizing:border-box;margin-top:0;margin-bottom:10px;color:#6a737d!important;font-size:14px!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">  Para cualquier consulta o asistencia adicional, no dude ponerse en contacto con el Departamento de Tecnología y Sistemas de ALGUARISA.
</td>
  </tr>
</tbody></table>
            <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;width:100%!important;text-align:center!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody><tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">
  <table style="box-sizing:border-box;border-spacing:0;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
  <tbody style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
    <tr style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">
      <td height="16" style="font-size:16px;line-height:16px;box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important;padding:0">&nbsp;</td>
    </tr>
  </tbody>
</table>

  <p style="box-sizing:border-box;margin-top:0;margin-bottom:10px;color:#6a737d!important;font-size:12px!important;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;!important">Alimentos de Guárico S.A</p>
</td>
  </tr>
</tbody>
</table>

          </center>
        </td>
      </tr>
    </tbody></table><div class="yj6qo"></div><div class="adL">

   </div><div style="display:none;white-space:nowrap;box-sizing:border-box;font:15px/0 apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;" class="adL"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </div><div class="adL">
  </div></div><div class="adL">

</div></div><div class="WhmR8e" data-hash="0"></div></div></div><div class="ajx"></div></div>
                </body>
            </html>';
            $noHtml = 'Para restablecer su contraseña siga el siguiente enlace: ' . $url;

            //envio correo
            $mailer = new MailerController();
            $mailer->enviarEmail($email, $asunto, $html, $noHtml);

            $model->update($existeEmail['id'], 'token', $token);
            $model->update($existeEmail['id'], 'date_token', $hoy);

            $response = crearResponse(
                null,
                true,
                'Correo Enviado.',
                'Tu nueva contraseña se ha enviado a tu correo.'
            );

        } else {
            $response = crearResponse(
                'no_email',
                false,
                'Email NO encontrado.',
                'El Email NO se encuentra en nuestros registro.',
                'error',
                true
            );
        }
        return $response;
    }

}