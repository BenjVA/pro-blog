<?php

// We connect to the database.
try {
    $database = new PDO('mysql:host=localhost;dbname=problog;charset=utf8', 'root', '');
}
catch(Exception $e) {
    die('Error : '.$e->getMessage());
}

?>