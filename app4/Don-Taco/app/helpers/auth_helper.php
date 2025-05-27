<?php
// Check sessions
function requireLogin()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        redirection('auth/login');
        exit;
    }
}
