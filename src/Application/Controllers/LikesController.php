<?php
namespace Application\Controllers;

use Application\Managers\PageManager;
use Application\Repositories\LikesRepository;
use Application\Repositories\PostsRepository;
use Application\Repositories\UsersRepository;
use Framework\Managers\Collection;
use Psr\Container\ContainerInterface;


/**
 * Class LikesController
 * @package Application\Controllers
 */
class LikesController extends Controller
{

    /**
     * @var \Application\Entities\UsersEntity|\Framework\Auth\User|null
     */
    private $currentUser;

    /**
     * LikesController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->loggedOnly();
        $this->currentUser = $this->auth->getUser();
    }


    /**
     * @param int $id
     */
    public function index($id)
    {
        $post = $this->container->get(PostsRepository::class)->find(intval($id));

        if ($post) {
            $like = $this->container->get(LikesRepository::class);

            if ($like->isLiked($post->id, $this->currentUser->id)) {
                $like->remove($post->id, $this->currentUser->id);
                $this->flash->success('post_like_remove');
                $this->redirect();
            } else {
                $like->add($post->id, $this->currentUser->id);
                $this->flash->success('post_like_add');
                $this->redirect();
            }
        } else {
            $this->flash->error('post_not_found');
            $this->redirect();
        }
    }

    /**
     * @param int $id
     */
    public function show($id)
    {
        $id = intval($id);
        $post = $this->container->get(PostsRepository::class)->find($id);

        if ($post) {
            $likes = $this->container->get(LikesRepository::class);
            $likers = (new Collection($likes->getLikers($id)))->toList();

            if (!empty($likers)) {
                $likers = $this->container->get(UsersRepository::class)->findWithList($likers);
                $this->turbolinksLocation($this->url('likes.show', compact('id')));
                PageManager::setTitle("Mentions j'aime");
                $this->view("frontend/posts/likers", compact("likers"));
            } else {
                $this->flash->error('post_not_liked');
                $this->redirect();
            }
        }
    }
}
