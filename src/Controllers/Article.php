<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class Article
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function showArticle(string $id): void
    {
        $articleRepository = new ArticleRepository();
        $commentRepository = new CommentRepository();
        $articleRepository->connection = new DatabaseConnection();
        $commentRepository->connection = new DatabaseConnection();

        $article = $articleRepository->getArticle($id);
        $comments = $commentRepository->getPublishedComments($id);

        $this->twig->display('article.html.twig', ['article' => $article, 'comments' => $comments]);
    }
}