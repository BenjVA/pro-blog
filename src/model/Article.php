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