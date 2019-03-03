<?php
namespace Application\Controllers;

use Application\Entities\UsersEntity;
use Application\Managers\PageManager;
use Application\Repositories\CommentsRepository;
use Application\Services\Notification\NotificationService;
use Awurth\SlimValidation\Validator;
use Framework\Managers\Collection;
use Psr\Container\ContainerInterface;

class CommentsController extends Controller
{
    /**
     * @var UsersEntity
     */
    private $user;

    /**
     * @var CommentsRepository|mixed
     */
    private $comments;

    /**
     * CommentsController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService->restrict();
        $this->user = $this->authService->isLogged();
        $this->comments = $container->get(CommentsRepository::class);
    }

    /**
     * @param $id
     */
    public function index($id)
    {
        $id = intval($id);
        $validator = $this->container->get(Validator::class);
        $input = new Collection($_POST);
        $post = $this->container->get(PostsController::class)->find($id);
        $notifier = $this->container->get(NotificationService::class);

        if ($post) {
            $validator->setRule('comment', 'required');

            if ($validator->isValid()) {
                $comment = $input->get('comment');
                $this->comments->create(['users_id' => $this->user->id, 'posts_id'=> $post->id, 'comment' => $comment]);
                $notifier->notify(3, [$post, $this->user->id, $comment]);

                if ($this->request->ajax()) {
                    echo $this->comments->count($id);
                    exit();
                } else {
                    $this->flash->set('success', 'form_comment_submitted', false);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set('danger', 'form_all_required');
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set('warning', 'comment_not_found');
            $this->redirect(true, false);
        }
    }


    /**
     * recupere l'id du poster a travers le type de la publication et on verifie dans la table
     * de publication si , c vraiment lui qui a poster l'article, alors il aura le droit de
     * supprimer le commentaire.
     * @param $id
     * @param $token
     */
    public function delete($id, $token)
    {
        $comment = $this->comments->find(intval($id));

        if ($token == $this->authService->getToken()) {
            if ($comment) {
                if ($comment->users_id == $this->user->id) {
                    $this->comments->delete($id);
                    $this->flash->set('success', $this->flash->msg['comment_delete_success'], false);
                    $this->redirect(true, false);
                } else {
                    $this->flash->set('danger', $this->flash->msg['delete_not_allowed']);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set('warning', $this->flash->msg['comment_not_found']);
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['delete_not_allowed']);
            $this->redirect(true, false);
        }
    }


    /**
     * permet d'editer un commentaire, le securite est base sur les tokens csrf
     * @param $id
     * @param $token
     */
    public function edit($id, $token)
    {
        if ($token == $this->session->read(TOKEN_KEY)) {
            $comment = $this->comments->find(intval($id));
            $post = new Collection($_POST);

            if ($comment) {
                if ($comment->users_id == $this->user->id) {
                    $this->validator->setRule('comment', 'required');

                    if ($this->validator->isValid()) {
                        $text = $this->str->escape($post->get('comment_edit'));
                        $this->comments->update($comment->id, ['comment' => $text]);

                        $this->flash->set('success', $this->flash->msg['comment_edit_success'], false);
                        $this->redirect(true, false);
                    } else {
                        $this->flash->set('danger', $this->flash->msg['form_all_required'], false);
                        $this->redirect(true, false);
                    }
                } else {
                    $this->flash->set('danger', $this->flash->msg['edit_not_allowed'], false);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set('warning', $this->flash->msg['comment_not_found'], false);
                $this->redirect(true, false);
            }
        }
    }


    public function show($type, $slug, $id)
    {
        $type = intval($type);
        $id = intval($id);
        $user = $this->loadRepository("users");
        $post = $this->loadRepository($this->getAction($type))->find($id);

        if ($post) {
            $comments = $this->loadRepository('comments')->findWith($this->getAction($type) . "_id", $id, false);
            $commentsNumber = $this->loadRepository("comments")->count($id, $this->getAction($type) . "_id")->num;

            PageManager::setTitle("Commentaires");
            PageManager::setDescription("Tous les commentaires, poster pour la publication : " . $post->title);
            $this->turbolinksLocation("/comments/{$type}/{$slug}-{$id}");
            $this->view("frontend/posts/comments", compact("publication", "comments", "commentsNumber", "user"));
        } else {
            $this->flash->set("danger", $this->flash->msg['post_not_found']);
            $this->redirect(true);
        }
    }
}
