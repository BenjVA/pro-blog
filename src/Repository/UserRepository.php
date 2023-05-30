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
        $statement = $this->connection->getConnection()->query(
            "SELECT mail FROM user"
        );
        $statement->execute([$mail]);


        $row = $statement->fetch();
        $user = new User();
        $user->mail = $row['mail'];

        return $user;
    }

    public function addUser(string $pseudo, string $mail, string $password): bool
    {
        $pwd = password_hash($password, PASSWORD_DEFAULT);
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO problog.user(pseudo, mail, password) VALUES (?, ?, ?)"
        );
        $affectedLine = $statement->execute(array(
            'pseudo' => $pseudo,
            'mail'=> $mail,
            'password' => $pwd)
        );

        return ($affectedLine > 0);
    }
}