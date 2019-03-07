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
 * Class BookingValidator
 * @package Application\Repositories\Validators
 */
class BookingValidator implements ValidationInterface
{

    /**
     * Validation rules
     * @var array
     */
    private static $validationRules = [];

    /**
     * List of fields that can be stored in the Repository
     * @var array
     */
    private static $storeAbleFields = [];

    /**
     * Retrieve validation rules
     * @return array
     */
    public static function getValidationRules(): array
    {
        if (empty(self::$validationRules)) {
            self::$validationRules = [
                'email' => v::notEmpty()->email()->setName('l\'email'),
                'name' => v::notEmpty()->setName('votre nom'),
                'date' => v::notEmpty()->setName('la date'),
                'time' => v::notEmpty()->setName('l\'heure'),
                'description' => v::notEmpty()->setName('la description'),
                'phone_number' => v::notEmpty()->setName('votre numéro mobile')
            ];
        }
        return self::$validationRules;
    }

    /**
     * Retrieve update validation rules
     * @return array
     */
    public static function getUpdateValidationRules(): array
    {
        return [];
    }

    /**
     * Retrieve the list of storeable fields
     * @return array
     */
    public static function getStoreAbleFields(): array
    {
        if (empty(self::$storeAbleFields)) {
            self::$storeAbleFields = array_keys(self::getValidationRules());
        }
        return self::$storeAbleFields;
    }

    /**
     * Retrieve the list of updateable fields
     * @return array
     */
    public static function getUpdateAbleFields(): array
    {
        return [];
    }
}
