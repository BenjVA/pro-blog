<?php

namespace App;

class Session
{
    public static function setSession(string $sessionKey, $sessionValue): void
    {
        $_SESSION[$sessionKey] = $sessionValue;
    }
}