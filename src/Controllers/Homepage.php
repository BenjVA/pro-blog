<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\ArticleRepository;
use App\Model\DatabaseConnection;
use Twig\Environment;

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