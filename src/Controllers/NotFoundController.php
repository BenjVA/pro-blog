<?php

declare(strict_types=1);

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