<?php

namespace App\Repository;

use App\Model\Comment;
use App\Model\DatabaseConnection;

class CommentRepository
{
    public DatabaseConnection $connection;

    public function getComments($idArticle): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT article.id, comment.id, user.pseudo, comment.content, DATE_FORMAT(dateComment, '%d/%m/%Y à %Hh%imin%ss') AS dateComment 
                        FROM comment
                        INNER JOIN article ON comment.idArticle = article.id 
                        INNER JOIN user ON comment.idUser = user.id 
                        ORDER BY dateComment DESC"
        );
        $statement->execute([$idArticle]);

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