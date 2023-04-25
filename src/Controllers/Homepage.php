<?php

namespace App\Controllers;

use App\model\Article;
use \Twig\Loader\FilesystemLoader;

class Homepage
{
    public function __construct(public $twig)
    {

    }
    public function showHomepage()
    {
        return $this->twig->display('homepage.html.twig');
    }
}