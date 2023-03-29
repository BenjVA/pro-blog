<?php

function dbConnect()  // We connect to the database.
{
    try {
        $database = new PDO('mysql:host=localhost;dbname=problog;charset=utf8', 'root', '');

        return $database;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function recentPosts()
{

}