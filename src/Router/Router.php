<?php

declare(strict_types=1);

namespace App\Router;

use App\Controllers\Comment;
use App\Controllers\Homepage;
use App\controllers\Articles;
use App\Controllers\Mail;
use App\Controllers\NotFoundController;
use PHPMailer\PHPMailer\Exception;
use Twig\Environment;
use \Twig\Loader\FilesystemLoader;
use App\Controllers\User;
use App\Controllers\Article;

class Router
{
    public Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('src/template');
        $this->twig = new Environment($loader, [
            'debug' => true,
        ]);
    }

    public function getController(array $parameters): void
    {
        if (isset($parameters['action']) && $parameters['action'] !== '') {
            match ($parameters['action']) {
                'articles' => $this->getArticlesController(),
                'article' => $this->getArticleController($_GET['id']),
                'sign-up' => $this->getUserController(),
                'login' => $this->getLoginController(),
                'logout' => $this->getLogoutController(),
                'addComment' => $this->getAddCommentController(),
                'showAdminPanel' => $this->getAdminPanelController(),
                'showWaitingCommentsList' => $this->getNotPublishedCommentsController(),
                'publishComment' => $this->getPublishCommentController(),
                'deleteComment' => $this->getDeleteCommentController(),
                'addArticle' => $this->getaddArticleController(),
                'showAddArticlePage' => $this->getShowAddArticlePage(),
                'showWaitingArticlesList' => $this->getNotPublishedArticleController(),
                'deleteArticle' => $this->getDeleteArticleController(),
                'publishArticle' => $this->getPublishArticleController(),
                'editArticle' => $this->getEditArticleController(),
                'showEditArticlePage' => $this->getShowEditArticlePageController($_GET['id']),
                'showUserList' => $this->getShowUserListController(),
                'deleteUser' => $this->getDeleteUserController(),
                'deactivateUser' => $this->getDeactivateUserController(),
                'activateUser' => $this->getActivateUserController(),
                'showLogin' => $this->getShowLoginController(),
                'showSignUp' => $this->getShowSignUpController(),
                'submitMail' => $this->getSubmitMailController(),
                default => $this->getNotFoundController(),
            };
        }
        else {
            (new Homepage($this->twig))->showHomepage(
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

    private function getArticlesController(): void
    {
        $articlesController = new Articles($this->twig);
        $articlesController->showPublishedArticles();
    }

    private function getArticleController(string $id): void
    {
        if ($id && $id > 0) {
            $articleController = new Article($this->twig);
            $articleController->showPublishedArticle(
            $id,
            $notAddedComment ?? null,
            $addedComment ?? null);
        }
        else {
            $this->getNotFoundController();
        }
    }

    private function getNotFoundController(): void
    {
        $notFoundController = new NotFoundController($this->twig);
        $notFoundController->showError();
    }

    private function getUserController(): void
    {
            $userController = new User($this->twig);
            $userController->signUpAction();
    }

    private function getLoginController(): void
    {
        $loginController = new User($this->twig);
        $loginController->loginAction();
    }

    private function getLogoutController(): void
    {
        $logoutController = new User($this->twig);
        $logoutController->logoutAction();
    }

    private function getAddCommentController(): void
    {
        $commentController = new Comment($this->twig);
        $commentController->addComment();
    }

    private function getNotPublishedCommentsController(): void
    {
        $notPublishedCommentsController = new Comment($this->twig);
        $notPublishedCommentsController->showNotPublishedComments(
            $publishedComment ?? null,
            $errorPublishComment ?? null,
            $deletedComment ?? null,
            $errorDeleteComment ?? null
        );
    }

    private function getAdminPanelController(): void
    {
        $adminPanelController = new User($this->twig);
        $adminPanelController->showAdminPanel();
    }

    private function getPublishCommentController(): void
    {
        $publishCommentController = new Comment($this->twig);
        $publishCommentController->publishComment();
    }

    private function getDeleteCommentController(): void
    {
        $deleteCommentController = new Comment($this->twig);
        $deleteCommentController->deleteComment();
    }

    private function getAddArticleController(): void
    {
        $addArticleController = new Article($this->twig);
        $addArticleController->addArticle();
    }

    private function getShowAddArticlePage(): void
    {
        $showAddArticlePage = new Article($this->twig);
        $showAddArticlePage->showAddArticlePage($successAddArticle ?? null);
    }

    private function getNotPublishedArticleController(): void
    {
        $notPublishArticleController = new Article($this->twig);
        $notPublishArticleController->showNotPublishedArticles(
            $deletedArticle ?? null,
            $errorDeleteArticle ?? null,
            $publishedArticle ?? null,
            $errorPublishArticle ?? null);
    }

    private function getDeleteArticleController(): void
    {
        $deleteArticleController = new Article($this->twig);
        $deleteArticleController->deleteArticle(
            $deletedArticle ?? null,
            $errorDeleteArticle ?? null,
            $publishedArticle ?? null,
            $errorPublishArticle ?? null);
    }

    private function getPublishArticleController(): void
    {
        $publishArticleController = new Article($this->twig);
        $publishArticleController->publishArticle(
            $deletedArticle ?? null,
            $errorDeleteArticle ?? null,
            $publishedArticle ?? null,
            $errorPublishArticle ?? null);
    }

    private function getEditArticleController(): void
    {
        $editArticleController = new Article($this->twig);
        $editArticleController->editArticle();
    }

    private function getShowEditArticlePageController($id): void
    {
        $showEditArticlePageController = new Article($this->twig);
        $showEditArticlePageController->showEditArticlePage(
            $id,
            $editedArticle ?? null,
            $notEditedArticle ?? null
        );
    }

    private function getShowUserListController(): void
    {
        $showUserListController = new User($this->twig);
        $showUserListController->showUserList($deletedUser ?? null,
            $errorDeleteUser ?? null,
            $deactivatedUser ?? null,
            $errorDeactivateUser ?? null,
            $activatedUser ?? null,
            $errorActivateUser ?? null
        );
    }

    private function getDeleteUserController(): void
    {
        $deleteUserController = new User($this->twig);
        $deleteUserController->deleteUser();
    }

    private function getDeactivateUserController(): void
    {
        $deactivateUserController = new User($this->twig);
        $deactivateUserController->deactivateUser();
    }

    private function getActivateUserController(): void
    {
        $activateUserController = new User($this->twig);
        $activateUserController->activateUser();
    }

    private function getShowLoginController(): void
    {
        $showLoginController = new User($this->twig);
        $showLoginController->showLogin();
    }

    private function getShowSignUpController(): void
    {
        $showSignUpController = new User($this->twig);
        $showSignUpController->showSignUp();
    }

    /** Error Submit mail controller
     * @throws Exception
     */
    private function getSubmitMailController(): void
    {
        $submitMailController = new Mail($this->twig);
        $submitMailController->submit();
    }
}