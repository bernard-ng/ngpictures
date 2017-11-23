<?php
namespace Ngpic\Controller;
use Core\Generic\{Session,Collection};
use \Ngpic;


class CommentsController extends NgpicController
{

    private $types = [ 1 => 'articles','galery','ngarticles','nggalery'];
    private $user_id = null;
    private $msg = [

        'must_login' => "connecter vous ou crée un compte pour effectuer cette action",
        'not_found' => "Cette publication n'éxiste pas ou plus",
        'comment_not_found' => "Ce commentaire n'éxiste pas ou plus",
        'comment_success' => "Merci pour votre commentaire",
        'delete_success' => "Votre commentaire a bien été supprimé",
        'edit_success' => "Votre commentaire a bien été modifié",
        'notallowed_delete_comment' => "Vous n'avez pas le droit de suppression sur ce commentaire",
        'notallowed_edit_comment' => "Vous n'avez pas le droit d'édition sur ce commentaire",
        'comment_required' => "Complétez le champ commentaire"
    ];


    public function __construct(){
        parent::__construct();
        $this->callController('users')->restrict();
        $this->user_id = intval($this->session->getValue('auth','id'));
    }


    private function getType(int $t): string
    {
        $model = new Collection($this->types);
        return $model->get($t);
    }


    public function index(string $slug, $id,  $t)
    {
        if ($this->session->getValue('auth','id') !== null) {

            $comment = $this->LoadModel('comments');
            $post = new Collection($_POST);
            $article = $this->LoadModel($this->getType($t))->find(floor($id));

            if ($article && $article->slug === $slug) {
                $text = $this->str::escape($post->get('comment'));
                if (!empty($text)) {
                     $comment->create(
                        [
                            'user_id' => $this->user_id,
                            $this->getType($t) => $article->id,
                            'comment' => $text
                        ]
                    );
                    $this->session->setFlash('success', $this->msg['comment_success']);
                    Ngpic::redirect(true);
                } else {
                    $this->session->setFlash('danger', $this->msg['comment_required']);
                    Ngpic::redirect(true);
                }

            } else {
                $this->session->setFlash('warning', $this->msg['not_found']);
                Ngpic::redirect(true);
            }

        } else {
            $this->session->setFlash("warning", $this->msg['must_login']);
            Ngpic::redirect(true);
        }
    }


    public function delete(int $id)
    {
        $comments = $this->loadModel('comments');
        $comment = $comments->find($id);
        $poster = $this->loadModel('ngarticles')->find($comment->ngarticles)->user_id;
        if ($comment) {
            if ($comment->user_id == $this->user_id && $poster = $this->user_id) {
                $comments->delete($id);
                $this->session->setFlash('success', $this->msg['delete_success']);
                Ngpic::redirect(true);

            } else {
                $this->session->setFlash('danger', $this->msg['notallowed_delete_comment']);
                Ngpic::redirect(true);
            }

        } else {
            $this->session->setFlash('warning', $this->msg['comment_not_found']);
            Ngpic::redirect(true);
        }
    }


    public function edit(int $id) {
        $comments = $this->LoadModel('comments');
        $comment = $comments->find($id);
        $post = new Collection($_POST);

        if ($comment) {
            if ($comment->user_id == $this->user_id) {
                $text = $this->str::escape($post->get('comment_edit'));
                $comments->update($comment->id, ['comment' => $text]);
                $this->session->setFlash('success', $this->msg['edit_success']);
                Ngpic::redirect(true);

            } else {
                $this->session->setFlash('danger', $this->msg['notallowed_edit_comment']);
                Ngpic::redirect(true);
            }

        } else {
            $this->session->setFlash('warning', $this->msg['comment_not_found']);
            Ngpic::redirect(true);
        }
    }


    public function show(string $slug, int $id, int $type)
    {
        Ngpic::setPageName('Les mentions | Ngpictures');
        $this->setTemplate('features/default');
        $this->viewRender('features/mentions');
    }
}
