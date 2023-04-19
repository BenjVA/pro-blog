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
    public DatabaseConnection $connection;
    public function getRecentArticles(): array
{
    $statement = $this->connection->getConnection()->query(
        "SELECT id, title, short, DATE_FORMAT(creationDate, '%d/%m/%Y à %Hh%imin%ss') AS creationDate FROM article ORDER BY creationDate DESC LIMIT 0, 3"
    );
    $recentArticles = [];
    while (($row = $statement->fetch())) {
        $article = new Article();
        $article->title = $row['title'];
        $article->creationDate = $row['creationDate'];
        $article->id = $row['id'];
        $article->short = $row['short'];

        $recentArticles[] = $article;
    }

    return $recentArticles;
}
}