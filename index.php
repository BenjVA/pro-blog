<?php

require __DIR__ . '/vendor/autoload.php';

session_start();

use App\Router\Router;

try {
    $router = new Router;
    $router->getController($_GET);

} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
