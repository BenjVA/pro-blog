<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\CommentRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Comment extends Article
{
    /**Show comment form to add comment
     *
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function addComment(): void
    {
        if (count($_POST) > 0) {
            if (isset($_SESSION['user']->id) && (is_numeric($_SESSION['user']->id))
                && isset($_POST['commentary']) && !empty($_POST['commentary'])
                && isset($_GET['id']) && !empty($_GET['id'])) {
                $idArticle = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
                $idUser = $_SESSION['user']->id;
                $content = filter_input(INPUT_POST, 'commentary', FILTER_SANITIZE_SPECIAL_CHARS);

                $comment = new CommentRepository();
                $comment->connection = new DatabaseConnection();
                $addComment = $comment->addComment($idArticle, $idUser, $content);

                if (!$addComment) {
                    $notAddedComment = 'Votre commentaire n\'a pas pu être envoyé !';
                }
            }
        }

        $addedComment = 'Votre commentaire est en attente de validation !';
        $this->showPublishedArticle($idArticle ?? null,
            $notAddedComment ?? null,
            $addedComment
        );
    }

    /**Show comments awaiting publication by admin
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
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

    /**Publish comments with notifications
     *
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function publishComment(): void
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

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
    }

    /**Delete comments with notifications
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function deleteComment(): void
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

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
}
