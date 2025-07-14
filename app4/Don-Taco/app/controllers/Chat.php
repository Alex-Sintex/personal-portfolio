<?php

namespace App\controllers;

use App\Libraries\Controller;

class Chat extends Controller
{
    private $chatModel;

    public function __construct()
    {
        requireLogin();
        $this->chatModel = $this->model('ChatModel');
    }

    // Load chat view with required resources
    public function index()
    {
        $data = [
            'loadStyles'           => true, // CSS
            'loadToastStyle'       => true, // CSS
            'loadChatStyle'        => true, // CSS
            'loadJQueryLibrary'    => true, // JS
            'loadScriptSideBar'    => true, // JS
            'loadToasty'           => true, // JS
            'loadChatScripts'      => true  // JS
        ];
        $this->view('modules/chat', $data);
    }

    // Handle login via AJAX
    /*public function authLogin()
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

                // Login success
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->username;
                $_SESSION['user_type'] = $user->role;

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
    }*/

    // Stub: forgot password logic
    /*public function forgotPassword()
    {
        // To be implemented
    }*/
}
