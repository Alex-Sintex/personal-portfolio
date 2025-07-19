<?php
// auth_helper.php

// Requiere que el usuario haya iniciado sesión
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

// Verifica si el usuario es admin
function isAdmin()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

// Devuelve el rol del usuario (admin, user, o guest si no hay sesión)
function userRole()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return $_SESSION['user_type'] ?? 'user';
}

function requireAdmin()
{
    if (!isAdmin()) {
        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        ) {
            // Es una llamada AJAX
            header('Content-Type: application/json');
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Acceso denegado: solo administradores']);
        } else {
            // Es una página normal
            redirection('dashboard');
        }
        exit;
    }
}
