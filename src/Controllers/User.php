<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\UserRepository;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class User
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
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
            } elseif ($signUp->getUserMail($mail) instanceof \App\Model\User) {
                $sameMailMessage = 'L\'adresse mail existe déjà';
            } else {
                $signUp->addUser($pseudo, $mail, $password);
                $validMessage = 'Vous avez bien été enregistré !';
            }
        }
        $this->twig->display('signUp.html.twig', [
            'samePseudoMessage' => $samePseudoMessage ?? null,
            'sameMailMessage' => $sameMailMessage ?? null,
            'validMessage' => $validMessage ?? null
        ]);
    }

    public function loginAction(): void
    {
        if (count($_POST) > 0) {
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            $login = new UserRepository();
            $login->connection = new DatabaseConnection();
            $user = $login->connectUser($mail, $password);

            if ($user) {
                $loginSuccessful = 'Connexion réussie';
            } else {
                $loginFailed = 'Adresse mail ou mot de passe incorrect';
            }
        }
        $this->twig->display('login.html.twig', [
        'loginSuccessful' => $loginSuccessful ?? null,
        'user' => $user ?? null,
        'loginFailed' => $loginFailed ?? null
        ]);
    }

    public function logoutAction(): void
    {
        session_unset();
        session_destroy();
        $this->twig->display('homepage.html.twig', [
            'logoutSuccessful' => 'Vous êtes bien déconnecté, à bientôt !'
        ]);
    }

    public function showAdminPanel(): void
    {
        $this->twig->display('adminLayout.html.twig');
    }

    public function showUserList(): void
    {
        $showUserList = new UserRepository();
        $showUserList->connection = new DatabaseConnection();
        $userList = $showUserList->getUsers();

        $this->twig->display('userList.html.twig', ['userList' => $userList]);
    }

    public function deleteUser(): void
    {
        $id = $_GET['id'];

        $deleteUser = new UserRepository();
        $deleteUser->connection = new DatabaseConnection();
        $deleteUsers = $deleteUser->deleteUser($id);

        if ($deleteUsers) {
            $deletedUser = 'Utilisateur supprimé !';
        } else {
            $errorDeleteUser = 'Utilisateur non supprimé';
        }

        $this->twig->display('userList.html.twig', [
            'deletedUser' => $deletedUser ?? null,
            'errorDeleteUser' => $errorDeleteUser ?? null
        ]);
    }

    public function deactivateUser(): void
    {
        $id = $_GET['id'];

        $deactivateUser = new UserRepository();
        $deactivateUser->connection = new DatabaseConnection();
        $deactivateUsers = $deactivateUser->deactivateUser($id);

        if ($deactivateUsers) {
            $deactivatedUser = 'Utilisateur désactivé !';
        } else {
            $errorDeactivateUser = 'Utilisateur non désactivé';
        }

        $this->twig->display('userList.html.twig', [
            'deactivatedUser' => $deactivatedUser ?? null,
            'errorDeactivateUser' => $errorDeactivateUser ?? null
        ]);
    }

    public function activateUser(): void
    {
        $id = $_GET['id'];

        $activateUser = new UserRepository();
        $activateUser->connection = new DatabaseConnection();
        $activateUsers = $activateUser->activateUser($id);

        if ($activateUsers) {
            $activatedUser = 'Utilisateur activé !';
        } else {
            $errorActivateUser = 'Utilisateur non activé';
        }

        $this->twig->display('userList.html.twig', [
            'activatedUser' => $activatedUser ?? null,
            'errorActivateUser' => $errorActivateUser ?? null
        ]);
    }
}