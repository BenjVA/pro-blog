<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\CommentRepository;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class Comment
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function addComment(): void
    {
        if (count($_POST) > 0) {
            $idArticle = $_GET['id'];
            $idUser = $_SESSION['user']->id;
            $content = $_POST['commentary'];

            $comment = new CommentRepository();
            $comment->connection = new DatabaseConnection();
            $addComment = $comment->addComment($idArticle, $idUser, $content);

            if ($addComment) {
                $this->twig->display('article.html.twig', [
                    'waitingValidation' => 'Votre commentaire est en attente de validation !'
                ]);
            }
        }
        $this->twig->display('notFound.html.twig');
    }

    public function showNotPublishedComments(): void
    {
        $notPublishedComment = new CommentRepository();
        $notPublishedComment->connection = new DatabaseConnection();
        $notPublishedComments = $notPublishedComment->getWaitingPublicationComments();
        $this->twig->display('waitingCommentsList.html.twig', ['notPublishedComments' => $notPublishedComments]);
    }
}