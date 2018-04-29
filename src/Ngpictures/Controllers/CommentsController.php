<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\Util\TypesActionTrait;
use Ng\Core\Managers\Collection;
use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class CommentsController extends Controller
{

    use TypesActionTrait;

    /**
     * CommentsController constructor.
     * oblige un user a se connecter avant de faire une action
     * si il est connecter alors on set son id dans l'instance;
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->callController('users')->restrict();
        $this->users_id = intval($this->session->getValue(AUTH_KEY, 'id'));
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
                        'users_id' => $this->users_id,
                        $this->getType($type) => $publication->id,
                        'comment' => $comment
                    ]
                );

                if ($this->isAjax()) {
                    echo $this->loadModel(
                        $this->getAction($type))->find(intval($id)
                    )->getCommentsNumber();
                    exit();
                } else {
                    $this->flash->set('success', $this->msg['form_comment_submitted']);
                    $this->app::redirect(true);
                }

            } else {
                $this->isAjax() ?
                    $this->ajaxFail($this->msg['form_all_required']) :
                    $this->flash->set('danger', $this->msg['form_all_required']);
                    $this->app::redirect(true);
            }
        } else {
            $this->isAjax()?
                $this->ajaxFail($this->msg['comment_not_found']) :
                $this->flash->set('warning', $this->msg['comment_not_found']);
                $this->app::redirect(true);
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
        $comments   =   $this->loadModel('comments');
        $comment    =   $comments->find(intval($id));

        if ($token == $this->session->read(TOKEN_KEY)) {
            if ($comment) {
                if ($comment->users_id == $this->users_id) {
                    $comments->delete($id);
                    $this->flash->set('success', $this->msg['comment_delete_success']);
                    $this->app::redirect(true);
                } else {
                    $this->flash->set('danger', $this->msg['delete_not_allowed']);
                    $this->app::redirect(true);
                }
            } else {
                $this->flash->set('warning', $this->msg['comment_not_found']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['delete_not_allowed']);
            $this->app::redirect(true);
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
            $comments   =   $this->loadModel('comments');
            $comment    =   $comments->find(intval($id));
            $post       =   new Collection($_POST);

            if ($comment) {
                if ($comment->users_id == $this->users_id) {
                    $this->validator->setRule('comment', 'required');

                    if ($this->validator->isValid()) {
                        $text = $this->str::escape($post->get('comment_edit'));
                        $comments->update($comment->id, ['comment' => $text]);

                        $this->flash->set('success', $this->msg['comment_edit_success']);
                        $this->app::redirect(true);
                    } else {
                        $this->flash->set('danger', $this->msg['form_all_required']);
                        $this->app::redirect(true);
                    }
                } else {
                    $this->flash->set('danger', $this->msg['edit_not_allowed']);
                    $this->app::redirect(true);
                }
            } else {
                $this->flash->set('warning', $this->msg['comment_not_found']);
                $this->app::redirect(true);
            }
        }
    }
}
