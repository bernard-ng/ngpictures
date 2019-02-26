<?php
namespace Application\Controllers;

use Application\Managers\PageManager;
use Psr\Container\ContainerInterface;

class SearchController extends Controller
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->loadModel(['users', 'posts', 'gallery', 'blog']);
    }

    /*
     * index pour les recherches
    */
    public function index()
    {
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $query = trim($this->str->escape($_GET['q']));

            $posts = $this->posts->search($query);
            $blog = $this->blog->search($query);
            $gallery = $this->gallery->search($query);

            $words = explode(' ', $query);
            $pexels = $this->callController('pexels')->search($query, 15, 1);


            $this->turbolinksLocation("/search?q=". str_replace(' ', '+', $query));
            PageManager::setTitle("Recherches");
            $this->view("frontend/others/search", compact("query", "posts", "blog", "gallery", "pexels"));
        } else {
            $this->turbolinksLocation("/search");
            PageManager::setTitle("Recherches");
            $this->view("frontend/others/search");
        }
    }
}
