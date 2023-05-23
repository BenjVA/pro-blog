<?php


namespace App\Model;

class ArticleRepository
{
    public DatabaseConnection $connection;
    public function getRecentArticles(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT id, title, short, DATE_FORMAT(creationDate, '%d/%m/%Y à %Hh%imin%ss') AS creationDate FROM article ORDER BY creationDate DESC LIMIT 0, 3"
        );
        $recentArticles = [];
        while (($row = $statement->fetch())) {
            $recentArticle = new Article();
            $recentArticle->title = $row['title'];
            $recentArticle->creationDate = $row['creationDate'];
            $recentArticle->short = $row['short'];
            $recentArticle->id = $row['id'];

            $recentArticles[] = $recentArticle;
        }

        return $recentArticles;
    }

    public function getArticles(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT id, title, short, DATE_FORMAT(creationDate, '%d/%m/%Y à %Hh%imin%ss') AS creationDate FROM article ORDER BY creationDate DESC"
        );
        $articles = [];
        while (($row = $statement->fetch())) {
            $article = new Article();
            $article->title = $row['title'];
            $article->creationDate = $row['creationDate'];
            $article->short = $row['short'];
            $article->id = $row['id'];

            $articles[] = $article;
        }

        return $articles;
    }

    public function getArticle($id): Article
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT article.id, user.pseudo, title, content, DATE_FORMAT(creationDate, '%d/%m/%Y à %Hh%imin%ss') AS creationDate FROM article 
                        INNER JOIN user ON article.idUser = user.id WHERE article.id = ?"
        );
        $statement->execute([$id]);


        $row = $statement->fetch();
        $article = new Article();
        $article->title = $row['title'];
        $article->creationDate = $row['creationDate'];
        $article->content = $row['content'];
        $article->id = $row['id'];
        $article->pseudo = $row['pseudo'];

        return $article;
    }
}