<?php
namespace Application\Repositories;

use Application\Entities\UsersEntity;
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

    /**
     * @param int $id
     * @return mixed
     */
    public function findNotConfirmed(int $id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->where("id = ? AND confirmed_at IS NULL", [$id])
            ->all()->get(0);
    }


    /**
     * @param string $value
     * @return mixed
     */
    public function findWithEmailOrName(string $value)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->where("{$this->table}.email =  ? OR {$this->table}.name = ?", [$value, $value])
            ->all()->get(0);
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

    /**
     * @param string $email
     * @return mixed
     */
    public function findWithEmail(string $email)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->where("{$this->table}.email = ? AND confirmed_at IS NOT NULL", [$email])
            ->orderBy("{$this->table}.id DESC")
            ->all()->get(0);
    }

    /**
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->where("{$this->table}.{$field} = ?", [$value])
            ->all()->get(0);
    }

    /**
     * @param string $field
     * @param string $value
     * @return bool
     */
    public function isUniqueWith(string $field, $value): bool
    {
        return !boolval($this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->where("{$this->table}.{$field} = ? AND confirmed_at IS NOT NULL", [$value])
            ->orderBy("{$this->table}.id DESC")
            ->all()->get(0));
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
