<?php

namespace App\Controllers;

use App\Libraries\Controller;

class EmailVerificationController extends Controller
{
    protected $emailVerificationModel;
    protected $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
        $this->emailVerificationModel = $this->model('EmailVerificationModel');
    }

    public function verifyToken()
    {
        header('Content-Type: application/json');

        $token = $_GET['token'] ?? '';

        if (!$token) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Token missing']);
            exit;
        }

        $verification = $this->emailVerificationModel->findByToken($token);

        if (!$verification) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Invalid or expired token']);
            exit;
        }

        if (strtotime($verification->expires_at) < time()) {
            $this->emailVerificationModel->deleteById($verification->id);

            http_response_code(410);
            echo json_encode(['success' => false, 'message' => 'Token expired']);
            exit;
        }

        $user = $this->userModel->findById($verification->user_id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'User not found']);
            exit;
        }

        // Update user email verification status
        $updateData = ['is_email_verified' => 1];
        $this->userModel->updateUser($user->id, $updateData);

        // Delete token after successful verification
        $this->emailVerificationModel->deleteById($verification->id);

        echo json_encode(['success' => true, 'message' => 'Email verified successfully']);
        exit;
    }
}
