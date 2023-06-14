<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Comment;
use App\Model\DatabaseConnection;

class CommentRepository
{
    public DatabaseConnection $connection;

    public function getPublishedComments(string $idArticle): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT comment.id, pseudo, comment.createdAt, comment.content, idArticle, published
                        FROM comment
                        INNER JOIN article ON comment.idArticle = article.id
                        INNER JOIN user ON comment.idUser = user.id
                        WHERE article.id = :idArticle AND published = 1
                        ORDER BY createdAt
                        DESC"
        );
        $statement->execute([
            'idArticle' => $idArticle
        ]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->id = $row['id'];
            $comment->pseudo = $row['pseudo'];
            $comment->createdAt = $row['createdAt'];
            $comment->content = $row['content'];
            $comment->idArticle = $row['idArticle'];
            $comment->published = $row['published'];

            $comments[] = $comment;
        }
        return $comments;
    }

    public function addComment(string $idArticle, string $idUser, string $content): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO problog.comment(idArticle, idUser, content, createdAt, published)
                    VALUES(:idArticle, :idUser, :content, NOW(), 0)"
        );
        $affectedLines = $statement->execute([
            'idArticle' => $idArticle,
            'idUser' => $idUser,
            'content' => $content,
        ]);

        return ($affectedLines > 0);
    }

    public function getWaitingPublicationComments(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT comment.id, pseudo, createdAt, comment.content, idArticle, published
                    FROM comment
                    INNER JOIN user ON comment.idUser = user.id
                    WHERE published = 0
                    ORDER BY createdAt DESC"
        );

        $notPublishedComments = [];

        while (($row = $statement->fetch())) {
            $notPublishedComment = new Comment();
            $notPublishedComment->id = $row['id'];
            $notPublishedComment->pseudo = $row['pseudo'];
            $notPublishedComment->createdAt = $row['createdAt'];
            $notPublishedComment->content = $row['content'];
            $notPublishedComment->idArticle = $row['idArticle'];
            $notPublishedComment->published = $row['published'];

            $notPublishedComments[] = $notPublishedComment;
        }

        return $notPublishedComments;
    }

    public function publishComment(string $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE comment SET published = 1 WHERE id = :id"
        );

        $affectedLine = $statement->execute([
            'id' => $id
        ]);

        return ($affectedLine > 0);
    }
}