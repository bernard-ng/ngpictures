<?php
namespace Application\Controllers;

use Application\Repositories\PostsRepository;
use Application\Repositories\SavesRepository;
use Framework\Managers\Collection;
use Psr\Container\ContainerInterface;

/**
 * Class SavesController
 * @package Application\Controllers
 */
class SavesController extends Controller
{

    /**
     * @var \Application\Entities\UsersEntity|\Framework\Auth\User|null
     */
    private $currentUser;

    /**
     * @var SavesRepository|mixed
     */
    private $saves;

    /**
     * SavesController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->loggedOnly();
        $this->currentUser = $this->auth->getUser();
        $this->saves = $container->get(SavesRepository::class);
    }


    /**
     * @param $id
     */
    public function add($id)
    {
        $id   = intval($id);
        $post = $this->container->get(PostsRepository::class)->find($id);

        if ($post) {
            $saved = $this->saves->findWith('posts_id', $post->id);

            if ($saved) {
                $this->saves->delete($saved->id);
                $this->flash->success('post_remove_save');
                $this->redirect();
            } else {
                $this->saves->create(['users_id' => $this->currentUser->id, 'posts_id' => $post->id]);
                $this->flash->success('post_saved');
                $this->redirect();
            }
        } else {
            $this->flash->success('post_not_found');
            $this->redirect();
        }
    }

    /**
     * @param int $user_id
     * @return array
     */
    public function show(int $user_id): array
    {
        $posts_list = (new Collection($this->saves->get('posts_id', $user_id)))->toList(', ', 'posts_id');
        $posts = ($posts_list)? $this->container->get(PostsRepository::class)->findList($posts_list) : null;
        return compact('posts');
    }
}
