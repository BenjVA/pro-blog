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
use \Twig\Extension;

class Router
{
    public Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('src/template');
        $twig = new Environment($loader, [
            'debug' => true,
        ]);
        $twig->addExtension(new Extension\DebugExtension());
        $this->twig = new Environment($loader);
    }

    public function getController(array $parameters): void
    {
        if (isset($parameters['action']) && $parameters['action'] !== '') {
            match ($parameters['action']) {
                'articles' => $this->getArticlesController(),
                'article' => $this->getArticleController($_GET['id']),
                'sign-up' => $this->getUserController(),
                default => $this->getNotFoundController(),
            };
        }
        else {
            (new Homepage($this->twig))->showHomepage();
        }
    }

    public function getArticlesController(): void
    {
        $articlesController = new Articles($this->twig);
        $articlesController->showArticles();
    }

    public function getArticleController($id): void
    {
        if ($id && $id > 0) {
            $articleController = new Article($this->twig);
            $articleController->showArticle($id);
        }
        else {
            $this->getNotFoundController();
        }
    }

    public function getNotFoundController(): void
    {
        $notFoundController = new NotFoundController($this->twig);
        $notFoundController->showError();
    }

    public function getUserController(): void
    {
            $userController = new User($this->twig);
            $userController->signUpAction();
    }
}