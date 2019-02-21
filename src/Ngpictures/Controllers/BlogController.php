<?php
namespace Application\Controllers;

use Application\Traits\Controllers\ShowPostTrait;
use Application\Traits\Controllers\StoryPostTrait;

class BlogController extends Controller
{
    use StoryPostTrait, ShowPostTrait;

    public $table = "blog";
    public $field = "blog_id";
}
