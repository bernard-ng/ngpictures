<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;
use Ngpictures\Traits\FindQueryTrait;


class BlogModel extends Model{

    /**
     * nom de la table
     * @var string
     */
    protected $table = "blog";

    // fetch un article
    use FindQueryTrait;
}