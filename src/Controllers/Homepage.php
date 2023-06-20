<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\ArticleRepository;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use PHPMailer\PHPMailer\PHPMailer;

class Homepage
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function showHomepage(): void
    {
        $articleRepository = new ArticleRepository();
        $articleRepository->connection = new DatabaseConnection();
        $recentArticles = $articleRepository->getRecentPublishedArticles();

        $this->twig->display('homepage.html.twig', ['recentArticles' => $recentArticles,
            'user' => $user ?? null
        ]);
    }
}