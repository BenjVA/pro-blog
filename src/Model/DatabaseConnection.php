<?php

declare(strict_types=1);

namespace App\Model;

use PDO;

class DatabaseConnection
{
    public ?PDO $database = null;

    public function getConnection(): PDO
    {
        if ($this->database === null) {
            $this->database = new PDO('mysql:host=localhost;dbname=problog;charset=utf8', 'root', '');
        }

        return $this->database;
    }
}