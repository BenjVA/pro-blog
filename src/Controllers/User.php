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

    public function signUp(): void
    {
        if (count($_POST) > 0) {
            $pseudo = $_POST['pseudo'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            $signUp = new UserRepository();
            $signUp->connection = new DatabaseConnection();
            if ($signUp->getUser($mail) instanceof \App\Model\User) {
                $this->twig->display('signUp.html.twig', ['errorMessage' => 'L\'adresse mail existe déjà']);
            }

            $signUp->addUser($pseudo, $mail, $password);
        }
        $this->twig->display('signUp.html.twig', ['validMessage' => 'Vous avez bien été enregistré !']);
    }
}