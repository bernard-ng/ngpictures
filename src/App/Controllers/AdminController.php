<?php
namespace Ngpictures\Controllers;


use Ngpictures\Ngpictures;
use Ngpictures\Util\Page;
use Ng\Core\Generic\{Collection,Image};

use \DirectoryIterator;
use \UnexpectedValueException;
use \RuntimeException;

/**
 * Class AdminController
 * @package Ngpictures\Controllers
 * controller principale de l'administration
 */
class AdminController extends NgpicController
{
    /**
     * les differentes tables gerer par l'admin
     * @var array
     */
    private $types = [
        1 => 'articles',
        'gallery',
        'blog',
        'gallery',
        'users',
        'ideas',
        'bugs',
        'verses',
        'categories',
        'albums'
    ];


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
                'users',
                'articles',
                'blog',
                'gallery',
                'ideas',
                'bugs',
                'categories',
                'verses',
                'albums'
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

        $site_articles = [
            count($this->blog->lastOnline()),
            count($this->blog->lastOffline())
        ];
        $users_articles = [
            count($this->articles->lastOnline()),
            count($this->articles->lastOffline())
        ];
        $site_photos = [
            count($this->gallery->lastOnline()),
            count($this->gallery->lastOffline())
        ];
        $users = [
            count($this->users->lastConfirmed()),
            count($this->users->lastNotConfirmed())
        ];

        $disk_space = disk_free_space(CORE) * 100 / disk_total_space(CORE);
        $used_space = 100 - ceil($disk_space);
        $total_space = ceil($disk_space);

        $users_online = count($this->loadModel('online')->all());
        $site_categories = count($this->loadModel('categories')->all());
        $site_bugs = count($this->loadModel('bugs')->all());
        $site_ideas = count($this->loadModel('ideas')->all());

        Page::setName('admin | Ngpictures');

