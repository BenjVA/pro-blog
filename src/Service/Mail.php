<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
    private string $name;
    private string $surname;
    private string $userMail;
    private string $message;
    private bool $successMessage = true;


    public function __construct(string $name, string $surname, string $userMail, string $message)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->userMail = $userMail;
        $this->message = $message;
    }

    /** Error send mail method
     * @throws Exception
     */
    public function send(): bool
    {
        //Create a new PHPMailer instance
        $mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        //SMTP::DEBUG_OFF = off (for production use)
        //SMTP::DEBUG_CLIENT = client messages
        //SMTP::DEBUG_SERVER = client and server messages
        $mail->SMTPDebug = SMTP::DEBUG_OFF;

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
        //if your network does not support SMTP over IPv6,
        //though this may cause issues with TLS

        //Set the SMTP port number:
        // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
        // - 587 for SMTP+STARTTLS
        $mail->Port = 465;

        //Set the encryption mechanism to use:
        // - SMTPS (implicit TLS on port 465) or
        // - STARTTLS (explicit TLS on port 587)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = 'benvalette539@gmail.com';

        //Password to use for SMTP authentication
        $mail->Password = 'inlkjspfwrytqjrc';

        //Set who the message is to be sent from
        //Note that with gmail you can only use your account address (same as `Username`)
        //or predefined aliases that you have configured within your account.
        //Do not use user-submitted addresses in here
        $mail->setFrom('benvalette539@gmail.com', 'Benjamin Valette');

        //Set an alternative reply-to address
        //This is a good place to put user-submitted addresses
        $mail->addReplyTo($this->userMail, $this->name);

        //Set who the message is to be sent to
        $mail->addAddress('ben.valette@live.fr', 'Ben');

        $mail->CharSet = 'UTF-8';
        $mail->WordWrap = 75;

        //Set the subject line
        $mail->Subject = 'Mail from contact form homepage';

        $mail->Body = <<<EOT
                        'Email:' . $this->userMail
                        'Nom:' . $this->name
                        'Prénom:' $this->surname
                        'Message:' $this->message
                        EOT;

        if (!$mail->send()) {
            return $this->successMessage = false;
        }
        return $this->successMessage;
    }
}
