<?php

namespace Framework\Repositories;

/**
 * Interface ValidationInterface
 * @package Framework\Repositories
 */
interface ValidationInterface
{

    /**
     * Retrieve validation rules
     * @return array
     */
    public static function getValidationRules(): array;

    /**
     * Retrieve update validation rules
     * @return array
     */
    public static function getUpdateValidationRules(): array;

    /**
     * Retrieve the list of storeable fields
     * @return array
     */
    public static function getStoreAbleFields(): array;

    /**
     * Retrieve the list of updateable fields
     * @return array
     */
    public static function getUpdateAbleFields(): array;
}
