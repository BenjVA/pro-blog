<?php

namespace App\Router;

use App\Controllers\article;
use App\Controllers\Homepage;
use App\controllers\Articles;
use App\Controllers\NotFoundController;
use Twig\Environment;
use \Twig\Loader\FilesystemLoader;

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
}