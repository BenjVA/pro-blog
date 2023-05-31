<?php

namespace App\Repository;


use App\Model\DatabaseConnection;
use App\Model\User;
use PDO;

class UserRepository
{
    public DatabaseConnection $connection;

    public function getUser($mail): ?User
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM user WHERE mail = :mail"
        );
        $statement->execute([
            'mail' => $mail
        ]);

        $row = $statement->fetch();
        if (!$row) {
            return null;
        }
        $user = new User();
        $user->mail = $row['mail'];

        return $user;
    }

    public function addUser(string $pseudo, string $mail, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO problog.user(pseudo, mail, password) VALUES (:pseudo, :mail, :password)"
        );
        $affectedLine = $statement->execute([
            'pseudo' => $pseudo,
            'mail'=> $mail,
            'password' => $hashedPassword
        ]);

        return ($affectedLine > 0);
    }
}