<?php
namespace Ng\Core\Managers;

use \RuntimeException;
use Ngpictures\Managers\MessageManager;

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
    public function __construct(MessageManager $msg)
    {
        $this->msg  = $msg;
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
            if (preg_match("#([a-z_]+)(\[.+\])#i", $rule, $matches)) {
                $method     =   $matches[1];
                $param      =   str_replace(['[', ']'], '', $matches[2]);
                if (method_exists($this, $method)) {
                    call_user_func_array([$this, $method], [$field, $param]);
                } else {
                    throw new RuntimeException("method {$method} does not exists");
                }
            } else {
                if (method_exists($this, $rule)) {
                    call_user_func_array([$this, $rule], [$field]);
                } else {
                    throw new RuntimeException("method {$rule} does not exists");
                }
            }
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
     * @param array|string $rule
     * @return void
     */
    public function setRule(string $field, $rule)
    {
        if (is_array($rule)) {
            foreach ($rule as $r) {
                $this->rules[$field] = $r;
            }
        } else {
            $this->rules[$field] = $rule;
        }
    }



    //VALIDATION METHODS
    //----------------------------------------------------------------------------------------------

    /**
     * le champ ne doit pas etre vide
     * @param string $field
     * @return void
     */
    private function required(string $field)
    {
        if ($this->getValue($field) === '' && trim($this->getValue($field) === '')) {
            $this->errors[$field] = $this->msg['form_empty_field'];
            return;
        }
        return;
    }


    /**
     * le champ doit etre unique
     *
     * @param string $field
     * @param mixed $table
     * @param string $msg
     * @return void
     */
    public function unique(string $field, $table, string $msg)
    {
        $this->required($field);
        $unexpected = $table->findWith($field, $this->getValue($field));
        if ($unexpected) {
            $this->errors[$field] = $msg;
            return;
        }
        return;
    }



    /**
     * le champ doit etre superieur ou egale
     * @param string $field
     * @param integer $min_length
     * @return void
     */
    private function min_length(string $field, int $min_length)
    {
        $this->required($field);
        if (mb_strlen($this->getValue($field)) < $min_length) {
            $this->errors[$field] = sprintf("le %s doit faire au moins %d caractères", $field, $min_length);
            return;
        }
        return;
    }


    /**
     * le champ doit egal a un autre
     *
     * @param string $field
     * @param string $expected_match
     * @return void
     */
    private function matches(string $field, string $expected_match)
    {
        $this->required($field);
        if ($this->getValue($field) !== $this->getValue($expected_match)) {
            $this->errors[$field]           =   $this->msg["form_invalid_password"];
            $this->errors[$expected_match]  =   $this->msg['form_invalid_password'];
            return;
        }
        return;
    }


    /**
     * le champ doit etre alpha
     *
     * @param string $field
     * @return void
     */
    private function alpha(string $field)
    {
        $this->required($field);
        if (ctype_alpha($this->getValue($field))) {
            $this->errors[$field] = $this->msg['form_invalid_alpha'];
            return;
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
            $this->errors[$field] = $this->msg["form_invalid_alnum"];
            return;
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
        if (!preg_match('/^[a-z0-9-]+$/i', $this->getValue($field))) {
            $this->errors[$field] = $this->msg["form_invalid_username"];
            return;
        }
        return;
    }


    /**
     * le champ doit etre un num
     *
     * @param int $field
     * @return void
     */
    private function numeric($field)
    {
        if (!preg_match('/^[\-+]?[0-9-]+$/', $field)) {
            $this->errors[$field] = $this->msg["form_invalid_data"];
            return;
        }
        return;
    }


    /**
     * Valid URL
     *
     * @param string $field
     * @author CodeIngniter Framework
     * @return bool
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
            $this->errors[$field] = $this->msg["form_invalid_url"];
        }
        return true;
    }


    /**
     * Valid Email
     *
     * @param string
     * @author CodeIngniter Framework
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
            $this->errors[$field] = $this->msg["form_invalid_email"];
            return;
        }
        return;
    }
}
