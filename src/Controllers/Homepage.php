<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\ArticleRepository;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class Homepage
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function showHomepage(
        ?string $samePseudoMessage,
        ?string $sameMailMessage,
        ?string $validMessage,
        ?string $userLogged,
        ?string $loginSuccessful,
        ?string $loginFailed,
        ?string $logoutSuccessful
    ): void
    {
        $articleRepository = new ArticleRepository();
        $articleRepository->connection = new DatabaseConnection();
        $recentArticles = $articleRepository->getRecentPublishedArticles();

        $this->twig->display('homepage.html.twig', [
            'recentArticles' => $recentArticles,
            'user' => $user ?? null,
            'samePseudoMessage' => $samePseudoMessage ?? null,
            'sameMailMessage' => $sameMailMessage ?? null,
            'validMessage' => $validMessage ?? null,
            'userLogged' => $userLogged ?? null,
            'loginSuccessful' => $loginSuccessful ?? null,
            'loginFailed' => $loginFailed ?? null,
            'logoutSuccessful' => $logoutSuccessful ?? null
        ]);
    }
}