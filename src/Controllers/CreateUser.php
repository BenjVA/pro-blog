<?php

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Model\ShowSignUp;
use Twig\Environment;
use App\Model\SignUp;
class CreateUser
{
    public function __construct(public Environment $twig)
    {

    }

    public function signUp(): void
    {
        $pseudo = $_POST['pseudo'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        $signUp = new SignUp();
        $signUp->connection = new DatabaseConnection();
        $newUser = $signUp->addUser($pseudo, $mail, $password);

        
        $this->twig->display('signUp.html.twig', ['register']);

    }

    public function showSignUp(): void
    {

    }
}