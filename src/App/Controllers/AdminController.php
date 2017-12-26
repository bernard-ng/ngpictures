<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpic;
use Ngpictures\Util\Page;
use Ng\Core\Generic\{Collection,Image};

/**
 * Class AdminController
 * @package Ngpictures\Controllers
 * permet de gere l'administration
 */
class AdminController extends NgpicController
{
    /**
     * les differentes tables gerer par l'admin
     * @var array
     */
    private $types = [ 1 => 'articles','gallery','blog','ngGallery','users'];


    /**
     * recupere la tables apartir de son index
     * @param int $id
     * @return null
     */
    private function getType(int $id)
    {
        $type = new Collection($this->types);
        return $type->get($id);
    }

    /**
     * verifie si le user est connecter
     * n'index pas la page au resultat de recherche
     * et charge tout les models dont a besion
     * AdminController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->callController('users')->isAdmin();
        Page::setMeta(['name' => 'robots', 'content' => 'noindex']);

        $this->loadModel(
            [
                'users', 'articles', 'blog', 'gallery',
                'ngGallery', 'ideas', 'bugs', 'categories'
            ]
        );
    }

    /**
     * la method par default
     */
    public function index()
    {
        $articles = $this->articles->latest();
        $blog = $this->blog->latest();

        Page::setName('administration | Ngpictures');

        $this->setLayout('admin/default');
        $this->viewRender('admin/index',
            compact(
                'articles','blog'
            )
        );
    }

 
    /*********************************************************************************************************
    *                                     Website administration. - blog
    **********************************************************************************************************/

    /**
     * gestion du blog
     */
    public function blog()
    {
        $articles = $this->blog->orderBy('id', 'DESC');
        $article = $this->blog->last();
        Page::setName('administration - blog | Ngpictures');
        $this->setLayout("admin/default");
        $this->viewRender("admin/blog/index",
            compact(
                "articles","article"
            )
        );

    }


