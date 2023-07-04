<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Comment;
use App\Model\DatabaseConnection;
use PDOStatement;

class CommentRepository
{
    public DatabaseConnection $connection;

    public function getPublishedComments(string $idArticle): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT comment.id, pseudo, comment.createdAt, comment.content, idArticle, comment.published
                        FROM comment
                        INNER JOIN article ON comment.idArticle = article.id
                        INNER JOIN user ON comment.idUser = user.id
                        WHERE article.id = :idArticle AND comment.published = 1
                        ORDER BY createdAt
                        DESC"
        );
        $statement->execute([
            'idArticle' => $idArticle
        ]);

        return $this->commentsList($statement);
    }

    public function addComment(string $idArticle, string $idUser, string $content): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO problog.comment(idArticle, idUser, content, createdAt, comment.published)
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
            "SELECT comment.id, pseudo, createdAt, comment.content, idArticle, comment.published
                    FROM comment
                    INNER JOIN user ON comment.idUser = user.id
                    WHERE published = 0
                    ORDER BY createdAt DESC"
        );

        return $this->commentsList($statement);
    }

    public function publishComment(string $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE comment SET comment.published = 1 WHERE id = :id"
        );

        $affectedLine = $statement->execute([
            'id' => $id
        ]);

        return ($affectedLine > 0);
    }

    public function deleteComment(string $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "DELETE FROM comment WHERE id = :id"
        );

        $affectedLine = $statement->execute([
            'id' => $id
        ]);

        return ($affectedLine > 0);
    }

    /**Get comments list to avoid duplicate code
     *
     * @param bool|PDOStatement $statement
     * @return array
     */
    public function commentsList(bool|PDOStatement $statement): array
    {
        $commentsList = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->id = $row['id'];
            $comment->pseudo = $row['pseudo'];
            $comment->createdAt = $row['createdAt'];
            $comment->content = $row['content'];
            $comment->idArticle = $row['idArticle'];
            $comment->published = $row['published'];

            $commentsList[] = $comment;
        }
        return $commentsList;
    }
}
