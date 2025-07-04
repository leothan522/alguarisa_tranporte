<?php
session_start();
require "../vendor/autoload.php";
use app\controller\GuestController;
$controller = new GuestController();
$controller->index();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ing. Yonathan Castillo">
    <meta name="generator" content="leothan 0.1">

    <title><?php echo APP_NAME ?> | Inicia sesión</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php asset('public\\favicon\\apple-icon-57x57.png') ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php asset('public\\favicon\\apple-icon-60x60.png') ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php asset('public\\favicon\\apple-icon-72x72.png') ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php asset('public\\favicon\\apple-icon-76x76.png') ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php asset('public\\favicon\\apple-icon-114x114.png') ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php asset('public\\favicon\\apple-icon-120x120.png') ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php asset('public\\favicon\\apple-icon-144x144.png') ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php asset('public\\favicon\\apple-icon-152x152.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php asset('public\\favicon\\apple-icon-180x180.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php asset('public\\favicon\\android-icon-192x192.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php asset('public\\favicon\\android-icon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php asset('public\\favicon\\android-icon-96x96.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php asset('public\\favicon\\favicon-16x16.png') ?>">
    <link rel="manifest" href="<?php asset('public\\favicon\\manifest.json') ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php asset('public\\favicon\\ms-icon-144x144.png') ?>">
    <meta name="theme-color" content="#ffffff">

    <!--Bootstrap -->
    <link href="<?php asset('public/vendor/bootstrap-5.3.3/css/bootstrap.css'); ?>" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap" rel="stylesheet">

    <style>

        @media (min-width: 768px) {
            #scale {
                transform: scale(0.8); /* Reduce el tamaño al 80% */
            }
        }

        *{
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .text_title{
            color: rgba(8,23,44,1);
            font-weight: bold;
        }


        .gradient-custom-2 {
            /* fallback for old browsers */
            background: rgb(18,58,108);

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-radial-gradient(circle, rgba(18,58,108,1) 0%, rgba(8,23,44,1) 100%);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: radial-gradient(circle, rgba(18,58,108,1) 0%, rgba(8,23,44,1) 100%);
        }

        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }
        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }


        .gobernacion{
            display: block;
            position: absolute;
            height: 100px;
            width: 100px;
            right: 3%;
            top: 3%;
        }

        .gobernacion_start{
            display: block;
            position: absolute;
            height: 100px;
            width: 100px;
            left: 3%;
            top: 3%;
        }


    </style>

    <style>
        /* styles.css */
        #preloader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: #fff no-repeat center center;
            z-index: 9999;
        }

        #preloader::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
            background: url("<?php asset('public/img/logo_alguarisa.png') ?>") no-repeat center center;
            background-size: contain;
            transform: translate(-50%, -50%);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
            }
            50% {
                transform: translate(-50%, -50%) scale(1.2);
            }
            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

    </style>
    <script type="application/javascript">
        //Script para ejecurar el preloader
        window.addEventListener('load', function() {
            document.querySelector('#preloader').style.display = 'none';
            document.querySelector('.container').style.display = 'block';
        });
    </script>

</head>
<body style="background-color: #eee;">

<div id="preloader"></div>

<div class="position-relative gradient-form" style="min-height: 100vh;">
    <div class="position-absolute top-50 start-50 translate-middle container">


        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <img class="gobernacion_start d-lg-none" src="<?php asset('public/img/logo_gobernacion.png') ?>" alt="Logo Gobernación Guárico">

                                <div class="text-center">
                                    <a href="<?php echo APP_DOMINIO; ?>">
                                        <img class="img-fluid mt-5" src="<?php asset('public/img/logo_alguarisa.png') ?>" alt="Logo Alguarisa">
                                    </a>
                                    <h6 class="mt-1 mb-4 pb-1 text_title"><strong>Dirección de Tecnología y Sistemas.</strong></h6>
                                </div>

                                <form class="position-relative" id="form_login"  novalidate>
                                    <div class="row gy-3 overflow-hidden">
                                        <div class="col-12">
                                            <div class="form-floating mb-2 has-validation">
                                                <input id="email" type="email" class="form-control" name="email"  placeholder="name@example.com" required>
                                                <label for="email" class="form-label">Correo electrónico</label>
                                                <div class="invalid-feedback" id="error_email">
                                                    Por favor ingrese su Correo electrónico.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-2 has-validation">
                                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                                                <label for="password" class="form-label">Contraseña</label>
                                                <div class="invalid-feedback" id="error_password">
                                                    Por favor ingrese su Contraseña.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-grid">
                                                <input type="hidden" name="opcion" value="login">
                                                <button class="btn btn-dark btn-lg gradient-custom-2" type="submit">
                                                    Iniciar sesión
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-absolute top-50 start-50 translate-middle d-none verCargando">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </form>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                                            <?php if (env('APP_REGISTER', false)){ ?>
                                                <a href="../register" class="link-secondary text-decoration-none">
                                                    Registrarse
                                                </a>
                                            <?php } ?>
                                            <a href="../forgot-password" class="link-secondary text-decoration-none">
                                                ¿Olvidó su contraseña?
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-flex align-items-center gradient-custom-2" style="min-height: 70vh">
                            <img class="gobernacion" src="<?php asset('public/img/logo_gobernacion_white.png') ?>" alt="Logo Gobernación Guárico">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <img class="img-fluid rounded-2 border border-light" src="<?php asset('public/img/logo_tecnologia.png') ?>" alt="Logo Tecnología Alguarisa">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- Toast Bootstrap con JS -->
<div id="toastBootstrap">
    <!-- JS -->
</div>

<script src="<?php asset('public/vendor/bootstrap-5.3.3/js/bootstrap.bundle.js'); ?>"></script>
<script src="<?php asset('public/js/toastBootstrap.js', true); ?>"></script>
<script src="<?php asset('login/_app/app.js', true); ?>"></script>
<script type="application/javascript">

    const form = document.querySelector('#form_login');
    const email = document.querySelector('#email');
    const password = document.querySelector('#password');
    const error_email = document.querySelector('#error_email');
    const error_password = document.querySelector('#error_password');

    form.addEventListener('submit', event => {
        event.preventDefault();
        event.stopPropagation();
        form.classList.add('was-validated');
        if (form.checkValidity()) {
            verCargando('form_login');
            const url = "_request/LoginRequest.php";
            ajaxRequest({ url: url, form: form }, function (data) {
                if (data.result){
                    window.location.replace("../admin/");
                }else {
                    form.classList.remove('was-validated');
                    email.classList.remove('is-invalid');
                    password.classList.remove('is-invalid');

                    if (data.error === "no_email"){
                        email.classList.add('is-invalid');
                        error_email.textContent = data.message;
                    }

                    if (data.error === "no_password"){
                        password.classList.add('is-invalid');
                        error_password.textContent = data.message;
                    }

                    if (data.error === "no_activo"){
                        email.classList.add('is-invalid');
                        error_email.textContent = data.message;
                    }

                    verCargando('form_login', false);
                }
            });
        }
    });

    console.log('Hi!');
</script>
</body>
</html>
