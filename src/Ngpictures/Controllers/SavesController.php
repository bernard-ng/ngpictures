<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ng\Core\Managers\Collection;
use Ngpictures\Managers\PageManager;
use Ngpictures\Traits\Util\TypesActionTrait;



class SavesController extends controller
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->authService->restrict();
        $this->loadModel('saves');
    }

    use TypesActionTrait;

    /**
     * ajoute une publication dans les saves d'un user.TypesActionTrait
     *
     * @param int $type
     * @param string $slug
     * @param int $id
     * @return void
     */
    public function add(int $type, string $slug, int $id)
    {
        $user = $this->session->read(AUTH_KEY);
        $type = intval($type);
        $id   = intval($id);
        $slug = $this->str::escape($slug);

        $post = $this->loadModel($this->getAction($type))->find($id);
        if ($post && $post->slug == $slug) {
            $exists = $this->saves->findWith($this->getType($type), $post->id);

            if ($exists) {
                $this->saves->delete($exists->id);
                $this->flash->set('success', $this->msg['post_remove_save']);
                $this->app::redirect(true);
            } else {
                $this->saves->create([
                    'users_id' => $user->id,
                    $this->getType($type) => $post->id
                ]);

                if($this->isAjax()) {
                    $post = $this->loadModel($this->getAction($type))->find($post->id);
                    echo ($post->isSaved)? 'true' : 'false';
                    exit();
                }

                $this->flash->set('success', $this->msg['post_saved']);
                $this->app::redirect(true);
            }
        } else {
            ($this->isAjax())?
                $this->ajaxFail($this->msg['post_not_found']) :
                $this->flash->set('danger', $this->msg['post_not_found']);
                $this->app::redirect(true);
        }
    }


    /**
     * affiche les publication saved d'un user
     *
     * @param string $token
     * @return void
     */
    public function show(string $token)
    {
        $token = $this->str::escape($token);

        if ($token == $this->session->read(TOKEN_KEY)) {
            $user = $this->session->read(AUTH_KEY);

            $blog_list = (new Collection($this->saves->getBlog($user->id)))->asList();
            $posts_list = (new Collection($this->saves->getPosts($user->id)))->asList();
            $gallery_list = (new Collection($this->saves->getGallery($user->id)))->asList();

            $blog = $this->loadModel('blog')->findList($blog_list);
            $gallery = $this->loadModel('gallery')->findList($gallery_list);
            $posts = $this->loadModel('posts')->findList($posts_list);

            $this->pageManager::setName('Mes Enregistrements');
            $this->app::turbolinksLocation("my-saves/{$token}");
            $this->viewRender('front_end/others/saves', compact('blog','gallery',  'posts'));
        } else {
            $this->flash->set('danger', $this->msg['users_forbidden']);
            $this->app::redirect(true);
        }
    }
}
