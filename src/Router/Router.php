<?php

namespace App\Router;

use App\Controllers\article;
use App\Controllers\Homepage;
use App\controllers\Articles;
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
    public function getController(array $parameters)
    {
        if (isset($parameters['action']) && $parameters['action'] !== '') {
            match ($parameters['action']) {
                'articles' => (new Articles($this->twig))->showArticles(),
                default => 'error 404',
            };

        if (isset($parameters['id']) && $parameters['id'] >0)
            match ($parameters['id']) {
            'id' => (new article($this->twig))->showArticle(),
                default => 'error 404',
            };
        }
        (new Homepage($this->twig))->showHomepage();
    }
}