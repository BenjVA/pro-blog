<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private string $surname;
    private string $name;
    private string $mail;
    private string $message;
    private bool $success = true;

    public function __construct($name, $surname, $mail, $message)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->mail = $mail;
        $this->message = $message;
        $this->send();
    }

    /**Use PHP mailer to send email
     * @throws Exception
     */
    public function send(): void
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'localhost';
        $mail->Port =
        $mail->SMTPAuth = true;
        $mail->Username = 'ben.valette@live.fr';
        $mail->Password = '';
        $mail->addAddress('ben.valette@live.fr');
        $mail->CharSet = 'UTF-8';
        $mail->smtpConnect();
        $mail->From = 'ben.valette@live.fr';
        $mail->Subject = 'Nouveau message de ' . $this->name . ' ' . $this->surname;
        $mail->WordWrap = 78;
        $mail->MsgHTML('Nom :' . $this->name . '</br>
								Prénom :' . $this->surname . '</br>
								Mail :' . $this->mail . '</br>
								Message :' . $this->message . '</br>');

        if (!$mail->send()) $this->success = $mail->ErrorInfo;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }
}