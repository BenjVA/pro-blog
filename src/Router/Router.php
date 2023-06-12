<?php

declare(strict_types=1);

namespace App\Router;

use App\Controllers\Homepage;
use App\controllers\Articles;
use App\Controllers\NotFoundController;
use App\Session;
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
                default => $this->getNotFoundController(),
            };
        }
        else {
            (new Homepage($this->twig))->showHomepage();
        }
    }

    private function getArticlesController(): void
    {
        $articlesController = new Articles($this->twig);
        $articlesController->showArticles();
    }

    private function getArticleController(string $id): void
    {
        if ($id && $id > 0) {
            $articleController = new Article($this->twig);
            $articleController->showArticle($id);
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
        $commentController = new Article($this->twig);
        $commentController->addComment();
    }
}