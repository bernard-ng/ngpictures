<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

/**
 * Created by PhpStorm.
 * User: Bernard-ng
 * Date: 3/8/2019
 * Time: 4:44 PM
 */

namespace Application\Events;


use League\Event\AbstractEvent;

/**
 * Class UserRegisterEvent
 * @package Application\Events
 */
class UserRegisterEvent extends AbstractEvent
{
    /**
     * Get the event name.
     *
     * @return string
     */
    public function getName()
    {
        return static::class;
    }
}