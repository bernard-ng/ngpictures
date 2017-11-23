<?php
namespace Core\Generic;
use Core\Database\MysqlDatabase;
use \Ngpic;

class Validator
{
    private $data;
    private $db;
    private $errors = [];
    public $msg = [

        "isKebabCase" => "votre pseudo n'est pas valide",
        "isUnique" => "cet information est deja utiliser",
        "isEmail" => "cet adresse mail n'est pas valide",
        "isMatch" => "ce deux champs ne correspondent pas",
        "invalidCaptcha" => "le captcha n'est pas valide"

    ];

    public function __construct(MysqlDatabase $db,array $data)
    {
        $this->db = $db;
        $this->data = $data;
    }

    private function getField(string $field)
    {
        return $this->data[$field] ?? null ;
    }

    public function isKebabCase(string $field, string $errorMsg = null)
    { 
        if (!preg_match('/^[a-zA-Z0-9_]+$/',$this->getField($field))) {
            $this->errors[$field] = $errorMsg ?? $this->msg['isKebabCase'];
        }
    }

    public function isUnique(string $field, $table, string $errorMsg = null)
    {
        $field = Str::escape($field);
        $req = $table->query(
            "SELECT id FROM {$table->getTable()} WHERE {$field} = ?",
            [$this->getField($field)],
            true, true
        );

        if ($req) {
            $this->errors[$field] = $errorMsg ?? $this->msg['isUnique'];
        }
    }

    public function isEmail(string $field, string $errorMsg = null)
    {
        if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $errorMsg ?? $this->msg['isEmail'];
        }
    }

    public function isMatch(string $field, string $field2, string $errorMsg = null) 
    {
        if (empty($this->getField($field)) || $this->getField($field) != $this->getField($field2)) {
           $this->errors[$field] = $errorMsg ?? $this->msg['isMatch'];
        }
    }

    public function isValidCaptcha($field, $session, string $msg = null)
    {
        if (empty($this->getField($field)) || intval($this->getField($field)) !== $session->read('captcha')) {
            $this->errors[$field] = $errorMsg ?? $this->msg['invalidCaptcha'];
        }
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors ?? null;
    }

}