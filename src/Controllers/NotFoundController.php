<?php

declare(strict_types=1);

namespace App\Controllers;

use Twig\Environment;
use Twig\Extension\DebugExtension;

class NotFoundController
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function showError(): void
    {
        $this->twig->display('notFound.html.twig');
    }
}