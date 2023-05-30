<?php

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\CommentRepository;
use Twig\Environment;
use App\Repository\UserRepository;

class Comment
{
    public function __construct(public Environment $twig)
    {

    }


}