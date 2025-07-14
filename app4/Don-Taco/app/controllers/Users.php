<?php

namespace App\controllers;

use App\helpers\Validator;
use App\Libraries\Controller;

class Users extends Controller
{
    private $userModel;

    public function __construct()
    {
        requireLogin();
        $this->userModel = $this->model('UserModel');
    }

    public function index()
    {
        $this->view('modules/users', [
            'loadStyles'            => true,
            'loadDataTableStyles'   => true,
            'loadToastStyle'        => true,
            'loadJQueryLibrary'     => true,
            'loadScriptSideBar'     => true,
            'loadDataTables'        => true,
            'loadDataTableUsers'    => true,
            'loadToasty'            => true
        ]);
    }

    public function fetch()
    {
        $user = $this->userModel->getUserInfo();
        $cleaned = [];

        foreach ($user as $row) {
            $cleaned[] = [
                'id'       => $row->id,
                'date'     => date('Y-m-d', strtotime($row->created_at)),
                'username' => $row->username,
                'email'    => $row->email,
                'passwd'   => '',
                'role'     => $row->role
            ];
        }

        echo json_encode($cleaned);
    }

    public function register()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $validator = new Validator();

        $rules = [
            'username' => ['required' => true, 'type' => 'string'],
            'email'    => ['required' => false, 'type' => 'email'],
            'passwd'   => ['required' => true, 'type' => 'password'],
            'role'     => ['required' => true, 'type' => 'string']
        ];

        if (!$validator->validate($data, $rules)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);

        if ($this->userModel->userExists($cleanData['email'], $cleanData['username'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ya existe un usuario con ese correo o nombre de usuario'
            ]);
            return;
        }

        $insertData = [
            'username'   => strtolower($cleanData['username']),
            'email'      => strtolower($cleanData['email']),
            'password'   => password_hash($cleanData['passwd'], PASSWORD_DEFAULT),
            'role'       => $cleanData['role'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->userModel->addUser($insertData);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Usuario registrado correctamente' : 'Error al registrar usuario'
        ]);
    }

    public function update($id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $validator = new Validator();

        $rules = [
            'username' => ['required' => true, 'type' => 'string'],
            'email'    => ['required' => false, 'type' => 'email'],
            'passwd'   => ['required' => false, 'type' => 'password'], // Opcional al editar
            'role'     => ['required' => true, 'type' => 'string']
        ];

        if (!$validator->validate($data, $rules)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Error de validación',
                'errors'  => $validator->errors()
            ]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);

        if ($this->userModel->userExists($cleanData['email'], $cleanData['username'], $id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ya existe un usuario con ese correo o nombre de usuario'
            ]);
            return;
        }

        $updateData = [
            'id'         => $id,
            'username'   => strtolower($cleanData['username']),
            'email'      => strtolower($cleanData['email']),
            'role'       => $cleanData['role'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Solo actualizar la contraseña si viene no vacía
        if (!empty($cleanData['passwd'])) {
            $updateData['password'] = password_hash($cleanData['passwd'], PASSWORD_DEFAULT);
        }

        $result = $this->userModel->updateUser($updateData['id'], $updateData);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Usuario actualizado correctamente' : 'Error al actualizar el usuario'
        ]);
    }

    public function delete($id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        if (!is_numeric($id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID inválido']);
            return;
        }

        $result = $this->userModel->deleteUser($id);

        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? '¡Usuario eliminado!' : '¡Error al eliminar el usuario!'
        ]);
    }
}
