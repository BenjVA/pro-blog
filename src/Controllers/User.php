<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\UserRepository;

class User extends Homepage
{
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
        $this->showHomepage(
            $samePseudoMessage ?? null,
            $sameMailMessage ?? null,
            $validMessage ?? null,
            $userLogged ?? null,
            $loginSuccessful ?? null,
            $loginFailed ?? null,
            $logoutSuccessful ?? null
        );
    }

    public function showLogin(): void
    {
        $this->twig->display('login.html.twig');
    }

    public function showSignUp(): void
    {
        $this->twig->display('signUp.html.twig');
    }

    public function loginAction(): void
    {
        if (count($_POST) > 0) {
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            $login = new UserRepository();
            $login->connection = new DatabaseConnection();
            $userLogged = $login->connectUser($mail, $password);

            if ($userLogged) {
                $loginSuccessful = 'Connexion réussie';
            } else {
                $loginFailed = 'Adresse mail ou mot de passe incorrect';
            }
        }
        $this->showHomepage(
            $samePseudoMessage ?? null,
            $sameMailMessage ?? null,
            $validMessage ?? null,
            $userLogged ?? null,
            $loginSuccessful ?? null,
            $loginFailed ?? null,
            $logoutSuccessful ?? null
        );
    }

    public function logoutAction(): void
    {
        session_unset();
        session_destroy();
        $logoutSuccessful = 'Vous êtes bien déconnecté, à bientôt !';
        $this->showHomepage(
            $samePseudoMessage ?? null,
            $sameMailMessage ?? null,
            $validMessage ?? null,
            $userLogged ?? null,
            $loginSuccessful ?? null,
            $loginFailed ?? null,
            $logoutSuccessful
        );
    }

    public function showAdminPanel(): void
    {
        $this->twig->display('adminLayout.html.twig');
    }

    public function showUserList(?string $deletedUser,
                                 ?string $errorDeleteUser,
                                 ?string $deactivatedUser,
                                 ?string $errorDeactivateUser,
                                 ?string $activatedUser,
                                 ?string $errorActivateUser): void
    {
        $showUserList = new UserRepository();
        $showUserList->connection = new DatabaseConnection();
        $userList = $showUserList->getUsers();

        $this->twig->display('userList.html.twig', [
            'userList' => $userList,
            'deletedUser' => $deletedUser ?? null,
            'errorDeleteUser' => $errorDeleteUser ?? null,
            'deactivatedUser' => $deactivatedUser ?? null,
            'errorDeactivateUser' => $errorDeactivateUser ?? null,
            'activatedUser' => $activatedUser ?? null,
            'errorActivateUser' => $errorActivateUser ?? null
        ]);
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

        $this->showUserList(
            $deletedUser ?? null,
            $errorDeleteUser ?? null,
            $deactivatedUser ?? null,
            $errorDeactivateUser ?? null,
            $activatedUser ?? null,
            $errorActivateUser ?? null
        );
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

        $this->showUserList($deletedUser ?? null,
            $errorDeleteUser ?? null,
            $deactivatedUser ?? null,
            $errorDeactivateUser ?? null,
            $activatedUser ?? null,
            $errorActivateUser ?? null
        );
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

        $this->showUserList($deletedUser ?? null,
            $errorDeleteUser ?? null,
            $deactivatedUser ?? null,
            $errorDeactivateUser ?? null,
            $activatedUser ?? null,
            $errorActivateUser ?? null
        );
    }
}