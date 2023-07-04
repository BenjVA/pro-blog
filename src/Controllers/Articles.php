<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\ArticleRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Articles
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addGlobal('session', $_SESSION);
    }

    /**Show list of all published articles
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function showPublishedArticles(): void
    {
        $articleRepository = new ArticleRepository();
        $articleRepository->connection = new DatabaseConnection();
        $articles = $articleRepository->getPublishedArticles();

        $this->twig->display('articles.html.twig', ['articles' => $articles]);
    }
}
