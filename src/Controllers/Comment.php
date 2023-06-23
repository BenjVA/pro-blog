<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\CommentRepository;

class Comment extends Article
{
    public function addComment(): void
    {
        if (count($_POST) > 0) {
            $idArticle = $_GET['id'];
            $idUser = $_SESSION['user']->id;
            $content = $_POST['commentary'];

            $comment = new CommentRepository();
            $comment->connection = new DatabaseConnection();
            $addComment = $comment->addComment($idArticle, $idUser, $content);

            if (!$addComment) {
                $notAddedComment = 'Votre commentaire n\'a pas pu être envoyé !';
            }
        }

        $addedComment = 'Votre commentaire est en attente de validation !';
        $this->showPublishedArticle($idArticle ?? null,
            $notAddedComment ?? null,
            $addedComment
        );
    }

    public function showNotPublishedComments(
        ?string $publishedComment,
        ?string $errorPublishComment,
        ?string $deletedComment,
        ?string $errorDeleteComment): void
    {
        $notPublishedComment = new CommentRepository();
        $notPublishedComment->connection = new DatabaseConnection();
        $notPublishedComments = $notPublishedComment->getWaitingPublicationComments();

        $this->twig->display('waitingCommentsList.html.twig', [
            'notPublishedComments' => $notPublishedComments,
            'publishedComment' => $publishedComment,
            'errorPublishComment' => $errorPublishComment,
            'deletedComment' => $deletedComment,
            'errorDeleteComment' => $errorDeleteComment
        ]);
    }

    public function publishComment(): void
    {
        $id = $_GET['id'];

        $publishComment = new CommentRepository();
        $publishComment->connection = new DatabaseConnection();
        $publishComments = $publishComment->publishComment($id);

        if ($publishComments) {
            $publishedComment = 'Commentaire validé !';
        } else {
            $errorPublishComment = 'Commentaire non validé';
        }

        $this->showNotPublishedComments(
            $publishedComment ?? null,
            $errorPublishComment ?? null,
            $deletedComment ?? null,
            $errorDeleteComment ?? null
        );
    }

    public function deleteComment(): void
    {
        $id = $_GET['id'];

        $deleteComment = new CommentRepository();
        $deleteComment->connection = new DatabaseConnection();
        $deleteComments = $deleteComment->deleteComment($id);

        if ($deleteComments) {
            $deletedComment = 'Commentaire supprimé !';
        } else {
            $errorDeleteComment = 'Commentaire non supprimé';
        }

        $this->showNotPublishedComments(
            $publishedComment ?? null,
            $errorPublishComment ?? null,
            $deletedComment ?? null,
            $errorDeleteComment ?? null
        );
    }
}