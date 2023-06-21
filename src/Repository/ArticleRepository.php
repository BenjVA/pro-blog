<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Article;
use App\Model\DatabaseConnection;

class ArticleRepository
{
    public DatabaseConnection $connection;

    public function getRecentPublishedArticles(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT *,
            DATE_FORMAT(createdAt, '%d-%m-%Y à %Hh%imin%ss') AS createdAt,
            DATE_FORMAT(updatedAt, '%d-%m-%Y à %Hh%imin%ss') AS updatedAt
            FROM article
            WHERE published = 1
            ORDER BY article.updatedAt
            DESC
            LIMIT 0, 3"
        );
        $recentArticles = [];

        while (($row = $statement->fetch())) {
            $recentArticle = new Article();
            $recentArticle->title = $row['title'];
            $recentArticle->published = $row['published'];
            $recentArticle->createdAt = $row['createdAt'];
            $recentArticle->updatedAt = $row['updatedAt'];
            $recentArticle->short = $row['short'];
            $recentArticle->id = $row['id'];

            $recentArticles[] = $recentArticle;
        }

        return $recentArticles;
    }

    public function getPublishedArticles(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT *,
            DATE_FORMAT(createdAt, '%d-%m-%Y à %Hh%imin%ss') AS createdAt,
            DATE_FORMAT(updatedAt, '%d-%m-%Y à %Hh%imin%ss') AS updatedAt
            FROM article
            WHERE published = 1
            ORDER BY article.updatedAt
            DESC"
        );
        $articles = [];

        while (($row = $statement->fetch())) {
            $article = new Article();
            $article->title = $row['title'];
            $article->published = $row['published'];
            $article->createdAt = $row['createdAt'];
            $article->updatedAt = $row['updatedAt'];
            $article->short = $row['short'];
            $article->id = $row['id'];

            $articles[] = $article;
        }

        return $articles;
    }

    public function getSingleArticle(string $id): Article
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT article.id, user.pseudo, title, content, published, short,
             DATE_FORMAT(createdAt, '%d-%m-%Y à %Hh%imin%ss') AS createdAt,
             DATE_FORMAT(updatedAt, '%d-%m-%Y à %Hh%imin%ss') AS updatedAt
             FROM article
             INNER JOIN user ON article.idUser = user.id
             WHERE article.id = ? AND published = 1"
        );
        $statement->execute([$id]);

        $row = $statement->fetch();
        $article = new Article();
        $article->title = $row['title'];
        $article->published = $row['published'];
        $article->createdAt = $row['createdAt'];
        $article->updatedAt = $row['updatedAt'];
        $article->content = $row['content'];
        $article->id = $row['id'];
        $article->pseudo = $row['pseudo'];
        $article->short = $row['short'];

        return $article;
    }

    public function addArticle(string $idUser, string $title, string $short, string $content): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO article(idUser, title, short, content, createdAt, updatedAt, published)
                        VALUES(:idUser, :title, :short, :content, NOW(), NOW(), 0)"
        );
        $affectedLines = $statement->execute([
            'idUser' => $idUser,
            'title' => $title,
            'short' => $short,
            'content' => $content,
        ]);

        return ($affectedLines > 0);
    }

    public function getWaitingPublicationArticles(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT article.id, pseudo, createdAt, article.content, article.published, title, short
                    FROM article
                    INNER JOIN user ON article.idUser = user.id
                    WHERE published = 0
                    ORDER BY createdAt DESC"
        );

        $notPublishedArticles = [];

        while ($row = $statement->fetch()) {
            $notPublishedArticle = new Article();
            $notPublishedArticle->id = $row['id'];
            $notPublishedArticle->pseudo = $row['pseudo'];
            $notPublishedArticle->createdAt = $row['createdAt'];
            $notPublishedArticle->content = $row['content'];
            $notPublishedArticle->published = $row['published'];
            $notPublishedArticle->title = $row['title'];
            $notPublishedArticle->short = $row['short'];

            $notPublishedArticles[] = $notPublishedArticle;
        }

        return $notPublishedArticles;
    }

    public function deleteArticle(string $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "DELETE FROM article WHERE id = :id"
        );

        $affectedLine = $statement->execute([
            'id' => $id
        ]);

        return ($affectedLine > 0);
    }

    public function publishArticle(string $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE article SET article.published = 1 WHERE id = :id"
        );

        $affectedLine = $statement->execute([
            'id' => $id
        ]);

        return ($affectedLine > 0);
    }

    public function editArticle(string $id, string $title, string $short, string $content): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE article SET title = :title, short = :short, content = :content, updatedAt = NOW()  
                    WHERE id = :id"
        );

        $affectedLine = $statement->execute([
            'id' => $id,
            'title' => $title,
            'short' => $short,
            'content' => $content
        ]);

        return ($affectedLine > 0);
    }
}