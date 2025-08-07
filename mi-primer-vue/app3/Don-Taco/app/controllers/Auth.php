<?php
// Auth.php — Controller for login, registration, logout, etc.

namespace App\controllers;

use App\Libraries\Controller;
use App\Helpers\SessionHelper;

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
            'loadStyleforAuth'     => true, // CSS
            'loadToastStyle'       => true, // CSS
            'loadJQueryLibrary'    => true, // JS
            'loadToasty'           => true, // JS
            'loadJSLogin'          => true, // JS
            'loadShowHidePasswd'   => true  // JS
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

                $_SESSION['user'] = $user;  // Guarda todo el objeto (incluyendo imagen si ya existe)

                // Update status in db to set online user
                $this->userModel->setStatusOnline($user->id);
                $_SESSION['user_status'] = 'online';

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

    // Forgot password function
    public function resetPassword()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $login = trim($input['login'] ?? '');
        $code = trim($input['code'] ?? '');
        $newPassword = trim($input['password'] ?? '');

        if (empty($login) || empty($code) || empty($newPassword)) {
            echo json_encode(['success' => false, 'error' => 'Faltan datos']);
            return;
        }

        $user = $this->userModel->findUserByLogin($login);
        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
            return;
        }

        $token = $this->userModel->getValidResetToken($user->id, $code);
        if (!$token) {
            echo json_encode(['success' => false, 'error' => 'Código inválido o expirado']);
            return;
        }

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->userModel->updateUser($user->id, ['password' => $hashed]);
        $this->userModel->deleteToken($token->id_token);

        echo json_encode(['success' => true, 'message' => 'Contraseña actualizada']);
    }

    // Check session timeout
    public function checkSession()
    {
        header('Content-Type: application/json');
        echo json_encode(['active' => SessionHelper::isSessionActive()]);
        exit;
    }

    // Log out and redirect
    public function logout()
    {
        session_start(); // Start the session first

        // Change status to offline before destroying session
        if (isset($_SESSION['user_id'])) {
            $this->userModel->setStatusOffline($_SESSION['user_id']);
            $_SESSION['user_status'] = 'offline';
        }

        session_unset();            // Remove all session variables
        session_destroy();          // Destroy the session completely
        redirection('auth/login');  // Redirect to login
    }

    // Handle password reset request (user enters email or username)
    public function requestReset()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $login = trim($input['login'] ?? '');

        if (empty($login)) {
            echo json_encode(['success' => false, 'error' => 'Correo o usuario requerido']);
            return;
        }

        $user = $this->userModel->findUserByLogin($login);
        if (!$user || empty($user->email)) {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
            return;
        }

        $recentToken = $this->userModel->getRecentToken($user->id, 'reset', 2);
        if ($recentToken) {
            echo json_encode(['success' => false, 'error' => 'Espera antes de reenviar el código']);
            return;
        }

        $code = random_int(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->userModel->saveResetToken($user->id, (string)$code, $expiresAt);

        $logoUrl = PATH_URL . 'img/Logo/Logo.png';
        $html = \App\Helpers\EmailBuilder::buildResetCodeEmail($user->username, $code, $logoUrl);

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'];
            $mail->Password   = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // ✅ Fix encoding issue
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);
            $mail->addAddress($user->email, $user->username);
            $mail->isHTML(true);
            $mail->Subject = 'Código para restablecer tu contraseña';
            $mail->Body    = $html;

            $mail->send();

            echo json_encode(['success' => true, 'message' => 'Código enviado al correo']);
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Error al enviar el correo']);
        }
    }

    public function verifyResetCode()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $login = trim($input['login'] ?? '');
        $code = trim($input['code'] ?? '');

        if (empty($login) || empty($code)) {
            echo json_encode(['success' => false, 'error' => 'Faltan datos']);
            return;
        }

        $user = $this->userModel->findUserByLogin($login);
        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
            return;
        }

        $token = $this->userModel->getValidResetToken($user->id, $code);
        if (!$token) {
            echo json_encode(['success' => false, 'error' => 'Código inválido o expirado']);
            return;
        }

        echo json_encode(['success' => true, 'message' => 'Código verificado']);
    }
}
