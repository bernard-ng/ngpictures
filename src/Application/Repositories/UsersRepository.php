<?php
namespace Application\Repositories;

use Framework\Repositories\Repository;

class UsersRepository extends Repository
{

    /**
     * le nom de la table dans la base de donnee
     * @var string
     */
    protected $table = "users";


    /**
     * creation d'un nouvel utilisateur
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $token
     * @return mixed
     */
    public function add(string $name, string $email, string $password, string $token)
    {
        return $this->query(
            "INSERT INTO {$this->table}(name, email, password, confirmation_token, avatar) VALUES (?,?,?,?,?)",
            [$name, $email, $password, $token, "default.jpg"]
        );
    }


    /**
     * recuperation des admins
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->query("SELECT * FROM {$this->table} WHERE rank = 'admin' ");
    }


    /**
     * verifiation du reset password token
     * @param string $token
     * @param int $users_id
     * @return mixed
     */
    public function checkResetToken(string $token, int $users_id)
    {
        return $this->query(
            "SELECT * FROM users WHERE (reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 120 MINUTE)) AND id = ? ",
            [$token, $users_id],
            true,
            true
        );
    }


    /**
     * mise a jour du mot de passe
     * @param string $password
     * @param int $users_id
     */
    public function resetPassword(string $password, int $users_id)
    {
        $this->query(
            "UPDATE users SET password = ? , reset_token = NUll , reset_at = NULL WHERE id = ? ",
            [$password, $users_id]
        );
    }


    /**
     * creation du reset token
     * @param string $token
     * @param int $users_id
     * @return mixed
     */
    public function setResetToken(string $token, int $users_id)
    {
        return $this->query(
            "UPDATE {$this->table} SET reset_token = ? , reset_at = NOW() WHERE id = ?",
            [$token,$users_id]
        );
    }


    /**
     * suppression du token de confirmation
     * @param int $users_id
     * @return mixed
     */
    public function unsetConfirmationToken(int $users_id)
    {
        return $this->query(
            "UPDATE {$this->table} SET confirmation_token = NULL , confirmed_at = NOW() WHERE id = ?",
            [$users_id]
        );
    }


    /**
     * creation du rememeber token pour les cookies
     * @param string $token
     * @param int $users_id
     * @return mixed
     */
    public function setRememberToken(string $token, int $users_id)
    {
        return $this->query(
            "UPDATE {$this->table} SET remember_token = ? WHERE id = ?",
            [$token, $users_id]
        );
    }


    /**
     * renvoi un utilisateur non confirmer
     * @param int $users_id
     * @return mixed
     */
    public function isNotConfirmed(int $users_id)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE id = ? AND confirmed_at IS NULL",
            [$users_id],
            true,
            true
        );
    }


    /**
     * permet de trouver un utilisateur soit avec son email
     * soit son pseudo
     * @param array $field
     * @param string $value
     * @return mixed
     */
    public function findAlternative(array $field, string $value)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE ({$field[0]} = :{$field[0]} OR {$field[1]} = :{$field[0]})",
            [$field[0] => $value],
            true,
            true
        );
    }


    /**
     * renvoi le dernier utilisateur
     * @return mixed
     */
    public function last()
    {
        return $this->query(
            "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT 1",
            null,
            true,
            true
        );
    }


    public function get($limit)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE confirmed_at IS NOT NULL ORDER BY id DESC LIMIT {$limit}"
        );
    }


    /**
     * @return mixed
     */
    public function lastConfirmed()
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE confirmed_at IS NOT NULL ",
            null,
            true,
            false
        );
    }

    /**
     * recupere un enregistrement avec une contrainte
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value, $one = true)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE {$field} = ? AND confirmed_at IS NOT NULL ORDER BY id DESC",
            [$value],
            true,
            $one
        );
    }


    public function findLess($post_id)
    {
        return $this->query(
            "SELECT * FROM {$this->table}
            WHERE confirmed_at IS NOT NULL AND {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 8",
            [$post_id]
        );
    }

    /**
     * @return mixed
     */
    public function lastNotConfirmed()
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE confirmed_at IS NULL",
            null,
            true,
            false
        );
    }
}
