<?php
namespace Ngpictures\Controllers;

use Psr\Container\ContainerInterface;


class HtagController extends Controller
{

    /**
     * @inheritDoc
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
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
            $this->turbolinksLocation("/htag/" . substr($tag, 1));
            $this->pageManager::setName("Htag " . substr($tag, 1));
            $this->viewRender('frontend/others/htags', compact('tag', 'blog', 'posts', 'gallery'));
        } else {
            $this->flash->set('info', $this->flash->msg['post_htag_empty']);
            $this->redirect(true);
        }
    }
}
