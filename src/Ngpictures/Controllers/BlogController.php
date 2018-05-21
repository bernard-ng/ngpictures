<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\Controllers\ShowPostTrait;
use Ngpictures\Traits\Controllers\StoryPostTrait;

class BlogController extends Controller
{
    public $table = "blog";
    public $field = "blog_id";

    use StoryPostTrait;
    use ShowPostTrait;
}
