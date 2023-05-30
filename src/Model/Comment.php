<?php

declare(strict_types=1);

namespace App\Model;

class Comment
{
    public int $id;
    public string $content;
    public string $dateComment;
    public string $updatedAt;
    public string $pseudo;
    public string $idArticle;
}