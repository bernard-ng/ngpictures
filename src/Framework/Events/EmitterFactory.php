<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */


namespace Framework\Events;

use League\Event\Emitter;
use Psr\Container\ContainerInterface;

/**
 * Class EmiterFactory
 * @package Framework\Events
 */
class EmitterFactory
{

    /**
     * @param ContainerInterface $container
     * @return Emitter
     */
    public function __invoke(ContainerInterface $container)
    {
        $emitter = new Emitter();
        (require(ROOT."/config/events.php"))($emitter, $container);
        return $emitter;
    }
}
