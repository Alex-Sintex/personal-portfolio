<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\models\AccountModel;
use App\Helpers\EmailBuilder;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Verification extends Controller
{
    private $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
    }

    // GET /verify?token=...
    public function index()
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            // Redirect with error toast param
            redirection('account?verified=error');
            exit;
        }

        $user = $this->accountModel->verifyEmailByToken($token);

        if ($user) {
            // Redirect with success toast param
            redirection('account?verified=success');
        } else {
            // Redirect with error toast param
            redirection('account?verified=expired');
        }

        exit;
    }

    // POST /verification/resend
    public function resend()
    {
        requireLogin();
        header('Content-Type: application/json');

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado.']);
            return;
        }

        $user = $this->accountModel->getUserById($userId);

        if (!$user || $user->is_email_verified) {
            echo json_encode(['status' => 'error', 'message' => 'Ya estás verificado o usuario no válido.']);
            return;
        }

        // Generate token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));

        // Save token to database
        $this->accountModel->setEmailVerificationToken($user->id, $token, $expiresAt);

        // Build email content
        $verificationUrl = PATH_URL . "verify?token={$token}";
        $logoUrl = PATH_URL . "img/Logo/Logo.png";

        $emailHtml = EmailBuilder::buildVerificationEmail(
            $user->fname ?? $user->username,
            $verificationUrl,
            $logoUrl
        );

        // Send email with PHPMailer
        try {
            $mail = new PHPMailer(true);

            // SMTP settings
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // ✅ Fix encoding issue
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);
            $mail->addAddress($user->email, $user->fname ?? $user->username);

            $mail->isHTML(true);
            $mail->Subject = 'Verifica tu correo electrónico';
            $mail->Body    = $emailHtml;
            $mail->AltBody = "Hola {$user->fname},\n\nHaz clic en el siguiente enlace para verificar tu correo:\n{$verificationUrl}";

            $mail->send();

            echo json_encode(['status' => 'success', 'message' => 'Correo de verificación enviado correctamente.']);
        } catch (Exception $e) {
            error_log('PHPMailer Error: ' . $mail->ErrorInfo);
            echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo. Intenta más tarde.']);
        }
    }
}
