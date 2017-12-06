<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;

use Ng\Core\Database\MysqlDatabase;


class UsersModel extends Model
{
    
    protected $db,
              $table = "users";


    public function add(string $name, string $email, string $password, string $token)
    {
        return $this->query(
            "INSERT INTO {$this->table}(name, email, password, reset_token) VALUES (?,?,?,?)",
            [$name, $email, $password, $token]
        );
    }


    public function getAdmin()
    {
        return $this->query("SELECT * FROM {$this->table} WHERE rank = 'admin' ");
    }


    public function lastRegisterUser()
    {
        return $this->db->lastInsertId();
    }


    public function checkResetToken(string $token, int $user_id)
    {
        $id = htmlspecialchars($user_id);
        return $this->query(
            "SELECT * FROM users WHERE reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 120 MINUTE) AND id = ? ",
            [$token, $user_id],
            true, true
        );
    }


    public function resetPassword(string $password, int $user_id)
    {
        $this->query(
            "UPDATE users SET password = ? , reset_token = NUll , reset_at = NULL WHERE id = ? ",
            [$password, $id]
        );
    }


    public function setResetToken(string $token, int $user_id)
    {
        return $this->query(
            "UPDATE {$this->table} SET reset_token = ? , reset_at = NOW() WHERE id = ?",
            [$token,$user_id]
        );
    }


    public function unsetConfirmationToken(int $user_id)
    {
        return $this->query(
            "UPDATE {$this->table} SET confirmation_token = NULL , confirmed_at = NOW() WHERE id = ?",
            [$user_id]
        );
    }


    public function setRememberToken(string $token, int $user_id)
    {
        return $this->query(
            "UPDATE {$this->table} SET remember_token = ? WHERE id = ?",
            [$token, $user_id]
        );
    }


    public function isNotConfirmed(int $user_id)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE id = ? AND confirmed_at IS NULL",
            [$user_id],
            true, true
        );
    }
}
