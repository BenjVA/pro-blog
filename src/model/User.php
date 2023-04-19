<?php

declare(strict_types=1);

namespace App\model;

class User
{
    public int $id;
    public string $login;
    public string $mail;
    public bool $isAdmin;
}