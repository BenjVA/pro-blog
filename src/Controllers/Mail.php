<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\Exception;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class Mail
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }
    
    /**
     * @throws Exception
     */
    public function submit(): void
    {
        $mail = new \App\Service\Mail(filter_input(INPUT_POST, 'name'),
            filter_input(INPUT_POST, 'surname'),
            filter_input(INPUT_POST, 'mail'),
            filter_input(INPUT_POST, 'message'));

        //send the message, check for errors
        if (!$mail->send()) {
            $failedMessage = 'Erreur dans l\'envoi du message';
        } else {
            $successMessage = 'Message envoyé !';
        }
        $this->twig->display('homepage.html.twig', [
            'failedMessage' => $failedMessage ?? null,
            'successMessage' => $successMessage ?? null
        ]);
    }
}