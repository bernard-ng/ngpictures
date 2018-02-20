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
    public function index(string $q = '')
    {
        if (isset($_GET['q']) or isset($q) && !empty($_GET['q']) or !empty($q)) {
            $query = $this->str::escape($_GET['q'] ?? $q);

            $posts = $this->posts->search($query, "begin");
            $blog = $this->blog->search($query, "begin");

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

            $this->pageManager::setName("Recherches");
            $this->setLayout("posts/default");
            $this->viewRender("front_end/others/search", compact("query", "posts", "blog"));
        } else {
            $this->flash->set("danger", $this->msg['form_field_required']);
            $this->app::redirect(true);
        }
    }
}
