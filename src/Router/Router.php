<?php

namespace App\Router;

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
        if (isset($parameters["action"]) && $parameters["action"] !== "")
        {
            return "action is set";
        }
        return (new Homepage($this->twig));
    }
}