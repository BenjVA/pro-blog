<?php

namespace App\Controllers;

use App\model\Article;
use \Twig\Loader\FilesystemLoader;

class Homepage
{
    public function __construct(public $twig)
    {

    }
    public function showAction()
    {
        return $this->twig->render('homepage.html.twig');
    }
}