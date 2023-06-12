<?php

declare(strict_types=1);

namespace App\Model;

class Comment
{
    public string $id;
    public string $content;
    public string $dateComment;
    public string $idArticle;
    public string $idUser;
    public string $pseudo;
}