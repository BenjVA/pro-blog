<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\UserRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class User
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addGlobal('session', $_SESSION);
    }

    /**Connect user and redirect to homepage
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function signUpAction(): void
    {
        if (count($_POST) > 0) {
            $signUpHomepage = new Homepage($this->twig);
            if (isset($_POST['pseudo'])
                && !empty($_POST['pseudo'])
                && isset($_POST['mail'])
                && !empty($_POST['mail'])
                && isset($_POST['password'])
                && !empty($_POST['password'])) {
                $pseudo = filter_input(INPUT_POST, 'pseudo',FILTER_SANITIZE_SPECIAL_CHARS);
                $mail = filter_input(INPUT_POST, 'mail',FILTER_SANITIZE_EMAIL);
                $password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_SPECIAL_CHARS);

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
            $signUpHomepage->showHomepage(
                $samePseudoMessage ?? null,
                $sameMailMessage ?? null,
                $validMessage ?? null,
                $userLogged ?? null,
                $loginSuccessful ?? null,
                $loginFailed ?? null,
                $logoutSuccessful ?? null
            );
        }
    }

    /**Show login page
     *
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function showLogin(): void
    {
        $this->twig->display('login.html.twig');
    }

    /**Show sign up page
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function showSignUp(): void
    {
        $this->twig->display('signUp.html.twig');
    }

    /**Log user and redirect to homepage
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function loginAction(): void
    {
        if (count($_POST) > 0) {
            $loginHomepage = new Homepage($this->twig);
            if (isset($_POST['mail']) && !empty($_POST['mail'])
                && isset($_POST['password']) && !empty($_POST['password'])) {
                $mail = filter_input(INPUT_POST, 'mail',FILTER_SANITIZE_EMAIL);
                $password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_SPECIAL_CHARS);

                $login = new UserRepository();
                $login->connection = new DatabaseConnection();
                $userLogged = $login->connectUser($mail, $password);


                if ($userLogged) {
                    $loginSuccessful = 'Connexion réussie';
                } else {
                    $loginFailed = 'Adresse mail ou mot de passe incorrect';
                }
            }
            $loginHomepage->showHomepage(
                $samePseudoMessage ?? null,
                $sameMailMessage ?? null,
                $validMessage ?? null,
                $userLogged ?? null,
                $loginSuccessful ?? null,
                $loginFailed ?? null,
                $logoutSuccessful ?? null
            );
        }
    }

    /**Disconnect user, destroy session and show homepage
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function logoutAction(): void
    {
        session_unset();
        session_destroy();
        $logoutSuccessful = 'Vous êtes bien déconnecté, à bientôt !';
        $logoutHomepage = new Homepage($this->twig);
        $logoutHomepage->showHomepage(
            $samePseudoMessage ?? null,
            $sameMailMessage ?? null,
            $validMessage ?? null,
            $userLogged ?? null,
            $loginSuccessful ?? null,
            $loginFailed ?? null,
            $logoutSuccessful
        );
    }

    /**Show admin panel
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function showAdminPanel(): void
    {
        $this->twig->display('adminLayout.html.twig');
    }

    /**Show users list in admin panel. Delete, deactivate or activate users
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
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

    /**Delete user and show users list in admin panel
     *
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function deleteUser(): void
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

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
    }

    /**Deactivate user and show users list in admin panel
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function deactivateUser(): void
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

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
    }

    /**Activate user and show users list in admin panel
     *
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function activateUser(): void
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

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
}
