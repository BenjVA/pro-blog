<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Comment;
use App\Model\DatabaseConnection;

class CommentRepository
{
    public DatabaseConnection $connection;

    public function getComments($idArticle): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT comment.id, pseudo, dateComment, comment.content, idArticle
                        FROM comment
                        INNER JOIN article ON comment.idArticle = article.id
                        INNER JOIN user ON comment.idUser = user.id
                        WHERE article.id = :idArticle
                        ORDER BY dateComment DESC"
        );
        $statement->execute([
            'idArticle' => $idArticle
        ]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->id = $row['id'];
            $comment->pseudo = $row['pseudo'];
            $comment->dateComment = $row['dateComment'];
            $comment->content = $row['content'];
            $comment->idArticle = $row['idArticle'];

            $comments[] = $comment;
        }
        return $comments;
    }
}