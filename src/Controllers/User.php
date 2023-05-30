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

    public function showSignUp(): void
    {
        $this->twig->display('signUp.html.Twig');
    }
    public function signUp(): void
    {
        if (count($_POST) > 0) {
            $pseudo = $_POST['pseudo'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            $signUp = new UserRepository();
            $signUp->connection = new DatabaseConnection();
            $success = $signUp->addUser($pseudo, $mail, $password);
            if ($success === false) {
                $this->twig->display('signUp.html.twig', ['errorMessage' => 'L\'adresse mail existe déjà']);
            }
        }
        $this->twig->display('signUp.html.twig', ['validMessage' => 'Vous avez bien été enregistré !']);
    }
}