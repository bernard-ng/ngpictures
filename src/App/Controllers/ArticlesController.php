<?php
namespace Ngpictures\Controllers;


use Ngpictures\Ngpic;
use Ngpictures\Util\Page;
use Ngpictures\Traits\ShowPostTrait;
use Ngpictures\Traits\StoryPostTrait;


class ArticlesController extends NgpicController
{

    public $table = "Articles";

    // fil d'actualite et affichage des posts    
    use StoryPostTrait;
    use ShowPostTrait;
}
