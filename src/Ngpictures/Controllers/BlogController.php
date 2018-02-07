<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\Controllers\ShowPostTrait;
use Ngpictures\Traits\Controllers\StoryPostTrait;

class BlogController extends Controller
{
    public $table = "blog";

    use StoryPostTrait;
    use ShowPostTrait;
}
