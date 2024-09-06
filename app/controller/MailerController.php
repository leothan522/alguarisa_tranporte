<?php
namespace app\controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailerController
{
    /**
     * @throws Exception
     */
    public function enviarEmail($email, $asunto, $mensaje, $noHTML): void
    {
        // Al pasar true habilitamos las excepciones
        $mail = new PHPMailer(true);
        // Ajustes del Servidor
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Comenta esto antes de producción
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = MAIL_PORT;

        // Destinatario
        $mail->setFrom(MAIL_FROM_ADDRESS, APP_NAME);
        $mail->addAddress($email);

        // Mensaje
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
        $mail->AltBody = $noHTML;

        $mail->send();
        //echo 'Se envio el mensaje';
    }
}