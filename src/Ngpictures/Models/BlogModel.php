<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\FindQueryTrait;

class BlogModel extends Model
{

    /**
     * nom de la table
     * @var string
     */
    protected $table = "blog";


    use FindQueryTrait;
}
