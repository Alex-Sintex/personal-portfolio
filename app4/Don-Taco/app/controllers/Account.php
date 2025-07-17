<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\Helpers\Validator;

class Account extends Controller
{
    private $accountModel;
    private $userModel;

    public function __construct()
    {
        requireLogin();
        $this->accountModel = $this->model('AccountModel');
        $this->userModel = $this->model('UserModel');
    }

    // Load account view with required resources
    public function index()
    {
        $user = $this->accountModel->getUserById($_SESSION['user_id']);

        $data = [
            'loadStyles'         => true,
            'loadToastStyle'     => true,
            'loadAccountStyle'   => true,
            'loadJQueryLibrary'  => true,
            'loadScriptSideBar'  => true,
            'loadToasty'         => true,
            'loadAccountScripts' => true,
            'user'               => $user
        ];
        $this->view('modules/profile', $data);
    }

    // Fetch all products
    public function fetch()
    {
        $user = $this->accountModel->getUsrAccountsInfo();
        $cleaned = [];

        foreach ($user as $row) {
            $cleaned[] = [
                'id'       => $row->id,
                'fname'    => $row->fname,
                'lname'    => $row->lname,
                'username' => $row->username,
                'email'    => $row->email,
                'image'    => $row->img
            ];
        }

        echo json_encode($cleaned);
    }

    // Update profile user
    public function update()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $data = $_POST;
        $validator = new Validator();

        $rules = [
            'firstname'   => ['required' => false, 'type' => 'string'],
            'lastname'    => ['required' => false, 'type' => 'string'],
            'email'       => ['required' => false, 'type' => 'email'],
            'phone'       => ['required' => false, 'type' => 'string'],
            'username'    => ['required' => false, 'type' => 'username'],
            'newPass'     => ['required' => false, 'type' => 'password'],
            'currentPass' => ['required' => true, 'type' => 'string']
        ];

        if (!$validator->validate($data, $rules)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Validación fallida',
                'errors' => $validator->errors()
            ]);
            return;
        }

        $data = $validator->sanitize($data);
        $userId = $_SESSION['user_id'];
        $user = $this->accountModel->getUserById($userId);

        if (!$user) {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
            return;
        }

        if (!password_verify($data['currentPass'], $user->password)) {
            echo json_encode(['status' => 'error', 'message' => 'Contraseña actual incorrecta']);
            return;
        }

        // Verificación de email único
        if (!empty($data['email']) && strtolower($data['email']) !== strtolower($user->email)) {
            if ($this->userModel->userExists($data['email'], $user->username, $userId)) {
                echo json_encode(['status' => 'error', 'message' => 'Correo ya en uso']);
                return;
            }
        }

        // Verificación de username único
        if (!empty($data['username']) && strtolower($data['username']) !== strtolower($user->username)) {
            if ($this->userModel->userExists($user->email, $data['username'], $userId)) {
                echo json_encode(['status' => 'error', 'message' => 'Nombre de usuario ya en uso']);
                return;
            }
        }

        // Construir datos a actualizar
        $updateData = [];
        if (!empty($data['firstname'])) $updateData['fname'] = $data['firstname'];
        if (!empty($data['lastname'])) $updateData['lname'] = $data['lastname'];
        if (!empty($data['email'])) $updateData['email'] = $data['email'];
        if (!empty($data['phone'])) $updateData['phone'] = $data['phone'];
        if (!empty($data['username'])) $updateData['username'] = $data['username'];

        // Nueva contraseña
        if (!empty($data['newPass'])) {
            $updateData['password'] = password_hash($data['newPass'], PASSWORD_DEFAULT);
        }

        // Subir imagen
        if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profile_img'];
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $maxSize = 1024 * 1024;

            $fileType = mime_content_type($file['tmp_name']);
            if (!in_array($fileType, $allowedTypes)) {
                echo json_encode(['status' => 'error', 'message' => 'Solo se permiten imágenes JPG o PNG']);
                return;
            }

            if ($file['size'] > $maxSize) {
                echo json_encode(['status' => 'error', 'message' => 'La imagen debe pesar menos de 1MB']);
                return;
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'profile.' . strtolower($ext);
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/users/{$userId}";

            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $filePath = $uploadDir . '/' . $fileName;
            if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo guardar la imagen']);
                return;
            }

            $updateData['img'] = $fileName;
            $_SESSION['user']->img = $fileName;
        }

        $result = $this->accountModel->updateProfile($userId, $updateData);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Perfil actualizado correctamente' : 'No se realizaron cambios'
        ]);
    }

    // Delete account permanently
    public function delete()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
            return;
        }

        // Obtener input JSON
        $input = json_decode(file_get_contents('php://input'), true);
        $password = trim($input['password'] ?? '');

        if (empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'La contraseña es obligatoria']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->accountModel->getUserById($userId);

        if (!$user || !password_verify($password, $user->password)) {
            echo json_encode(['status' => 'error', 'message' => 'Contraseña incorrecta']);
            return;
        }

        // Eliminar carpeta de imágenes
        $userDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/users/{$userId}";
        if (is_dir($userDir)) $this->deleteDirectory($userDir);

        // Eliminar cuenta
        if ($this->accountModel->deleteUserById($userId)) {
            session_unset();
            session_destroy();
            echo json_encode(['status' => 'success', 'message' => '¡Cuenta eliminada correctamente!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la cuenta']);
        }
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) return true;

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;

            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        return rmdir($dir);
    }

    // Update user status
    public function update_status()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            echo json_encode(['status' => 'error', 'message' => 'No user logged in']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $status = $data['status'] ?? '';

        $result = $this->accountModel->updateStatus($userId, ['status' => $status]);

        if ($result) {
            $_SESSION['user_status'] = $status; // ✅ Persist in session
            echo json_encode([
                'status' => 'success',
                'message' => '¡Estatus actualizado!',
                'newStatus' => $status
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => '¡Error al actualizar el estatus!'
            ]);
        }
    }
}
