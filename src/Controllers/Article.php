<?php

namespace App\Controllers;

use App\model\ArticleRepository;
use App\model\DatabaseConnection;
use Twig\Environment;

class Article
{
    public function __construct(public Environment $twig)
    {
        
    }

    public function showArticle($id)
    {
        $articleRepository = new ArticleRepository();
        $articleRepository->connection = new DatabaseConnection();
        $article = $articleRepository->getArticle($id);

        $this->twig->display('article.html.twig', ['article' => $article]);
    }
}