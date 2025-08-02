<?php

namespace App\Helpers;

use App\Libraries\Base;

class NotificationHelper
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function send(array $data): bool
    {
        $required = ['user_id', 'type', 'title'];
        foreach ($required as $field) {
            if (empty($data[$field])) return false;
        }

        $data = array_merge([
            'message' => '',
            'link'    => '',
            'is_read' => 0,
        ], $data);

        return $this->db->insert('notifications', $data);
    }
}
