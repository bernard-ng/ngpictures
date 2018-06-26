<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;


class HtagController extends Controller
{

    /**
     * HtagController constructor
     *
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('blog');
        $this->loadModel('posts');
        $this->loadModel('gallery');
    }


    /**
     * va chercher les publications qui contienne, le htag
     * passe en para
     *
     * @param string $tag
     * @return void
     */
    public function index($tag)
    {

        $tag        =   "#" . $this->str::escape($tag);
        $blog       =   $this->blog->findWithTag($tag);
        $posts      =   $this->posts->findWithTag($tag);
        $gallery    =   $this->gallery->findWithTag($tag);

        if ($blog || $posts || $gallery) {
            $this->app::turbolinksLocation("/htag/" . substr($tag, 1));
            $this->pageManager::setName("Htag " . substr($tag, 1));
            $this->viewRender('frontend/others/htags', compact('tag', 'blog', 'posts', 'gallery'));
        } else {
            $this->flash->set('info', $this->flash->msg['post_htag_empty']);
            $this->app::redirect(true);
        }
    }
}
