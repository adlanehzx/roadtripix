<?php

namespace App\Core;

use App\Models\User;

class Authenticator
{
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', 3600);
            session_start();
        }
    }

    public static function user(): ?User
    {
        if (isset($_SESSION['user_id'])) {
            return User::find($_SESSION['user_id']);
        }

        return null;
    }

    public static function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function login(User $user)
    {
        self::init();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
    }

    public static function logout()
    {
        self::init();
        session_unset();
        session_destroy();
    }

    public static function check(): bool
    {
        self::init();
        return isset($_SESSION['user_id']);
    }
}
