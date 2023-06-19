<?php

declare(strict_types=1);

namespace App\Model;

class User
{
    public string $id;
    public string $pseudo;
    public string $mail;
    public string $password;
    public string $isAdmin;
}