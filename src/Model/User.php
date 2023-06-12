<?php

declare(strict_types=1);

namespace App\Model;

class User
{
    public int $id;
    public string $pseudo;
    public string $isAdmin;
    public string $password;
    public string $mail;
}