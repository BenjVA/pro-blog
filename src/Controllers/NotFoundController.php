<?php

namespace App\Controllers;

use Twig\Environment;

class NotFoundController
{
    public function __construct(public Environment $twig)
    {

    }

    public function showError(): void
    {
        $this->twig->display('notFound.html.twig');
    }
}