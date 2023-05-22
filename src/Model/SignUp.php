<?php

namespace App\Model;

class SignUp extends User
{
    public DatabaseConnection $connection;

    public function addUser(string $pseudo, string $mail, string $password): bool
    {
        $pwd = password_hash($password, PASSWORD_DEFAULT);
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO problog.user(pseudo, mail, isAdmin, password) VALUES (?, ?, ?, ?)"
        );

        $affectedLine = $statement->execute([$pseudo, $mail, $pwd]);
        return ($affectedLine > 0);
    }
}