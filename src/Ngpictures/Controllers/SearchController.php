<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class SearchController extends Controller
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel(['users', 'posts', 'gallery', 'blog']);
    }

    /*
     * index pour les recherches
    */
    public function index()
    {
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $query = $this->str::escape($_GET['q']);

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

            //recherches dans les posts des users
            while (empty($posts)) {
                $posts = $this->posts->search($query, "end");
                $posts = $this->posts->search($query, "within");
                $posts = $this->posts->search($query, "concat");

                if (empty($posts)) {
                    break;
                }
            }

            //recherches dans le blog
            while (empty($blog)) {
                $blog = $this->blog->search($query, "end");
                $blog = $this->blog->search($query, "within");
                $blog = $this->blog->search($query, "concat");

                if (empty($blog)) {
                    break;
                }
            }

            $this->app::turbolinksLocation("/search/{$query}");
            $this->pageManager::setName("Recherches");
            $this->setLayout("search");
            $this->viewRender("front_end/others/search", compact("query", "posts", "blog", "gallery"));
        } else {
            $this->flash->set("danger", $this->msg['form_field_required']);
            $this->app::redirect(true);
        }
    }
}
