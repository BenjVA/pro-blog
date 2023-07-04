<?php

declare(strict_types=1);

namespace App\Model;

class Comment
{
    public string $id;
    public string $pseudo;
    public string $content;
    public string $createdAt;
    public string $idArticle;
    public string $published;
}
