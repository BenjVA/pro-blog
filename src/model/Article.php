<?php

declare(strict_types=1);

namespace App\model;

class Article
{
    public int $id;
    public string $content;
    public string $title;
    public string $short;
    public string $status;
    public string $creationDate;
}

class ArticleRepository
{
    public DatabaseConnection $connection;
    public function getArticles(): Article
{
    $statement = $this->connection->getConnection()->prepare(
        "SELECT id, title, short, DATE_FORMAT(creationDate, '%d/%m/%Y à %Hh%imin%ss') AS creationDate FROM article"
    );
    $row = $statement->fetch();
    $article = new Article();
    $article->title = $row['title'];
    $article->creationDate = $row['creationDate'];
    $article->content = $row['content'];
    $article->id = $row['id'];

    var_dump($article);
}
}