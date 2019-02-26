<?php
namespace Application\Repositories;

use Application\Entity\UsersEntity;
use Framework\Repositories\Repository;

/**
 * Class UsersRepository
 * @package Application\Repositories
 */
class UsersRepository extends Repository
{

    /**
     * @var string
     */
    protected $table = "users";

    /**
     * @var string
     */
    protected $entity = UsersEntity::class;



    public function add(string $name, string $email, string $password, string $token)
    {
        return "INSERT INTO {$this->table}(name, email, password, confirmation_token, avatar) VALUES (?,?,?,?,?)";
    }

    public function getAdmin()
    {
        return "SELECT * FROM {$this->table} WHERE role = 'admin' ";
    }

    public function checkResetToken(string $token, int $users_id)
    {
        return "SELECT * FROM users WHERE (reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 120 MINUTE)) AND id = ? ";
    }

    public function resetPassword(string $password, int $users_id)
    {
        return "UPDATE users SET password = ? , reset_token = NUll , reset_at = NULL WHERE id = ? ";
    }

    public function setResetToken(string $token, int $users_id)
    {
        return "UPDATE {$this->table} SET reset_token = ? , reset_at = NOW() WHERE id = ?";
    }

    public function unsetConfirmationToken(int $users_id)
    {
        return "UPDATE {$this->table} SET confirmation_token = NULL , confirmed_at = NOW() WHERE id = ?";
    }

    public function setRememberToken(string $token, int $users_id)
    {
        return "UPDATE {$this->table} SET remember_token = ? WHERE id = ?";
    }

    public function isNotConfirmed(int $users_id)
    {
        return "SELECT * FROM {$this->table} WHERE id = ? AND confirmed_at IS NULL";
    }

    public function findAlternative(array $field, string $value)
    {
        return "SELECT * FROM {$this->table} WHERE ({$field[0]} = :{$field[0]} OR {$field[1]} = :{$field[0]})";
    }

    public function last()
    {
        return "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT 1";
    }

    public function get($limit)
    {
        return "SELECT * FROM {$this->table} WHERE confirmed_at IS NOT NULL ORDER BY id DESC LIMIT {$limit}";
    }

    public function lastConfirmed()
    {
        return "SELECT * FROM {$this->table} WHERE confirmed_at IS NOT NULL ";
    }

    public function findWith(string $field, $value, $one = true)
    {
        return "SELECT * FROM {$this->table} WHERE {$field} = ? AND confirmed_at IS NOT NULL ORDER BY id DESC";
    }

    public function findLess($post_id)
    {
        return "SELECT * FROM {$this->table} WHERE confirmed_at IS NOT NULL AND {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 8";
    }

    public function lastNotConfirmed()
    {
        return "SELECT * FROM {$this->table} WHERE confirmed_at IS NULL";
    }
}
