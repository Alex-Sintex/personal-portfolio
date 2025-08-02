<?php

namespace App\controllers;

use App\Libraries\Controller;

class Notification extends Controller
{
    private $model;

    public function __construct()
    {
        requireLogin();
        $this->model = $this->model('NotificationModel');
    }

    public function fetch()
    {
        $userId = $_SESSION['user_id'];

        $notifications = $this->model->getAllNotifications($userId);
        $userModel = $this->model('UserModel');

        $data = [];

        foreach ($notifications as $notif) {
            $user = $userModel->findById($notif->user_id);
            $data[] = [
                'username' => $user ? $user->username : 'Usuario',
                'title' => $notif->title,
                'message' => $notif->message,
                'created_at' => $notif->created_at,
                'link' => $notif->link,
                'is_read' => $notif->is_read
            ];
        }

        echo json_encode($data);
    }

    public function markAllAsRead()
    {
        $userId = $_SESSION['user_id'];
        $result = $this->model->markAllAsRead($userId);
        echo json_encode(['success' => $result]);
    }

    public function count()
    {
        $userId = $_SESSION['user_id'];
        $total = $this->model->countUnread($userId);
        echo json_encode(['count' => $total]);
    }

    public function fetchGlobal()
    {
        $notifications = $this->model->getGlobalNotifications(10); // or any limit
        $userModel = $this->model('UserModel');

        $data = [];

        foreach ($notifications as $notif) {
            $user = $userModel->findById($notif->user_id);
            $data[] = [
                'username'   => $user ? $user->username : 'Usuario',
                'title'      => $notif->title,
                'message'    => $notif->message,
                'created_at' => $notif->created_at,
                'link'       => $notif->link,
                'is_read'    => $notif->is_read
            ];
        }

        echo json_encode($data);
    }
}
