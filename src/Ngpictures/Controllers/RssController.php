<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class RssController extends Controller
{
 
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('blog');
    }

    public function index()
    {
        if ($this->blog->last()) {
            $last = $this->blog->last()->date_created;
            $articles = $this->blog->latest(0, 10);
        } else {
            $this->session->setFlash('info', $this->msg['rss_empty_articles']);
            $this->app::redirect(true);
        }


        //$this->viewRender('others/rss', compact('last','articles'), false);
        header("Content-type: application/rss+xml");
        require APP."/Views/others/rss.xml";
    }
}
