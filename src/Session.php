<?php

namespace App;

class Session
{
    public static function setSession(string $sessionKey, object $sessionValue): void
    {
        $_SESSION[$sessionKey] = $sessionValue;
    }
}