        $this->setLayout('admin/default');
        $this->viewRender('admin/index',
            compact(
                'articles', 'blog',
                'site_articles', 'users_articles',
                'site_photos', 'users_photos',
                'users', 'users_online', 'site_categories',
                'site_bugs', 'site_ideas', 'used_space', 'total_space'
            )
        );
    }


    /**
     * permet de supprime un post dans la base de donnée
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
                Ngpictures::redirect(true);
            } else {
                if ($this->isAjax()) $this->ajaxFail($this->msg['admin_delete_notFound']);
                $this->flash->set('danger', $this->msg['admin_delete_notFound']);
                Ngpictures::redirect(true);
            }
        } else {
            if ($this->isAjax()) $this->ajaxFail($this->msg['admin_delete_failed']);
            $this->flash->set('danger', $this->msg['admin_delete_failed']);
            Ngpictures::redirect(true);
        }
    }


    /**
     * permet de supprimer un fichier sur le server
     */
    public function deleteFile()
    {
        if (isset($_POST) && !empty($_POST)) {
            $post = new Collection($_POST);
            if (!empty($post->get('name')) && !empty($post->get('dir'))) {
                $dir = str_replace('/uploads/', UPLOAD.'/', $post->get('dir'));
                if (is_dir($dir)) {
                    $file = $dir.'/'.$post->get('name');
                    if (is_file($file)) {
                        unlink($file);
                        $this->flash->set('success', $this->msg['admin_delete_success']);
                        Ngpictures::redirect(true);
                    } else {
                        if ($this->isAjax()) $this->ajaxFail($this->msg['admin_delete_failed']);
                        $this->flash->set('danger', $this->msg['admin_delete_failed']);
                        Ngpictures::redirect(true);
                    }
                } else {
                    if ($this->isAjax()) $this->ajaxFail($this->msg['admin_not_directory']);
                    $this->flash->set('danger', $this->msg['admin_not_directory']);
                    Ngpictures::redirect(true);
                }
            } else {
                if ($this->isAjax()) $this->ajaxFail($this->msg['indefined_error']);
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpictures::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpictures::redirect(true);
        }
    }


    /**
     * mettre du contenu en ligne ou pas
     * confirmer un membre aussi
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
                Ngpictures::redirect(true);
            } elseif ($result->confirmed_at !== null) {
                $this->flash->set('success', $this->msg['admin_already_confrimed']);
                Ngpictures::redirect(true);
            } else {
                if ($this->isAjax()) $this->ajaxFail($this->msg['indefined_error']);
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpictures::redirect(true);
            }
        } else {
            if ($result && !$result->online) {
                $model->update($id, ['online' => 1]);

                if ($this->isAjax()) {
                    echo '<i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>';
                    exit;
                }

                $this->flash->set('success', $this->msg['admin_confirm_success']);
                Ngpictures::redirect(true);
            } elseif ($result && $result->online) {
                $model->update($id, ['online' => 0]);

                if ($this->isAjax()) {
                    echo '<i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>';
                    exit;
                }

                $this->flash->set('success', $this->msg['admin_remove_success']);
                Ngpictures::redirect(true);
            } else {
                if ($this->isAjax()) $this->ajaxFail($this->msg['indefined_error']);
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpictures::redirect(true);
            }
        }
    }


    /*********************************************************************************************************
     *                                     Website admin. - blog
     **********************************************************************************************************/

    /**
     * gestion du blog
     */
    public function blog()
    {
        $articles = $this->blog->orderBy('id', 'DESC');
        $article = $this->blog->last();
        Page::setName('admin - blog | Ngpictures');
        $this->setLayout("admin/default");
        $this->viewRender("admin/blog/index",
            compact(
                "articles", "article"
            )
        );

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
        $categories = $this->categories->orderBy('title', 'ASC');
        $post = new Collection($data ?? $_POST);

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('content')) && !empty($post->get('title')) && !empty($post->get('slug'))) {

                $this->validator->isEmpty('title', $this->msg['admin_all_fields']);
                $this->validator->isEmpty('content', $this->msg['admin_all_fields']);
                $this->validator->isEmpty('slug', $this->msg['admin_all_fields']);
                $this->validator->isKebabCase('slug', $this->msg['admin_slug_notKebab']);

                if ($this->validator->isValid()) {
                    $title = $this->str::escape($post->get('title'));
                    $content = $post->get('content');
                    $slug = $this->str::escape($post->get('slug'));
                    $category_id = (int)$post->get('category') ?? 1;

                    $this->blog->update($id, compact('title', 'content', 'slug', 'category_id'));
                    $this->flash->set("success", $this->msg['admin_modified_success']);
                    Ngpictures::redirect(ADMIN . "/blog");
                } else {
                    var_dump($this->validator->getErrors());
                }
            } else {
                $this->flash->set('danger', $this->msg['admin_all_fields']);
            }
        }

        Page::setName('admin - blog.edit | Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('admin/blog/edit', compact('article', 'categories', 'post'));
    }


    /**
     * ajout d'un nouvel article
     * le contenu $content n'est pas echapper a cause de l'editeur
     */
    public function add()
    {
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $categories = $this->categories->orderBy('title', 'ASC');

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

                $category_id = ($post->get('category') == 0) ? 1 : $post->get('category');

                if (isset($_FILES) && !empty($_FILES)) {
                    if (!empty($file->get('thumb.name'))) {
                        if ($this->validator->isValid()) {
                            $this->blog->create(compact('title', 'content', 'slug', 'category_id'));

                            $last_id = $this->blog->lastInsertId();
                            $isUploaded = Image::upload($file, 'blog', "ngpictures-{$slug}-{$last_id}", 'article');

                            if ($isUploaded) {
                                Image::upload($file, 'blog-thumbs', "ngpictures-{$slug}-{$last_id}", 'small');
                                $this->blog->update($last_id, ['thumb' => "ngpictures-{$slug}-{$last_id}.jpg"]);
                                $this->flash->set('success', $this->msg['admin_post_success']);
                                Ngpictures::redirect(ADMIN . "/blog");
                            } else {
                                $this->flash->set('danger', $this->msg['admin_file_notUploaded']);
                                $this->blog->delete($last_id);
                            }
                        } else {
                            var_dump($this->validator->getErrors());
                        }
                    } else {
                        $this->flash->set('danger', $this->msg['admin_picture_required']);
                    }
                }
            } else {
                $this->flash->set('danger', $this->msg['admin_all_fields']);
            }
        }

        Page::setName('admin - blog.add | Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('admin/blog/add', compact('post', 'categories'));
    }


    /**
     * liste des differentes categories
     */
    public function categories()
    {
        $categories = $this->categories->all();

        Page::setName('admin categories | Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('Admin/blog/categories', compact('categories'));
    }

    /**
     * ajout d'une categorie
     */
    public function addCategory()
    {
        $post = new Collection($_POST);

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('title')) && !empty($post->get('description'))) {
                $title = $this->str::escape($post->get('title'));
                $description = $post->get('description');
                $slug = $this->str::slugify($title);

                $this->categories->create(compact('title', 'description', 'slug'));
                $this->flash->set('success', $this->msg['admin_post_success']);
                Ngpictures::redirect(ADMIN . "/blog/categories");

            } else {
                $this->flash->set('danger', $this->msg['admin_all_fields']);
            }
        }

        Page::setName('admin categories.add | Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('Admin/blog/categories.add', compact('post'));
    }


    /**
     * edition d'une categorie
     * @param $id
     */
    public function editCategory($id)
    {
        $post = new Collection($_POST);
        $category = $this->categories->find(intval($id));
        if ($category) {
            if (isset($_POST) && !empty($_POST)) {
                if (!empty($post->get('title')) && !empty($post->get('description'))) {
                    $title = $this->str::escape($post->get('title')) ?? $category->title;
                    $description = $post->get('description') ?? $category->description;
                    $slug = $this->str::slugify($title);

                    $this->categories->update($category->id, compact('title', 'description', 'slug'));
                    $this->flash->set('success', $this->msg['admin_modified_success']);
                    Ngpictures::redirect(ADMIN . "/blog/categories");

                } else {
                    $this->flash->set('danger', $this->msg['admin_all_fields']);
                }
            }

            Page::setName('admin categories.edit | Ngpictures');
            $this->setLayout('admin/default');
            $this->viewRender('Admin/blog/categories.edit', compact('post', 'category'));
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpictures::redirect(true);
        }
    }



    /*********************************************************************************************************
     *                                     Website admin. -gallerie
     **********************************************************************************************************/


    /**
     * gestion de la gallery
     */
    public function gallery()
    {
        $photos = $this->gallery->all();
        $photo = $this->gallery->latest();
        page::setName('admin - gallery');
        $this->setLayout("admin/default");
        $this->viewRender("Admin/gallery/index", compact('photos', 'photo'));
    }


    /**
     * ajout d'une nouvelle photo
     */
    public function addGallery()
    {
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $categories = $this->categories->orderBy('title', 'ASC');

        if (!empty($_FILES)) {
            if (empty($this->str::escape($post->get('name')))) {
                $name = strtolower(uniqid("ngpictures-"));
            } else {
                $name = $this->str::escape($post->get('name'));
            }

            $description = $post->get('description') ?? null;
            $tags = $this->str::escape($post->get('tags')) ?? null;
            $category_id = (int)$post->get('category') ?? 1;

            if (!empty($file->get('thumb'))) {
                $this->gallery->create(compact('name', 'description', 'tags', 'category_id'));
                $last_id = $this->gallery->lastInsertId();
                $isUploaded = Image::upload($file, 'gallery', "{$name}-{$last_id}", 'ratio');

                if ($isUploaded) {
                    Image::upload($file, 'gallery-thumbs', "{$name}-{$last_id}", 'small');

                    $this->gallery->update($last_id, ["thumb" => "{$name}-{$last_id}.jpg"]);
                    $this->flash->set('success', $this->msg['admin_post_success']);
                    Ngpictures::redirect(ADMIN . "/gallery");

                } else {
                    $this->flash->set('danger', $this->msg['admin_file_notUploaded']);
                    $this->gallery->delete($last_id);
                }
            } else {
                $this->flash->set('danger', $this->msg['admin_picture_required']);
                Ngpictures::redirect(true);
            }
        }
        page::setName('admin - gallery.add | Ngpictures');
        $this->setLayout("admin/default");
        $this->viewRender("Admin/gallery/add", compact('post', 'categories'));
    }


    /**
     * edition d'une photo
     * @param $id
     */
    public function editGallery($id)
    {
        $photo = $this->gallery->find(intval($id));

        if ($photo) {
            $post = new Collection($data ?? $_POST);
            $categories = $this->categories->orderBy('title', 'ASC');
            if (!empty($post)) {
                if ($post->has('name') || $post->has('tags') || $post->has('description')) {
                    $name = $post->get('name');
                    $tags = $post->get('tags');
                    $description = $post->get('description');
                    $category_id = (int)$post->get('category') ?? 1;
                    $this->gallery->update($id, compact('name', 'tags', 'description', 'category_id'));
                    $this->flash->set("success", $this->msg['admin_modified_success']);
                    Ngpictures::redirect(ADMIN . "/gallery");
                }
            }
            page::setName('admin - gallery.edit | Ngpictures');
            $this->setLayout("admin/default");
            $this->viewRender("Admin/gallery/edit", compact('photo', 'categories'));
        } else {
            $this->flash->set('danger', $this->msg['admin_delete_notFound']);
            Ngpictures::redirect(true);
        }
    }


    /**
     * modal de selection d'image
     * c'est juste un mediabrowser pour les articles
     */
    public function mediaBrowser()
    {
        $images = $this->gallery->all();
        Page::setName('admin media-browser | Ngpictures');
        $this->setLayout('modal');
        $this->viewRender('Admin/gallery/media-browser', compact('images'));
    }


    /**
     * permet de faire un access au fichier se situant sur le server
     * @param $dirname
     */
    public function fileBrowser($dirname)
    {
        $dos = UPLOAD."/{$dirname}";
        $relative_dos = "/uploads/{$dirname}";

        try {
            $files = new DirectoryIterator($dos);
        } catch (UnexpectedValueException $e) {
            if (Ngpictures::hasDebug()) {
                die($e->getMessage());
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpictures::redirect(true);
            }
        } catch (RuntimeException $e) {
            if (Ngpictures::hasDebug()) {
                die($e->getMessage());
            } else {
                $this->flash->set('danger', $this->msg['admin_not_directory']);
                Ngpictures::redirect(true);
            }
        }

        Page::setName('admin file-browser | Ngpictures');
        $this->setLayout('modal');
        $this->viewRender('Admin/gallery/file-browser', compact('files','relative_dos'));
    }


    /**
     * list les differents albums
     * un album poura contenir des photo de n'importe quel categorie
     */
    public function album()
    {
        $albums = $this->albums->all();

        Page::setName('admin gallery.album | Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('Admin/gallery/albums', compact('albums'));
    }


    /**
     * ajout d'un nouvelle album
     */
    public function addAlbum()
    {
        $post = new Collection($_POST);

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('title')) && !empty($post->get('description'))) {
                $title = $this->str::escape($post->get('title'));
                $description = $post->get('description');
                $slug = $this->str::slugify($title);

                $this->albums->create(compact('title', 'description', 'slug'));
                $this->flash->set('success', $this->msg['admin_post_success']);
                Ngpictures::redirect(ADMIN . "/gallery");

            } else {
                $this->flash->set('danger', $this->msg['admin_all_fields']);
            }
        }

        Page::setName('admin album.add | Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('Admin/gallery/albums.add', compact('post'));
    }


    /**
     * edition d'information d'un album
     * @param $id
     */
    public function editAlbum($id)
    {
        $post = new Collection($_POST);
        $album = $this->albums->find(intval($id));
        if ($album) {
            if (isset($_POST) && !empty($_POST)) {
                if (!empty($post->get('title')) && !empty($post->get('description'))) {
                    $title = $this->str::escape($post->get('title')) ?? $album->title;
                    $description = $post->get('description') ?? $album->description;
                    $slug = $this->str::slugify($title);

                    $this->albums->update($album->id, compact('title', 'description', 'slug'));
                    $this->flash->set('success', $this->msg['admin_modified_success']);
                    Ngpictures::redirect(ADMIN . "/gallery");

                } else {
                    $this->flash->set('danger', $this->msg['admin_all_fields']);
                }
            }

            Page::setName('admin album.edit | Ngpictures');
            $this->setLayout('admin/default');
            $this->viewRender('Admin/gallery/albums.edit', compact('post', 'album'));
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpictures::redirect(true);
        }

    }



    /*********************************************************************************************************
     *                                     Website admin. -users
     **********************************************************************************************************/

    /**
     * gestion d'utilisateur
     */
    public function users()
    {
        $users = $this->users->all();
        $user = $this->users->last();

        page::setName("admin - users | Ngpictures");
        $this->setLayout("admin/default");
        $this->viewRender("Admin/users/index",
            compact('users', 'user', 'bugs', 'ideas')
        );
    }



    /**
     * gestion d'articles des utilisateurs
     */
    public function articles()
    {
        $articles = $this->articles->orderBy('id', 'DESC');
        $article = $this->articles->last();
        Page::setName('admin - articles | Ngpictures');
        $this->setLayout("Admin/default");
        $this->viewRender("Admin/articles/index",
            compact(
                "articles", "article"
            )
        );
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
                Ngpictures::redirect(true);
            } else {
                $this->users->update($user->id, ['rank' => 'admin']);
                $this->flash->set('success', $this->msg['admin_added_admin']);
                Ngpictures::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpictures::redirect(true);
        }
    }


    /**
     * gestion des bugs
     */
    public function bugs()
    {
        $bugs = $this->bugs->all();
        Page::setName('admin - bugs | Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('Admin/users/bugs',compact('bugs'));
    }


    /**
     * gestion des ideas
     */
    public function ideas()
    {
        $ideas = $this->ideas->all();
        Page::setName('admin - ideas | Ngpictures');
        $this->setLayout('admin/default');
        $this->viewRender('Admin/users/ideas',compact('ideas'));
    }
}
