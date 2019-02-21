<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\Controllers\ShowPostTrait;
use Ngpictures\Traits\Controllers\StoryPostTrait;

class BlogController extends Controller
{
    use StoryPostTrait, ShowPostTrait;

    public $table = "blog";
    public $field = "blog_id";
}
