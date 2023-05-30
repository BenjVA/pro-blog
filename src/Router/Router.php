<?php

declare(strict_types=1);

namespace App\Router;

use App\Controllers\Article;
use App\Controllers\Homepage;
use App\controllers\Articles;
use App\Controllers\NotFoundController;
use Twig\Environment;
use \Twig\Loader\FilesystemLoader;
use App\Controllers\User;

class Router
{
    public Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('src/template');
        $this->twig = new Environment($loader);
    }

    public function getController(array $parameters): void
    {
        if (isset($parameters['action']) && $parameters['action'] !== '') {
            match ($parameters['action']) {
                'articles' => $this->getArticlesController(),
                'article' => $this->getArticleController($_GET['id']),
                'sign-up' => $this->getUserController(),
                'add-user' => $this->getAddUserController(),
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

    private function getArticleController($id): void
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
            $userController->showSignUp();
    }

    private function getAddUserController(): void
    {
        if (isset($pseudo) && isset($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL) && isset($password)) {
            $addUserController = new User($this->twig);
            $addUserController->signUp();
        }
        else {
            $this->getNotFoundController();
        }
    }
}