<?php

namespace App\Helpers;

class SessionHelper
{
    // Tiempo de inactividad permitido (en segundos)
    private static $timeout = 900; // Actual time is: 15 minutes

    public static function checkTimeout()
    {
        // ✅ Verifica si la sesión ya está activa
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            // No hay usuario logueado
            return false;
        }

        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > self::$timeout) {
            // Expiró el tiempo de inactividad
            session_unset();
            session_destroy();
            redirection('auth/login');  // Redirect to login
            exit;
        }

        // ✅ Actualiza la actividad
        $_SESSION['last_activity'] = time();
        return true;
    }

    public static function isSessionActive()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > self::$timeout) {
            session_unset();
            session_destroy();
            return false;
        }

        $_SESSION['last_activity'] = time();
        return true;
    }
}
