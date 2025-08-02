<?php
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Check if the remember_token cookie exists and remove it
if (isset($_COOKIE['remember_token'])) {
    unset($_COOKIE['remember_token']);
    // Expire the cookie by setting an expiration time in the past
    setcookie('remember_token', '', time() - 3600, '/');
}

// Redirect to the login page using BASE_URL
header("Location: " . BASE_URL);
exit;
