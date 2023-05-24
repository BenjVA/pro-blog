<?php

namespace App\Repository;


use App\Model\DatabaseConnection;
use App\Model\User;

class UserRepository
{
    public DatabaseConnection $connection;

    public function getUser($mail): ?User
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT mail FROM user"
        );
        $statement->execute([$mail]);


        $row = $statement->fetch();
        $user = new User();
        $user->mail = $row['mail'];

        return $user;
    }
}