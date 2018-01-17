<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\Controllers\ShowPostTrait;
use Ngpictures\Traits\Controllers\StoryPostTrait;

class BlogController extends NgpicController
{
	public $table = "blog";

    use StoryPostTrait;
    use ShowPostTrait;
}
