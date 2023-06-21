<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Extension\DebugExtension;

class Mail
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }
    public function submit(): void
    {
        $mail = new \App\Service\Mail(filter_input(INPUT_POST, 'name'),
            filter_input(INPUT_POST, 'surname'),
            filter_input(INPUT_POST, 'mail'),
            filter_input(INPUT_POST, 'message'));

        if (!$mail->isSuccess()) {
            $failedMail = 'Echec de l\'envoi du mail';
        } else {
            echo $this->twig->display('home.twig', ['message' => $mail->isSuccess()]);
        }
    }
}