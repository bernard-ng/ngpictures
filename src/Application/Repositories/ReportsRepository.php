<?php
namespace Application\Repositories;

use Application\Entities\PostsEntity;
use Framework\Repositories\Repository;

/**
 * Class ReportsRepository
 * @package Application\Repositories
 */
class ReportsRepository extends Repository
{

    /**
     * @var string
     */
    protected $table = 'reports';

    /**
     * @var string
     */
    protected $entity = PostsEntity::class;
}
