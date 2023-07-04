<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\Exception;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Mail
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addGlobal('session', $_SESSION);
    }

    /**Show homepage with notification if mail sent correctly
     *
     * @throws Exception
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function submit(): void
    {
        $mail = new \App\Service\Mail(filter_input(INPUT_POST, 'name'),
            filter_input(INPUT_POST, 'surname'),
            filter_input(INPUT_POST, 'mail'),
            filter_input(INPUT_POST, 'message'));

        if ($mail->send() === true) {
            $this->twig->display('homepage.html.twig', ['successMessage' => 'Le message a bien été envoyé !']);
        } else {
            $this->twig->display('notFound.html.twig', ['failedMessage' => 'Le message n\'a pas pu être envoyé']);
        }
    }
}
