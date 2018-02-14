<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\SearchQueryTrait;

class CategoriesModel extends Model
{
    /**
     * le nom de la table
     * @var string
     */
    protected $table = "categories";

    use SearchQueryTrait;
}
