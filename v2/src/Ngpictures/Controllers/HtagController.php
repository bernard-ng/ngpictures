<?php
namespace Ngpictures\Controllers;

use Psr\Container\ContainerInterface;

class HtagController extends Controller
{
    /**
     * va chercher les publications qui contienne, le htag
     * passe en para
     *
     * @param string $tag
     * @return void
     */
    public function index($tag)
    {

        $tag        =   "#" . $this->str->escape($tag);
        $blog       =   $this->loadModel('blog')->findWithTag($tag);
        $posts      =   $this->loadModel('posts')->findWithTag($tag);
        $gallery    =   $this->loadModel('gallery')->findWithTag($tag);

        if ($blog || $posts || $gallery) {
            $this->turbolinksLocation("/htag/" . substr($tag, 1));
            $this->pageManager::setTitle("Htag");
            $this->pageManager::setDescription("Rétrouvez toutes les photos associées à l'Htag : " . substr($tag, 1));
            $this->view('frontend/others/htags', compact('tag', 'blog', 'posts', 'gallery'));
        } else {
            $this->flash->set('info', $this->flash->msg['post_htag_empty']);
            $this->redirect(true);
        }
    }
}
