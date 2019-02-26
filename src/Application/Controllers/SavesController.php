<?php
namespace Application\Controllers;

use Framework\Managers\Collection;
use Psr\Container\ContainerInterface;
use Application\Traits\Util\TypesActionTrait;

class SavesController extends Controller
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
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
    public function add($type, $slug, $id)
    {
        $user = $this->authService->isLogged();
        $type = intval($type);
        $id   = intval($id);
        $slug = $this->str->escape($slug);

        $post = $this->loadModel($this->getAction($type))->find($id);
        if ($post && $post->slug == $slug) {
            $exists = $this->saves->findWith($this->getType($type), $post->id);

            if ($exists) {
                $this->saves->delete($exists->id);
                $this->flash->set('success', $this->flash->msg['post_remove_save']);
                $this->redirect(true);
            } else {
                $this->saves->create([
                    'users_id' => $user->id,
                    $this->getType($type) => $post->id
                ]);

                if ($this->isAjax()) {
                    $post = $this->loadModel($this->getAction($type))->find($post->id);
                    echo ($post->isSaved)? 'true' : 'false';
                    exit();
                }

                ($this->isAjax())?
                    $this->flash->set('success', $this->flash->msg['post_saved']) :
                    $this->flash->set('success', $this->flash->msg['post_saved'], false);
                    $this->redirect(true);
            }
        } else {
            ($this->isAjax())?
                $this->setFlash($this->flash->msg['post_not_found']) :
                $this->flash->set('danger', $this->flash->msg['post_not_found']);
                $this->redirect(true);
        }
    }


    /**
     * affiche les publication saved d'un user
     *
     * @param int $user_id
     * @return void
     */
    public function show(int $user_id): array
    {
        $blog_list = (new Collection($this->saves->get('blog_id', $user_id)))->asList(', ', 'blog_id');
        $posts_list = (new Collection($this->saves->get('posts_id', $user_id)))->asList(', ', 'posts_id');
        $gallery_list = (new Collection($this->saves->get('gallery_id', $user_id)))->asList(', ', 'gallery_id');

        $blog = ($blog_list)? $this->loadModel('blog')->findList($blog_list) : null;
        $gallery = ($gallery_list)? $this->loadModel('gallery')->findList($gallery_list) : null;
        $posts = ($posts_list)? $this->loadModel('posts')->findList($posts_list) : null;

        return compact('blog', 'gallery', 'posts');
    }
}
