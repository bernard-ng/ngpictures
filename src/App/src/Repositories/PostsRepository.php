<?php
namespace App\Repositories;

use App\Entities\PostsEntity;
use Core\Database\Repository;

/**
 * Class PostsRepository
 * @package App\Repositories
 */
class PostsRepository extends Repository
{

    /**
     * @var string
     */
    protected $table = "posts";

    /**
     * @var PostEntity
     */
    protected $entity = PostsEntity::class;
}
