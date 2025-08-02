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

    private function filterUserFields($users, $currentUserId)
    {
        return array_values(array_filter(array_map(function ($user) use ($currentUserId) {
            if ($user->id == $currentUserId) return false;

            $avatarPath = "uploads/users/{$user->id}/profile.jpg";
            $avatarFull = dirname(__DIR__, 2) . "/public/$avatarPath";

            $avatar = file_exists($avatarFull)
                ? "/$avatarPath"
                : "/uploads/default-avatar.png";

            return [
                'id'       => $user->id,
                'username' => $user->username,
                'status'   => $user->status,
                'avatar'   => $avatar
            ];
        }, $users)));
    }

    public function getUsersStatus()
    {
        $currentUserId = $_SESSION['user_id'];

        $onlineUsers  = $this->chatModel->getUsersByStatus('Online', $currentUserId);
        $offlineUsers = $this->chatModel->getUsersByStatus('Offline', $currentUserId);

        $onlineUsers  = $this->filterUserFields($onlineUsers, $currentUserId);
        $offlineUsers = $this->filterUserFields($offlineUsers, $currentUserId);

        echo json_encode([
            'online'  => $onlineUsers,
            'offline' => $offlineUsers
        ]);
    }

    // Method for fetching users here (active and offline users)
    public function fetchUsers()
    {
        $currentUserId = $_SESSION['user_id'];
        $users = $this->chatModel->getUsers($currentUserId);
        echo json_encode($users);
    }

    // Method for fetching messages
    public function fetchMessages($otherUserId)
    {
        $currentUserId = $_SESSION['user_id'];
        $since = $_GET['since'] ?? null;

        $messages = $this->chatModel->getMessages($currentUserId, $otherUserId, $since);

        foreach ($messages as &$msg) {
            $msg->outgoing_avatar = $this->getAvatarPath($msg->outgoing_msg_id);
            $msg->incoming_avatar = $this->getAvatarPath($msg->incoming_msg_id);
        }

        echo json_encode($messages);
    }

    private function getAvatarPath($userId)
    {
        $avatarPath = "uploads/users/{$userId}/profile.jpg";
        $avatarFull = dirname(__DIR__, 2) . "/public/$avatarPath";
        return file_exists($avatarFull) ? "/$avatarPath" : "/uploads/default-avatar.png";
    }

    // Method for sending messages
    public function sendMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $from = $_SESSION['user_id'];
            $to = $_POST['to'];
            $message = isset($_POST['message']) ? trim($_POST['message']) : '';

            $fileMessage = '';
            $fileUploaded = false;

            // Handle file upload if present
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['file']['tmp_name'];
                $fileName = basename($_FILES['file']['name']);
                $fileType = mime_content_type($fileTmpPath);

                if ($fileType !== 'application/pdf') {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid file type']);
                    return;
                }

                $uploadDir = dirname(__DIR__, 2) . "/public/uploads/chat/files/{$from}";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0775, true);
                }

                $safeFileName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName);
                $targetPath = "$uploadDir/$safeFileName";

                if (move_uploaded_file($fileTmpPath, $targetPath)) {
                    $relativePath = "/uploads/chat/files/{$from}/$safeFileName";
                    $fileMessage = "FILE::$relativePath";
                    $fileUploaded = true;
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'File upload failed']);
                    return;
                }
            }

            // Insert message if there is a file or text
            if (!empty($message) || $fileUploaded) {
                $finalMessage = $fileUploaded ? $fileMessage : $message;
                $this->chatModel->sendMessage($from, $to, $finalMessage);
            }

            echo json_encode(['status' => 'success']);
        }
    }

    public function uploadFile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $userId = $_SESSION['user_id'];

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['error' => 'No file uploaded or upload error.']);
            return;
        }

        $file = $_FILES['file'];
        $allowedMime = ['application/pdf'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array(mime_content_type($file['tmp_name']), $allowedMime)) {
            http_response_code(400);
            echo json_encode(['error' => 'Only PDF files are allowed.']);
            return;
        }

        if ($file['size'] > $maxSize) {
            http_response_code(400);
            echo json_encode(['error' => 'File exceeds maximum size of 5MB.']);
            return;
        }

        // Create directory if it doesn't exist
        $uploadDir = dirname(__DIR__, 2) . "/public/uploads/chat/files/$userId/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', basename($file['name']));
        $destination = $uploadDir . $safeName;
        $publicUrl = "/uploads/chat/files/$userId/" . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to move uploaded file.']);
            return;
        }

        // Return JSON-style message to be saved in DB
        $message = json_encode([
            'type' => 'file',
            'url'  => $publicUrl,
            'name' => $file['name']
        ]);

        echo json_encode(['success' => true, 'message' => $message]);
    }

    public function deleteMessage()
    {
        $messageId = $_POST['messageId'];
        $userId = $_SESSION['user_id'];

        $deleted = $this->chatModel->deleteMessage($messageId, $userId);

        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode([
                'success' => false,
                'error'   => 'Could not delete message.'
            ]);
        }
    }

    public function editMessage()
    {
        $messageId = $_POST['message_id'] ?? null;
        $newMessage = trim($_POST['new_message'] ?? '');

        if (!is_numeric($messageId)) {
            echo json_encode(['success' => false, 'error' => 'Message ID must be a valid number.']);
            return;
        }

        if (trim($newMessage) === '') {
            echo json_encode(['success' => false, 'error' => 'Message cannot be empty.']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;

        // ✅ Correctly call the model method
        $success = $this->chatModel->editMessage($messageId, $userId, $newMessage);

        echo json_encode(['success' => $success]);
    }

    public function fetchUnread()
    {
        $userId = $_SESSION['user_id'];
        $unreadMessages = $this->chatModel->getUnreadMessagesGrouped($userId);

        echo json_encode($unreadMessages);
    }

    public function markAsRead()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $senderId = $input['sender_id'] ?? null;
        $userId = $_SESSION['user_id'];

        if (!$senderId || !is_numeric($senderId)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de remitente inválido']);
            return;
        }

        $this->chatModel->markMessagesAsRead($senderId, $userId);
        echo json_encode(['success' => true]);
    }
}
