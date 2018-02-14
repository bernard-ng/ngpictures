<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\FindQueryTrait;
use Ngpictures\Traits\Models\SearchQueryTrait;

class BlogModel extends Model
{

    /**
     * nom de la table
     * @var string
     */
    protected $table = "blog";


    use FindQueryTrait;
    use SearchQueryTrait;
}
