<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */


namespace Application\Events\Auth;


use Framework\Managers\Mailer\Mailer;
use League\Event\AbstractListener;
use League\Event\EventInterface;

/**
 * Class UserForgotListener
 * @package Application\Events
 */
class UserForgotListener extends AbstractListener
{

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * UserRegisterListener constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @param array|null $args
     * @return void
     */
    public function handle(EventInterface $event, ?array $args = [])
    {
        $this->mailer->resetPassword($args['link'], $args['email']);
    }
}