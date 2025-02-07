<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;
    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //Crear el objeto de mail
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '5e41790701c75d';
            $mail->Password = '5eb8a48438634c';

            $mail->setFrom('cuentas@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
            $mail->Subject = 'Confirma tu cuenta';

            //SetHTML
            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>Has creado tu cuenta en appsalon, solo debes confirmarla presionando el siguiente enlace </p>";
            $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a> </p>";
            $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
            $contenido .= "</html>";
            $mail->Body = $contenido;

            //Enviar el mail
            $mail->send();
    }
}