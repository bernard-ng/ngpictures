<?php
namespace Ng\Core\Managers;

use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Managers\MessageManager as Msg;

class ValidationManager
{
    /**
     * les donnees a valider
     * @var array
     */
    private $data;

    /**
     * stock les differentes erreurs
     * @var array
     */
    private $errors = [];


    /**
     * la base de donnee pour les validations complexes
     * @var MysqlDatabase
     */
    private $db;

    /**
     * l'objet qui gere les msg flash
     * @var FlashMessageManager
     */
    private $flash;


    /**
     * Validator constructor.
     * @param MysqlDatabase $db
     * @param Flash $flash
     * @param array $data
     */
    public function __construct(MysqlDatabase $db, FlashMessageManager $flash, array $data = [])
    {
        $this->db = $db;
        $this->data = $data;
        $this->flash = $flash;
    }

    /**
     * recupere une donnee dans la tableau de donnee d'instance
     * @param string $field
     * @return mixed|null
     */
    private function getField(string $field)
    {
        return $this->data[$field] ?? null ;
    }


    /**
     * expression reguliere pour le nom d'utilisateur
     * @param string $field
     * @param string|null $errorMsg
     */
    public function isKebabCase(string $field, string $errorMsg = null)
    {
        if (!preg_match('/^[a-zA-Z0-9-_]+$/', $this->getField($field))) {
            $this->errors[$field] = $errorMsg ?? Msg::get['isKebabCase'];
            $this->flash->set('danger', $errorMsg ?? Msg::get['isKebabCase']);
        }
    }


    /**
     * permet de dire si une donne est unique
     * @param string $field
     * @param $table
     * @param string|null $errorMsg
     */
    public function isUnique(string $field, $table, string $errorMsg = null)
    {
        $field = StringManager::escape($field);
        $req = $table->query(
            "SELECT id FROM {$table->getTable()} WHERE {$field} = ?",
            [$this->getField($field)],
            true,
            true
        );

        if ($req) {
            $this->errors[$field] = $errorMsg ?? Msg::get('isUnique');
            $this->flash->set('danger', $errorMsg ?? Msg::get('isUnique'));
        }
    }


    /**
     * permet de verifier si la donnee est un email
     * @param string $field
     * @param string|null $errorMsg
     */
    public function isEmail(string $field, string $errorMsg = null)
    {
        if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $errorMsg ?? Msg::get('isEmail');
            $this->flash->set('danger', $errorMsg ?? Msg::get('isEmail'));
        }
    }


    /**
     * permet de verifier si deux donnee correspondent
     * @param string $field
     * @param string $field2
     * @param string|null $errorMsg
     */
    public function isMatch(string $field, string $field2, string $errorMsg = null)
    {
        if (empty($this->getField($field)) || $this->getField($field) != $this->getField($field2)) {
            $this->errors[$field] = $errorMsg ?? Msg::get('isMatch');
            $this->flash->set('danger', $errorMsg ?? Msg::get('isMatch'));
        }
    }


    public function isGreaterThan(string $field, int $size, string $errorMsg = null)
    {
        if (strlen($this->getField($field) >= $size)) {
            return true;
        } else {
            $this->errors[$field] = $errorMsg ?? Msg::get('isMatch');
            $this->flash->set('danger', $errorMsg ?? Msg::get('isMatch'));
        }
    }


    /**
     * verifie si le champ est vide
     * @param string $field
     * @param string $errorMsg
     */
    public function isEmpty(string $field, string $errorMsg)
    {
        if (empty($this->getField($field))) {
            $this->errors[$field] = $errorMsg ?? Msg::get('isEmpty');
            $this->flash->set('danger', $errorMsg ?? Msg::get('isEmpty'));
        }
    }


    /**
     * permet de dire si toutes les donnees sont valides
     * @return bool
     */
    public function isValid()
    {
        return empty($this->errors);
    }


    /**
     * return le tableau d'erreur
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
