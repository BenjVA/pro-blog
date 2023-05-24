<?php

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Model\SignUp;
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

            $signUp = new SignUp();
            $signUp->connection = new DatabaseConnection();
            $userRepository = new UserRepository();
            if ($userRepository->getUser($mail) instanceof \App\Model\User) {
                $this->twig->display('signUp.html.twig', ['errorMessage' => 'L\'adresse mail existe déjà']);
            }
            $newUser = $signUp->addUser($pseudo, $mail, $password);
        }

        $this->twig->display('signUp.html.twig');
    }
}