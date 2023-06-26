<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\DatabaseConnection;
use App\Model\User;
use App\Session;

class UserRepository
{
    public DatabaseConnection $connection;

    public function getUserPseudo(string $pseudo): ?User
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM user WHERE pseudo = :pseudo"
        );
        $statement->execute([
            'pseudo' => $pseudo,
        ]);

        $row = $statement->fetch();
        if (!$row) {
            return null;
        }
        $user = new User();
        $user->pseudo = $row['pseudo'];

        return $user;
    }

    public function getUserMail(string $mail): ?User
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM user WHERE mail = :mail"
        );
        $statement->execute([
            'mail' => $mail,
        ]);

        $row = $statement->fetch();
        if (!$row) {
            return null;
        }
        $user = new User();
        $user->mail = $row['mail'];

        return $user;
    }

    public function connectUser(string $mail, string $password): ?User
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM user WHERE mail = :mail"
        );
        $statement->execute([
            'mail' => $mail,
        ]);

        $row = $statement->fetch();
        if (!$row) {
            return null;
        }
        $isRightPassword = password_verify($password, $row['password']);
        if (!$isRightPassword) {
            return null;
        }
        $user = new User();
        $user->mail = $row['mail'];
        $user->pseudo = $row['pseudo'];
        $user->id = $row['id'];
        $user->isAdmin = $row['isAdmin'];
        Session::setSession('user', $user);

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

    public function deleteUser(string $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "DELETE FROM user WHERE id = :id"
        );

        $affectedLine = $statement->execute([
            'id' => $id
        ]);

        return ($affectedLine > 0);
    }

    public function getUsers(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM user"
        );

        $users = [];

        while ($row = $statement->fetch()) {
            $user = new User();
            $user->id = $row['id'];
            $user->pseudo = $row['pseudo'];
            $user->mail = $row['mail'];
            $user->isAdmin = $row['isAdmin'];

            $users[] = $user;
        }

        return $users;
    }

    public function deactivateUser(string $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE user SET isAdmin = 3 WHERE id = :id"
        );
        $affectedLine = $statement->execute([
            'id' => $id
        ]);

        return ($affectedLine > 0);
    }

    public function activateUser(string $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE user SET isAdmin = 2 WHERE id = :id"
        );
        $affectedLine = $statement->execute([
            'id' => $id
        ]);

        return ($affectedLine > 0);
    }
}