<?php

use App\models\UserModel;

function timeAgo($datetime)
{
    $time = strtotime($datetime);
    $diff = time() - $time;

    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' mins ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    return date('d M Y', $time);
}

function getUserName($userId)
{
    static $userCache = [];

    if (!isset($userCache[$userId])) {
        $model = new UserModel();
        $user = $model->findById($userId);
        $userCache[$userId] = $user ? $user->username : 'Usuario';
    }

    return $userCache[$userId];
}
