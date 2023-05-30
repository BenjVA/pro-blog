<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Twig\Environment;

class Article
{
    public function __construct(public Environment $twig)
    {
        
    }

    public function showArticle($id): void
    {
        $articleRepository = new ArticleRepository();
        $articleRepository->connection = new DatabaseConnection();
        $article = $articleRepository->getArticle($id);

        $this->twig->display('article.html.twig', ['article' => $article]);
    }


    public function showComments($id): void
    {
        $commentRepository = new CommentRepository();
        $commentRepository->connection = new DatabaseConnection();
        $comments = $commentRepository->getComments($id);

        $this->twig->display('article.html.twig', ['comments' => $comments]);
    }
}