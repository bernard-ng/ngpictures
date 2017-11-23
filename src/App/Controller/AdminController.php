<?php
namespace Ngpic\Controller;

use \Ngpic;
use Core\Generic\{Session,Cookie,Collection,Str,Image};
use Ngpic\Controller\NgpicController;



class AdminController extends NgpicController
{
    private $types = [ 1 => 'articles','galery','ngarticles','nggalery'];
    private $upload_blog = '/uploads/blog/';
    private $upload_blog_thumb = '/uploads/blog/thumbs/';
    private $upload_ngpic = '/uploads/ngpictures/';
    private $upload_ngpic_thumb = '/uploads/ngpictures/thumbs/';

    private $msg = [
        'delete_success' => 'La publication a bien été supprimé',
        'delete_failed' => 'Une erreur est survenue lors de la suppression',
        'delete_notAllowed' => "Vous n'avez pas le droit de suppression",
        'delete_notFound' => "La publication n'existe pas ou plus",
        'must_login' => "Vous devez vous connecter",
        'all_field' => "Complétez tous les champs",
        'not_picture_file' => "Le fichier à télécharger doit être une image",
        'modified_success' => "La publication a bien été modifier",
        'post_success' => "La publication a bien été effectuée",
        'picture_required' => "Ajouter une photo de couverture"
    ];

    private function getType(int $id): string
    {
        $type = new Collection($this->types);
        return $type->get($id);
    }

    public function __construct()
    {
        parent::__construct();
        $this->callController('users')->isAdmin();
        $this->verse = $this->callController('verses')->index();


        $this->loadModel(
            [
                'users',
                'articles',
                'ngarticles',
                'galery',
                'nggalery',
                'ideas',
                'bugs'
            ]
        );
    }



    public function index()
    {
        $msg = new Collection($this->msg);

        $articles = $this->articles->lastest();
        $ngarticles = $this->ngarticles->lastest();
        $users = $this->users->orderBy('id', 'DESC', 0, 10);
        $verse = $this->verse;
        //$bugs = $this->bugs->lastest();
        //$ideas = $this->ideas->lastest();
        //$galery = $this->galery->lastest();
        //$nggalery = $this->nggalery->lastest();

        $nb_article = $this->ngarticles->count();
        $nb_users = $this->users->count();

        $this->setTemplate('admin/default');
        $this->viewRender('admin/index',
            compact(
                'articles','ngarticles','nb_article','nb_users',
                'verse'
            )
        );
    }

 
    /*********************************************************************************************************
    *  
    *                                     Website administration. - blog
    *
    **********************************************************************************************************/

    public function blog()
    {
        $articles = $this->ngarticles->orderBy('date_created', 'DESC');
        $article = $this->ngarticles->last();
        $verse = $this->verse;

        $this->setTemplate("admin/default");
        $this->viewRender("admin/blog/index",
            compact(
                "articles","verse","article"
            )
        );

    }


    public function delete($data = null)
    {
        $post = new Collection($data ?? $_POST);
       
        if ($post->has('id') && $post->has('type')) {
            $model = $this->loadModel($this->getType($post->get('type')));
            $publication = $model->find($post->get('id'));

            if ($publication) {
                $model->delete($post->get('id'));
                $this->session->setFlash('success',$this->msg['delete_success']);
                Ngpic::redirect(true);
            } else {
                $this->session->setFlash('danger',$this->msg['delete_notFound']);
                Ngpic::redirect(true);
            }
        } else {
            $this->session->setFlash('danger',$this->msg['delete_failed']);
            Ngpic::redirect('/error-500');
        } 
    }


    
    public function edit(int $id, $data = null)
    {
        $article = $this->ngarticles->find($id);
        $post = new Collection($data ?? $_POST);
        
        if (!empty($post)) {
            if ($post->has('content') || $post->has('title') || $post->has('slug')) {

                $title = $post->get('title');
                $content = $post->get('content');
                $slug = $post->get('slug');
    
                $this->ngarticles->update($id, compact('title', 'content', 'slug'));
                $this->session->setFlash("success", $this->msg['modified_success']);
                Ngpic::redirect("/adm");
            }
        }
        $this->setTemplate('admin/default');
        $this->viewRender('admin/blog/edit', compact('article'));
    }


    public function add()
    {
        $validator = $this->validator;
        $post = new Collection($_POST);
        $file = new Collection($_FILES);

        if (!empty($_POST)) {
            if (!empty($post->get('title')) && !empty($post->get('content')) && !empty($post->get('slug'))) {

                $title = $this->str::escape($post->get('title'));
                $content = $post->get('content');
                $slug = $this->str::escape($post->get('slug'));

                if (!empty($file->get('thumb'))) {
                    $this->ngarticles->create(compact('title','content','slug'));
                    $last_id = $this->ngarticles->lastInsertId();

                    $isUploaded = Image::upload($file, 'blog', $last_id, 'ratio');

                    if ($isUploaded) {
                        $this->ngarticles->setThumb($last_id, "{$last_id}.jpg");
                        $this->session->setFlash('success', $this->msg['post_success']);
                        Ngpic::redirect('/adm');

                    } else {
                        $this->delete(['id' => $last_id, 'type' => 3]);
                    }
                } else {
                    $this->session->setFlash('danger', $this->msg['picture_required']);
                    Ngpic::redirect(true);
                }
            } else {
                $this->session->setFlash('danger',$this->msg['all_field']);
            }
        }

        $this->setTemplate('admin/default');
        $this->viewRender('admin/blog/add', compact('post'));
    }



     /*********************************************************************************************************
    *  
    *                                     Website administration. - articles
    *
    **********************************************************************************************************/

    public function articles()
    {
        $articles = $this->articles->orderBy('date_created', 'DESC');
        $article = $this->articles->last();
        $verse = $this->verse;

        $this->setTemplate("Admin/default");
        $this->viewRender("Admin/articles/index",
            compact(
                "articles", "article", "verse"
            )
        );
    }
       
}
