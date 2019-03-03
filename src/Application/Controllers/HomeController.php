<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Managers\PageManager;
use Application\Repositories\CategoriesRepository;
use Application\Repositories\PostsRepository;

/**
 * Class HomeController
 * @package Application\Controllers
 */
class HomeController extends Controller
{

    public function index()
    {
        $categories = $this->container->get(CategoriesRepository::class)->all();
        $posts = $this->container->get(PostsRepository::class)->getLast(12);

        $this->turbolinksLocation($this->url('home'));
        PageManager::setTitle('Ngpictures');
        $this->view("frontend/index", compact('categories', 'posts'));
    }
}
