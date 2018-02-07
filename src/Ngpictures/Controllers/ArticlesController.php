<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\Controllers\ShowPostTrait;
use Ngpictures\Traits\Controllers\StoryPostTrait;

class ArticlesController extends Controller
{
    public $table = "articles";

    use StoryPostTrait;
    use ShowPostTrait;
}
