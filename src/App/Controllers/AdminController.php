<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpic;
use Ngpictures\Util\Page;

use Ng\Core\Generic\{Collection,Image};

use Ngpictures\Controllers\NgpicController;



class AdminController extends NgpicController
{
    private $types = [ 1 => 'articles','gallery','blog','ngGallery'];
    private $upload_blog = '/uploads/blog/';
    private $upload_blog_thumb = '/uploads/blog/thumbs/';
    private $upload_ngpic = '/uploads/ngpictures/';
    private $upload_ngpic_thumb = '/uploads/ngpictures/thumbs/';

    private function getType(int $id)
    {
        $type = new Collection($this->types);
        return $type->get($id);
    }

    public function __construct()
    {
        parent::__construct();
        $this->callController('users')->isAdmin();
        $this->verse = $this->callController('verses')->index();
        Page::setMeta(['name' => 'robots','content' => 'noindex']);

        $this->loadModel(
            [
                'users',
                'articles',
                'blog',
                'gallery',
                'ngGallery',
                'ideas',
                'bugs'
            ]
        );
    }



    public function index()
    {
        $msg = new Collection($this->msg);

        $articles = $this->articles->lastest();
        $blog = $this->blog->lastest();
        $users = $this->users->all();
        //$bugs = $this->bugs->lastest();
        //$ideas = $this->ideas->lastest();
        //$gallery = $this->gallery->lastest();
        //$ngGallery = $this->ngGallery->lastest();

        $nb_users = count($this->users);

        Page::setName('administration | Ngpictures');

        $this->setLayout('admin/default');
        $this->viewRender('admin/index',
            compact(
                'articles','blog','nb_users'
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
        $articles = $this->blog->orderBy('date_created', 'DESC');
        $article = $this->blog->last();
        $verse = $this->verse;

        Page::setName('administration - blog | Ngpictures');

        $this->setLayout("admin/default");
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
                $this->flash->set('success',$this->msg['admin_delete_success']);
                Ngpic::redirect(true);
            } else {
                $this->flash->set('danger',$this->msg['admin_delete_notFound']);
                Ngpic::redirect(true);
            }
        } else {
            $this->flash->set('danger',$this->msg['admin_delete_failed']);
            Ngpic::redirect('/error-500');
        } 
    }


    
    public function edit(int $id, $data = null)
    {
        $article = $this->blog->find($id);
        $post = new Collection($data ?? $_POST);
        
        if (!empty($post)) {
            if ($post->has('content') || $post->has('title') || $post->has('slug')) {

                $title = $post->get('title');
                $content = $post->get('content');
                $slug = $post->get('slug');
    
                $this->blog->update($id, compact('title', 'content', 'slug'));
                $this->flash->set("success", $this->msg['admin_modified_success']);
                Ngpic::redirect(true);
            }
        }
        Page::setName('administration - blog - edittion | Ngpictures');

        $this->setLayout('admin/default');
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
                    $this->blog->create(compact('title','content','slug'));
                    $last_id = $this->blog->lastInsertId();

                    $isUploaded = Image::upload($file, 'blog', "ngpictures-blog-{$last_id}", 'ratio');

                    if ($isUploaded) {
                        $this->blog->setThumb($last_id, "ngpictures-blog-{$last_id}.jpg");
                        $this->flash->set('success', $this->msg['admin_post_success']);
                        Ngpic::redirect('/adm');

                    } else {
                        $this->delete(['id' => $last_id, 'type' => 3]);
                    }
                } else {
                    $this->flash->set('danger', $this->msg['admin_picture_required']);
                    Ngpic::redirect(true);
                }
            } else {
                $this->flash->set('danger',$this->msg['admin_all_fields']);
            }
        }

        Page::setName('administration - publication| Ngpictures');

        $this->setLayout('admin/default');
        $this->viewRender('admin/blog/add', compact('post'));
    }


    public function confirm($t, $id) 
    {
        $model = $this->loadModel($this->getType($t));
        $publication = $model->find(intval($id));

        if ($publication && !$publication->online) {
            $model->addOnline($id);
            $this->flash->set('success', $this->msg['admin_confirm_success']);
            Ngpic::redirect(true);
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
    }


    public function remove($t, $id)
    {
        $model = $this->loadModel($this->getType($t));
        $publication = $model->find(intval($id));

        if ($publication && $publication->online) {
            $model->removeOnline($id);
            $this->flash->set('success', $this->msg['admin_remove_success']);
            Ngpic::redirect(true);
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
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

        Page::setName('administration - users - articles | Ngpictures');

        $this->setLayout("Admin/default");
        $this->viewRender("Admin/articles/index",
            compact(
                "articles", "article", "verse"
            )
        );
    }




    /*********************************************************************************************************
    *  
    *                                     Website administration. -gallerie
    *
    **********************************************************************************************************/
   
    public function gallery()
    {
        $photos = $this->gallery->all();
        $ngPhotos = $this->ngGallery->all();

        page::setName('administration - gallery');

        $this->setLayout("admin/default", compact('photos','ngGallery'));
        $this->viewRender("Admin/gallery/index");
    }



    public function addGallery()
    {
        $post = new Collection($_POST);
        $file = new Collection($_FILES);

        if (!empty($_FILES)) {
            if (!empty($post->get('$description')) && !empty($post->get('tags')) && !empty($post->get('name'))) {
                $name = $this->str::escape($post->get('name'));
                $description = $post->get('description');
                $tags = $this->str::escape($post->get('tags'));
            } else {
                $name = null;
                $description = null;
                $tags = null;
            }
            
            if (!empty($file->get('thumb'))) {
                $this->ngGallery->create(compact('name','description','tags'));
                $last_id = $this->ngGallery->lastInsertId();

                $isUploaded = Image::upload($file, 'ngpictures', "ngpictures-{$name}-{$last_id}", 'ratio');

                if ($isUploaded) {
                    $this->ngGallery->setThumb($last_id, "ngpictures-{$name}-{$last_id}.jpg");
                    $this->flash->set('success', $this->msg['admin_post_success']);
                    Ngpic::redirect(true);

                } else {
                    $this->delete(['id' => $last_id, 'type' => 4]);
                }
            } else {
                $this->flash->set('danger', $this->msg['admin_picture_required']);
                Ngpic::redirect(true);
            }
        }
        
        page::setName('administration - add - gallery');
        $this->setLayout("admin/default", compact('post'));
        $this->viewRender("Admin/gallery/add");
    }


    public function editGallery()
    {
        $photos = $this->gallery->all();
        $ngPhotos = $this->ngGallery->all();

        page::setName('administration - gallery');

        $this->setLayout("admin/default", compact('photos','ngGallery'));
        $this->viewRender("Admin/gallery/edit");
    }



    public function deleteGallery()
    {

    }
       
}
