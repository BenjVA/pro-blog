<?php

namespace App\Controllers;

use App\model\Article;

use App\model\ArticleRepository;
use App\model\DatabaseConnection;
use Twig\Environment;
use \Twig\Loader\FilesystemLoader;

class Homepage
{
    public function __construct(public Environment $twig)
    {

    }

    public function showHomepage(): void
    {
        $articleRepository = new ArticleRepository();
        $articleRepository->connection = new DatabaseConnection();
        $recentArticles = $articleRepository->getRecentArticles();

        $this->twig->display('homepage.html.twig', ['recentArticles' => $recentArticles]);
    }
}