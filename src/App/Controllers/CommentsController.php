<?php
namespace Ngpictures\Controllers;


use Ng\Core\Generic\Collection;
use Ngpictures\Util\Page;
use Ngpictures\Ngpic;


class CommentsController extends NgpicController
{

    private $types = [ 1 => 'articles','gallery','blog'];
    private $user_id = null;
    

    public function __construct(){
        parent::__construct();
        $this->callController('users')->restrict();
        $this->user_id = intval($this->session->getValue(AUTH_KEY, 'id'));
    }


    private function getType(int $type): string
    {
        $model = new Collection($this->types);
        return $model->get($type);
    }


    public function index($type, $slug, $id)
    {
        $comments = $this->loadModel('comments');
        $post = new Collection($_POST);
        $publication = $this->loadModel($this->getType($type))->find(floor($id));

        if ($publication && $publication->slug === $slug) {
            $comment = $this->str::escape($post->get('comment'));
            if (!empty($comment)) {
                 $comments->create(
                    [
                        'user_id' => $this->user_id,
                        $this->getType($type) => $publication->id,
                        'comment' => $comment
                    ]
                );
                $this->flash->set('success', $this->msg['comment_success']);
                Ngpic::redirect(true);
            } else {
                $this->flash->set('danger', $this->msg['comment_required']);
                Ngpic::redirect(true);
            }

        } else {
            $this->flash->set('warning', $this->msg['not_found']);
            Ngpic::redirect(true);
        }
    }


    public function delete($type, $id, $token)
    {
        $comments = $this->loadModel('comments');
        $comment = $comments->find(intval($id));

        //recupere l'id du poster a travers le type de la publication et on verifie dans la table
        //de publication si , c vraiment lui qui a poster l'article, alors il aura le droit de 
        // supprimer le commentaire.
        $poster = $this->loadModel($this->getType($type))->find($comment->$this->getType($type))->user_id;

        if ($token == $this->session->read('token')) {
            if ($comment) {
                if (($comment->user_id == $this->user_id && $poster = $this->user_id) || $this->user_id == 1) {
                    $comments->delete($id);
                    $this->flash->set('success', $this->msg['delete_success']);
                    Ngpic::redirect(true);

                } else {
                    $this->flash->set('danger', $this->msg['notallowed_delete_comment']);
                    Ngpic::redirect(true);
                }

            } else {
                $this->flash->set('warning', $this->msg['comment_not_found']);
                Ngpic::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['notallowed_delete_comment']);
            Ngpic::redirect(true);
        }
    }


    public function edit($id, $token) {
        $comments = $this->loadModel('comments');
        $comment = $comments->find(intval($id));
        $post = new Collection($_POST);

        if ($comment) {
            if ($comment->user_id == $this->user_id) {
                $comment = $this->str::escape($post->get('comment_edit'));
                $comments->update($comment->id, ['comment' => $comment]);
                $this->flash->set('success', $this->msg['edit_success']);
                Ngpic::redirect(true);

            } else {
                $this->flash->set('danger', $this->msg['notallowed_edit_comment']);
                Ngpic::redirect(true);
            }

        } else {
            $this->flash->set('warning', $this->msg['comment_not_found']);
            Ngpic::redirect(true);
        }
    }
}
