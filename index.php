<?php

require __DIR__ . '/vendor/autoload.php';

use App\Router\Router;

try {
    $router = new Router;
    $controller = $router->getController($_GET);
    return $controller->showAction();
} catch (Exception $e) {
    echo 'Erreur : ' .$e->getMessage();
}