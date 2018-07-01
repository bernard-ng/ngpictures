<?php
namespace Ngpictures\Controllers;


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

            $posts = $this->posts->search($query, "begin");
            $blog = $this->blog->search($query, "begin");
            $gallery = $this->gallery->search($query, "begin");

            //recherches dans la gallery
            while (empty($gallery)) {
                $gallery = $this->gallery->search($query, 'end');
                $gallery = $this->gallery->search($query, 'within');
                $gallery = $this->gallery->search($query, 'concat');

                if (empty($gallery)) {
                    break;
                }
            }

            while (empty($posts)) {
                $posts = $this->posts->search($query, "end");
                $posts = $this->posts->search($query, "within");
                $posts = $this->posts->search($query, "concat");

                if (empty($posts)) {
                    break;
                }
            }

            while (empty($blog)) {
                $blog = $this->blog->search($query, "end");
                $blog = $this->blog->search($query, "within");
                $blog = $this->blog->search($query, "concat");

                if (empty($blog)) {
                    break;
                }
            }

            $this->turbolinksLocation("/search?q={$query}");
            $this->pageManager::setName("Recherches");
            $this->view("frontend/others/search", compact("query", "posts", "blog", "gallery"));
        } else {
            $this->turbolinksLocation("/search");
            $this->pageManager::setName("Recherches");
            $this->view("frontend/others/search");
        }
    }
}
