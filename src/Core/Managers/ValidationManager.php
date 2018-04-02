<?php
namespace Ng\Core\Managers;

use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Managers\MessageManager;

class ValidationManager
{

    /**
     * les donnees a valider
     * @var array
     */
    private $data = [];

    /**
     * les errors rencontrer
     * @var array
     */
    private $errors = [];

    /**
     * les regles de validation
     * @var array
     */
    private $rules = [];


    /**
     * ValidationManager constructor
     * @param array $data
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->data = $_POST;
    }


    /**
     * recupere un champ dans les donnees a valider
     * @param string $field
     * @return mixed
     */
    private function getValue(string $field)
    {
        return $this->data[$field] ?? null;
    }


    /**
     * renseigne si les donnees sont valides
     * @return boolean
     */
    public function isValid(): bool
    {
        foreach ($this->rules as $field => $rule) {
            call_user_func_array([$this, $rule], [$field]);
        }
        return empty($this->errors);
    }


    /**
     * renvoi les erreurs rencontrer
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }


    /**
     * definition de regle de validation
     *
     * @param string $field
     * @param string $rule
     * @return void
     */
    public function setRule(string $field, string $rule)
    {
        $this->rules[$field] = $rule;
    }



    //VALIDATION METHODS
    //----------------------------------------------------------------------------------------------

    /**
     * le champ ne doit pas etre vide
     * @param string $field
     * @return boolean
     */
    private function required(string $field)
    {
        if ($this->getValue($field) === '' && trim($this->getValue($field) === '')) {
            $this->errors[$field] = MessageManager::get('form_empty_field');
        }
        return;
    }


    /**
     * le champ doit etre alpha
     *
     * @param string $field
     * @return boolean
     */
    private function alpha(string $field)
    {
        $this->required($field);
        if (ctype_alpha($this->getValue($field))) {
            $this->errors[$field] = MessageManager::get('form_invalid_alpha');
        }
        return;
    }


    /**
     * le champ doit etre alphanum
     *
     * @param string $field
     * @return void
     */
    private function alpha_num(string $field)
    {
        $this->required($field);
        if (ctype_alnum($this->getValue($field))) {
            $this->errors[$field] = MessageManager::get("form_invalid_alnum");
        }
        return;
    }


    /**
     * le champ doit etre alnum et - ou _
     *
     * @param string $field
     * @return void
     */
    private function alpha_dash(string $field)
    {
        $this->required($field);
        if (!preg_match('/^[a-z0-9_-]+$/i', $this->getValue($field))) {
            $this->errors[$field] = MessageManager::get("form_invalid_username");
        }
        return;
    }


    /**
     * Valid URL
     *
     * @param string  $field
     */
    private function valid_url($field)
    {
        $this->required($field);
        $url = $this->getValue($field);

        if (preg_match('/^(?:([^:]*)\:)?\/\/(.+)$/', $url, $matches)) {
            if (empty($matches[2])) {
                return false;
            } elseif (! in_array(strtolower($matches[1]), ['http', 'https'], true)) {
                return false;
            }

            $url = $matches[2];
        }

        if (preg_match('/^\[([^\]]+)\]/', $url, $matches) &&
                ! version_compare(PHP_VERSION, "7", '>=') &&
                filter_var($matches[1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false
            ) {
            $url = 'ipv6.host'.substr($url, strlen($matches[1]) + 2);
        }

        if (filter_var('http://'.$url, FILTER_VALIDATE_URL) !== false) {
            $this->errors[$field] = MessageManager::get("form_invalid_url");
        }
        return;
    }


    /**
     * Valid Email
     *
     * @param string
     */
    private function valid_email($field)
    {
        $this->required($field);
        $email = $this->getValue($field);

        if (function_exists('idn_to_ascii') && preg_match('#\A([^@]+)@(.+)\z#', $email, $matches)) {
            $domain = (version_compare(PHP_VERSION, "5.4", '>='))
                ? idn_to_ascii($matches[2], 0, INTL_IDNA_VARIANT_UTS46)
                : idn_to_ascii($matches[2]);
            $email = $matches[1].'@'.$domain;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = MessageManager::get("form_invalid_email");
        }
        return;
    }
}
