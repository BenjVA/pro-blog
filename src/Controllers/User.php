<?php

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\UserRepository;
use Twig\Environment;

class User
{
    public function __construct(public Environment $twig)
    {

    }

    public function signUpAction(): void
    {
        if (count($_POST) > 0) {
            $pseudo = $_POST['pseudo'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            $signUp = new UserRepository();
            $signUp->connection = new DatabaseConnection();

            if ($signUp->getUserPseudo($pseudo) instanceof \App\Model\User) {
                $samePseudoMessage = 'Le pseudo existe déjà';
            }
            elseif ($signUp->getUserMail($mail) instanceof \App\Model\User) {
                $sameMailMessage = 'L\'adresse mail existe déjà';
            }
            else {
                $signUp->addUser($pseudo, $mail, $password);
                $validMessage = 'Vous avez bien été enregistré !';
            }
        }
        $this->twig->display('signUp.html.Twig', [
            'samePseudoMessage' => $samePseudoMessage ?? null,
            'sameMailMessage' => $sameMailMessage ?? null,
            'validMessage' => $validMessage ?? null
        ]);
    }
}