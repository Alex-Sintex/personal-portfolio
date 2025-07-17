<?php
// Auth.php — Controller for login, registration, logout, etc.

namespace App\controllers;

use App\Libraries\Controller;

class Auth extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
    }

    // Show login view
    public function login()
    {
        $data = [
            'loadStyleforAuth'   => true, // CSS
            'loadJQueryLibrary'  => true, // JS
            'loadJSLogin'        => true, // JS
            'loadShowHidePasswd' => true, //JS
            'loadToasty'         => true  // JS
        ];

        $this->view('auth/login', $data);
    }

    // Handle login via AJAX
    public function authLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            return;
        }

        header('Content-Type: application/json');

        $login = trim($_POST['login'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $errors = [];

        if (empty($login)) {
            $errors['login'] = 'Username or email required';
        }

        if (empty($password)) {
            $errors['password'] = 'Password required';
        }

        if (empty($errors)) {

            // Load model function to fetch credentials
            $user = $this->userModel->findUserByLogin($login);

            if (!$user) {
                echo json_encode([
                    'success' => false,
                    'errors' => ['login' => 'User/email not found']
                ]);
                return;
            }

            if (password_verify($password, $user->password)) {

                session_start();

                $_SESSION['user_id']     = $user->id;
                $_SESSION['user_name']   = $user->username;
                $_SESSION['user_type']   = $user->role;
                $_SESSION['user_status'] = $user->status;

                // Agrega esto:
                $_SESSION['user'] = $user;  // Guarda todo el objeto (incluyendo imagen si ya existe)

                echo json_encode([
                    'success' => true,
                    'redirect' => PATH_URL . 'dashboard'
                ]);
                return;
            } else {
                echo json_encode([
                    'success' => false,
                    'errors' => ['password' => 'Incorrect password']
                ]);
                return;
            }
        }

        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
    }

    // Stub: forgot password logic
    /*public function forgotPassword()
    {
        // To be implemented
    }*/

    // Log out and redirect
    public function logout()
    {
        session_start();            // Start the session first
        session_unset();            // Remove all session variables
        session_destroy();          // Destroy the session completely
        redirection('auth/login');  // Redirect to login
    }
}
