<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\FindQueryTrait;
use Ngpictures\Traits\Models\LastQueryTrait;
use Ngpictures\Traits\Models\SearchQueryTrait;

class GalleryModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "gallery";


    use LastQueryTrait;
    use FindQueryTrait;
    use SearchQueryTrait;
}
