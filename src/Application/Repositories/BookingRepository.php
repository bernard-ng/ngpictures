<?php
namespace Application\Repositories;

use Application\Entities\BookingEntity;
use Framework\Repositories\Repository;

/**
 * Class BookingRepository
 * @package Application\Repositories
 */
class BookingRepository extends Repository
{
    /**
     * @var string
     */
    protected $table = 'booking';

    /**
     * @var string
     */
    protected $entity = BookingEntity::class;
}
