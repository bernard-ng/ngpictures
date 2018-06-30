<?php
namespace Ngpictures\Controllers;


use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;
use Ngpictures\Traits\Util\TypesActionTrait;

class CommentsController extends Controller
{

    use TypesActionTrait;
    private $user;

    /**
     * CommentsController constructor.
     * oblige un user a se connecter avant de faire une action
     * si il est connecter alors on set son id dans l'instance;
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService->restrict();
        $this->user = $this->authService->isLogged();
        $this->loadModel('comments');
    }


    /**
     * permet d'ajouter un commentaire
     * @param $type
     * @param $slug
     * @param $id
     */
    public function index($type, $slug, $id)
    {
        $post           =   new Collection($_POST);
        $comments       =   $this->loadModel('comments');
        $publication    =   $this->loadModel($this->getAction($type))->find(intval($id));

        if ($publication && $publication->slug === $slug) {
            $this->validator->setRule('comment', 'required');

            if ($this->validator->isValid()) {
                $comment = $this->str::escape($post->get('comment'));
                $comments->create(
                    [
                        'users_id' => $this->user->id,
                        $this->getType($type) => $publication->id,
                        'comment' => $comment
                    ]
                );

                if ($this->isAjax()) {
                    echo $this->loadModel($this->getAction($type))->find(intval($id))->getCommentsNumber();
                    exit();
                } else {
                    $this->flash->set('success', $this->flash->msg['form_comment_submitted'], false);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['form_all_required']);
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set('warning', $this->flash->msg['comment_not_found']);
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
        $comment    =   $this->comments->find(intval($id));

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
            $comment    =   $this->comments->find(intval($id));
            $post       =   new Collection($_POST);

            if ($comment) {
                if ($comment->users_id == $this->user->id) {
                    $this->validator->setRule('comment', 'required');

                    if ($this->validator->isValid()) {
                        $text = $this->str::escape($post->get('comment_edit'));
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
}
