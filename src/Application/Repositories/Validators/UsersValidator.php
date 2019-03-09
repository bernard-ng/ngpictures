<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */


namespace Application\Repositories\Validators;

use Framework\Repositories\ValidationInterface;
use Respect\Validation\Validator as v;

/**
 * Class UsersValidator
 * @package Application\Repositories\Validators
 */
class UsersValidator implements ValidationInterface
{

    /**
     * @var array
     */
    private static $resetValidationRules;

    /**
     * @var array
     */
    private static $forgotValidationRules;

    /**
     * @var array
     */
    private static $loginValidationRules;

    /**
     * @var array
     */
    private static $registerValidationRules;

    /**
     * Retrieve validation rules
     * @return array
     */
    public static function getValidationRules(): array
    {
        if (empty(self::$registerValidationRules)) {
            self::$registerValidationRules = [
                'email' => v::notEmpty()->email()->setName("Email"),
                'name' => v::notEmpty()->notBlank()->alpha()->setName('Name'),
                'password' => v::notEmpty()->length(6)->setName('Password'),
            ];
        }
        return self::$registerValidationRules;

    }

    /**
     * Retrieve update validation rules
     * @return array
     */
    public static function getUpdateValidationRules(): array
    {
        // TODO: Implement getUpdateValidationRules() method.
    }

    /**
     * Retrieve the list of storeable fields
     * @return array
     */
    public static function getStoreAbleFields(): array
    {
        // TODO: Implement getStoreAbleFields() method.
    }

    /**
     * Retrieve the list of updateable fields
     * @return array
     */
    public static function getUpdateAbleFields(): array
    {
        // TODO: Implement getUpdateAbleFields() method.
    }


    /**
     * @return array
     */
    public static function getResetValidationRules(): array
    {
        if (empty(self::$resetValidationRules)) {
            self::$resetValidationRules = [
                'password' => v::notEmpty()->length(6)->setName("Le password"),
                'password_confirm' => v::notEmpty()->length(6)->setName("Le password confirm")
            ];
        }
        return self::$resetValidationRules;
    }

    /**
     * @return array
     */
    public static function getForgotValidationRules(): array
    {
        if (empty(self::$forgotValidationRules)) {
            self::$forgotValidationRules = [
                'email' => v::notEmpty()->email()->setName("Email"),
            ];
        }
        return self::$forgotValidationRules;
    }

    /**
     * @return array
     */
    public static function getLoginValidationRules(): array
    {
        if (empty(self::$loginValidationRules)) {
            self::$loginValidationRules = [
                'name' => v::notEmpty()->setName("Pseudo ou email"),
                'password' => v::notEmpty()->setName("Password")
            ];
        }
        return self::$loginValidationRules;
    }
}
