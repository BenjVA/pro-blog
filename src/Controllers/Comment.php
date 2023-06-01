<?php

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\CommentRepository;
use Twig\Environment;

class Comment
{
    public function __construct(public Environment $twig)
    {

    }

    /*public function showComments($idArticle): void
    {
        $commentRepository = new CommentRepository();
        $commentRepository->connection = new DatabaseConnection();
        $comments = $commentRepository->getComments($idArticle);

        $this->twig->display('article.html.twig', ['comments' => $comments]);
    }*/
}