    /**
     * suprime un post
     * @param array|null $data
     * @param string $msg
     */
    public function delete(array $data = null, string $msg = null)
    {
        $post = new Collection($data ?? $_POST);
       
        if ($post->get('id') && $post->get('type')) {
            $model = $this->loadModel($this->getType($post->get('type')));
            $result = $model->find(intval($post->get('id')));
            if ($result) {
                $model->delete($post->get('id'));
               $this->flash->set('danger', $msg ?? $this->msg['admin_delete_success']);
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


    /**
     * edition d'un article
     * ne pas escape la valeur de $post->get("content"); a cause de l'editeur wysiwy
     * @param int $id
     * @param null $data
     */
    public function edit(int $id, $data = null)
    {
        $article = $this->blog->find(intval($id));
        $categories = $this->categories->all();
        $post = new Collection($data ?? $_POST);
        
        if (!empty($_POST)) {
            if (!empty($post->get('content')) && !empty($post->get('title')) && !empty($post->get('slug'))) {

                $this->validator->isEmpty('title', $this->msg['admin_all_fields']);
                $this->validator->isEmpty('content', $this->msg['admin_all_fields']);
                $this->validator->isEmpty('slug', $this->msg['admin_all_fields']);
                $this->validator->isKebabCase('slug', $this->msg['admin_slug_notKebab']);
                
                if ($this->validator->isValid()) {
                    $title = $this->str::escape($post->get('title'));
                    $content = $post->get('content');
                    $slug = $this->str::escape($post->get('slug'));
                    $category_id = (int) $post->get('category') ?? 1 ;

                    $this->blog->update($id, compact('title', 'content', 'slug', 'category_id'));
                    $this->flash->set("success", $this->msg['admin_modified_success']);
                    Ngpic::redirect(ADMIN);
                } else {
                    var_dump($this->validator->getErrors());
                }
            } else {
                $this->flash->set('danger', $this->msg['admin_all_fields']);
            }
        }

        Page::setName('administration - blog - edittion | Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('admin/blog/edit', compact('article', 'categories', 'post'));
    }


    /**
     * ajout d'un nouvel article
     */
    public function add()
    {
        $categories = $this->categories->all();
        $post = new Collection($_POST);
        $file = new Collection($_FILES);

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('title')) && !empty($post->get('content')) && !empty($file->get('thumb.name'))) {

                $title = $this->str::escape($post->get('title'));
                $content = $post->get('content');

                if ($post->get('slug') !== '') {
                    $this->validator->isKebabCase('slug', $this->msg['admin_slug_notKebab']);
                    if ($this->validator->isValid()) {
                        $slug = $this->str::escape($post->get('slug'));
                    }
                } else {
                    $slug = $this->str::slugify($title);
                }

                $category_id = ($post->get('category') == 0 )? 1 : $post->get('category');

                if (isset($_FILES) && !empty($_FILES)) {
                    if(!empty($file->get('thumb.name'))) {
                        if ($this->validator->isValid()) {
                            $this->blog->create(compact('title', 'content', 'slug', 'category_id'));

                            $last_id = $this->blog->lastInsertId();
                            $isUploaded = Image::upload($file, 'blog', "ngpictures-{$slug}-{$last_id}", 'article');

                            if ($isUploaded) {
                                $this->blog->update($last_id, ['thumb' => "ngpictures-{$slug}-{$last_id}.jpg"]);
                                $this->flash->set('success', $this->msg['admin_post_success']);
                                Ngpic::redirect('/adm');
                            } else {
                                var_dump($file);
                                die();
                                $this->delete(['id' => $last_id, 'type' => 3]);
                            }
                        } else {
                            var_dump($this->validator->getErrors());
                        }
                    } else {
                            $this->flash->set('danger', $this->msg['admin_picture_required']);
                    }
                }
            } else {
                $this->flash->set('danger',$this->msg['admin_all_fields']);
            }
        }
        Page::setName('administration - publication| Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('admin/blog/add', compact('post','categories'));
    }


    /**
     * mettre du contenu en ligne ou pas
     * @param $t
     * @param $id
     */
    public function confirm($t, $id)
    {
        $model = $this->loadModel($this->getType($t));
        $result = $model->find(intval($id));

        if (intval($t) === 5) {
            if ($result->confirmed_at === null) {
                $model->unsetConfirmationToken($result->id);
            } elseif ($result->confirmed_at !== null) {
                $this->flash->set('success', $this->msg['admin_already_confrimed']);
                Ngpic::redirect(true);
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }
        } else {
            if ($result && !$result->online) {
                $model->update($id, ['online' => 1]);
                $this->flash->set('success', $this->msg['admin_confirm_success']);
                Ngpic::redirect(true);
            } elseif ($result && $result->online) {
                $model->update($id, ['online' => 0]);
                $this->flash->set('success', $this->msg['admin_remove_success']);
                Ngpic::redirect(true);
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }
        }
    }

    /*********************************************************************************************************
    *                                     Website administration. - articles
    **********************************************************************************************************/


    /**
     * gestion d'articles des utilisateurs
     */
    public function articles()
    {
        $articles = $this->articles->orderBy('id', 'DESC');
        $article = $this->articles->last();
        Page::setName('administration - users - articles | Ngpictures');
        $this->setLayout("Admin/default");
        $this->viewRender("Admin/articles/index",
            compact(
                "articles", "article"
            )
        );
    }




    /*********************************************************************************************************
    *                                     Website administration. -gallerie
    **********************************************************************************************************/


    /**
     * gestion de la gallery
     */
    public function gallery()
    {
        $photos = $this->ngGallery->all();
        $photo = $this->ngGallery->latest();
        page::setName('administration - gallery');
        $this->setLayout("admin/default");
        $this->viewRender("Admin/gallery/index", compact('photos','photo'));
    }


    /**
     * ajout d'une nouvelle photo
     */
    public function addGallery()
    {
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $categories = $this->categories->all();

        if (!empty($_FILES)) {
            $surname = strtolower("ngpictures".$file->get('thumb.name') ?? uniqid("ngpictures-"));
            $name = $this->str::escape($post->get('name')) ?? $surname;
            $description = $this->str::escape($post->get('description')) ?? null;
            $tags = $this->str::escape($post->get('tags')) ?? null;
            $category_id = (int) $post->get('category') ?? 1 ;

            if (!empty($file->get('thumb'))) {
                $this->ngGallery->create(compact('name','description','tags','category_id'));
                $last_id = $this->ngGallery->lastInsertId();
                $isUploaded = Image::upload($file, 'ngpictures', "{$name}-{$last_id}", 'ratio');

                if ($isUploaded) {
                    Image::upload($file, 'ng-thumbs-small', "{$name}-{$last_id}", 'small');
                    Image::upload($file, 'ng-thumbs-med', "{$name}-{$last_id}", 'medium');

                    $this->ngGallery->update($last_id, ["thumb" => "{$name}-{$last_id}.jpg"]);
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
        $this->setLayout("admin/default");
        $this->viewRender("Admin/gallery/add", compact('post','categories'));
    }


    /**
     * edition d'une photo
     * @param $id
     */
    public function editGallery($id)
    {
        $photo = $this->ngGallery->find(intval($id));

        if ($photo) {
            $post = new Collection($data ?? $_POST);
            $categories = $this->categories->all();
            if (!empty($post)) {
                if ($post->has('name') || $post->has('tags') || $post->has('description')) {
                    $name = $post->get('name');
                    $tags = $post->get('tags');
                    $description = $post->get('description');
                    $category_id = (int) $post->get('category') ?? 1;
                    $this->NgGallery->update($id, compact('name', 'tags', 'description', 'category_id'));
                    $this->flash->set("success", $this->msg['admin_modified_success']);
                    Ngpic::redirect(true);
                }
            }
            page::setName('administration - gallery');
            $this->setLayout("admin/default");
            $this->viewRender("Admin/gallery/edit", compact('photo', 'categories'));
        } else {
            $this->flash->set('danger', $this->msg['admin_delete_notFound']);
            Ngpic::redirect(true);
        }
    }


    public function album()
    {

    }


    public function addAlbum()
    {

    }


    public function editAlbum()
    {

    }



    /*********************************************************************************************************
    *                                     Website administration. -users
    **********************************************************************************************************/

    /**
     * gestion d'utilisateur
     */
    public function users()
    {
        $users = $this->users->all();
        $user = $this->users->last();
        page::setName("administration - users");
        $this->setLayout("admin/default");
        $this->viewRender("Admin/users/index", compact('users', 'user'));
    }


    /**
     * gestion des permissions
     * @param $id
     */
    public function permissions($id)
    {
        $user = $this->users->find(intval($id));
        if ($user && $user->confirmed_at !== null) {
            if ($user->rank === "admin") {
                $this->users->update($user->id, ['rank' => 'user']);
                $this->flash->set('success', $this->msg['admin_removed_admin']);
                Ngpic::redirect(true);
            } else {
                $this->users->update($user->id, ['rank' => 'admin']);
                $this->flash->set('success', $this->msg['admin_added_admin']);
                Ngpic::redirect(true);
            } 
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
    }



    /*********************************************************************************************************
     *                                     Website administration. - category
     **********************************************************************************************************/



    public function categories()
    {

    }


    public function addCategory()
    {

    }


    public function editCategory()
    {

    }




    /*********************************************************************************************************
     *                                     Website administration. - verset
     **********************************************************************************************************/



    public function verses()
    {

    }


    public function addVerses()
    {

    }


    public function editVerses()
    {

    }



    /*********************************************************************************************************
     *                                     Website administration. - bugs
     **********************************************************************************************************/


    public function bugs()
    {

    }


    /*********************************************************************************************************
     *                                     Website administration. - ideas
     **********************************************************************************************************/

    public function ideas()
    {

    }



    /*********************************************************************************************************
     *                                     Website administration. - event
     **********************************************************************************************************/

    public function event()
    {

    }


    public function addEvent()
    {

    }


    public function editEvent()
    {

    }



}