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
 * Class ContactValidator
 * @package Application\Repositories\Validators
 */
class ContactValidator implements ValidationInterface
{

    /**
     * @var array
     */
    private static $validationRules = [];

    /**
     * Retrieve validation rules
     * @return array
     */
    public static function getValidationRules(): array
    {
        if(!empty(self::$validationRules)) {
            self::$validationRules = [
                'name' => v::notEmpty()->alpha()->setName('Le nom'),
                'email' => v::notEmpty()->email()->setName('L\'Email'),
                'message' => v::notEmpty()->notBlank()->setName('Le Message'),
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
}