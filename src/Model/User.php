<?php

namespace App\Model;

class User
{
    public int $id;
    public string $pseudo;
    public string $isAdmin;
    public string $password;
    public ?string $mail;
}