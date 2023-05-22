<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use Twig\Environment;
use App\Model\ArticleRepository;

class Articles
{
    public function __construct(public Environment $twig)
    {

    }

    public function showArticles(): void
    {
        $articleRepository = new ArticleRepository();
        $articleRepository->connection = new DatabaseConnection();
        $articles = $articleRepository->getArticles();

        $this->twig->display('articles.html.twig', ['articles' => $articles]);
    }
}