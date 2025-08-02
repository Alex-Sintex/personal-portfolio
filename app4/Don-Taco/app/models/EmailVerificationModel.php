<?php
namespace App\Models;

use App\Libraries\Base;

class EmailVerificationModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function findByToken($token)
    {
        $this->db->query("SELECT * FROM email_verifications WHERE token = :token LIMIT 1");
        $this->db->bind(':token', $token);
        return $this->db->record();
    }

    public function deleteById($id)
    {
        return $this->db->delete('email_verifications', 'id = :id', ['id' => $id]);
    }

    public function deleteExpiredTokens()
    {
        $this->db->query("DELETE FROM email_verifications WHERE expires_at < NOW()");
        return $this->db->execute();
    }
}
