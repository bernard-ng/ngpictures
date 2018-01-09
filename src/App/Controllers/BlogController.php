<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\ShowPostTrait;
use Ngpictures\Traits\StoryPostTrait;


class BlogController extends NgpicController
{

	private $table = "blog";
    // fil d'actualite et affiche des posts
    use StoryPostTrait;
    use ShowPostTrait;
}
