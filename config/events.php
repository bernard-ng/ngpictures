<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 * @param EmitterInterface $emitter
 * @param ContainerInterface $container
 */


use Application\Events\UserRegisterEvent;
use Application\Events\UserRegisterListener;
use League\Event\EmitterInterface;
use Psr\Container\ContainerInterface;


return function (EmitterInterface $emitter, ContainerInterface $container) {

    $emitter->addListener(UserRegisterEvent::class, $container->get(UserRegisterListener::class));
    $emitter->addListener(UserRegisterEvent::class, $container->get(UserRegisterListener::class));
    $emitter->addListener(UserRegisterEvent::class, $container->get(UserRegisterListener::class));

};
