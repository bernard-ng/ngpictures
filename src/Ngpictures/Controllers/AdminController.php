<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ng\Core\Managers\LogMessageManager;
use Ng\Core\Managers\Mailer\Mailer;
use Ng\Core\Managers\ConfigManager;
use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;
use \DirectoryIterator;
use \UnexpectedValueException;
use \RuntimeException;

/**
 * Class AdminController
 * @package Ngpictures\Controllers
 * controller principale de l'administration
 */
class AdminController extends Controller
{
    /**
     * les differentes tables gerer par l'admin
     * @var array
     */
    private $types = [
        1 => 'posts',
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
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->callController('users')->isAdmin();

        $this->pageManager::setMeta(['name' => 'robots', 'content' => 'noindex']);
        $this->loadModel(['users', 'posts', 'blog', 'gallery', 'ideas', 'bugs', 'categories', 'verses', 'albums']);
    }


    /**
     * la method par default
     */
    public function index()
    {
        $posts = $this->posts->latest();
        $blog = $this->blog->latest();

        $site_posts = [
            count($this->blog->lastOnline()),
            count($this->blog->lastOffline())
        ];
        $users_posts = [
            count($this->posts->lastOnline()),
            count($this->posts->lastOffline())
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

        $this->pageManager::setName('admin');

        $this->setLayout('admin/default');
        $this->viewRender(
            'back_end/index',
            compact(
                'posts',
                'blog',
                'site_posts',
                'users_posts',
                'site_photos',
                'users_photos',
                'users',
                'users_online',
                'site_categories',
                'site_bugs',
                'site_ideas',
                'used_space',
                'total_space'
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
                $this->flash->set('danger', $msg ?? $this->msg['post_delete_success']);
                $this->app::redirect(true);
            } else {
                if ($this->isAjax()) {
                    $this->ajaxFail($this->msg['post_not_found']);
                }
                $this->flash->set('danger', $this->msg['post_not_found']);
                $this->app::redirect(true);
            }
        } else {
            if ($this->isAjax()) {
                $this->ajaxFail($this->msg['post_delete_failed']);
            }
            $this->flash->set('danger', $this->msg['post_delete_failed']);
            $this->app::redirect(true);
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
                        $this->flash->set('success', $this->msg['post_delete_success']);
                        $this->app::redirect(true);
                    } else {
                        if ($this->isAjax()) {
                            $this->ajaxFail($this->msg['post_delete_failed']);
                        }
                        $this->flash->set('danger', $this->msg['post_delete_failed']);
                        $this->app::redirect(true);
                    }
                } else {
                    if ($this->isAjax()) {
                        $this->ajaxFail($this->msg['files_not_directory']);
                    }
                    $this->flash->set('danger', $this->msg['files_not_directory']);
                    $this->app::redirect(true);
                }
            } else {
                if ($this->isAjax()) {
                    $this->ajaxFail($this->msg['undefined_error']);
                }
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
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
                $this->app::redirect(true);
            } elseif ($result->confirmed_at !== null) {
                $this->flash->set('success', $this->msg['post_already_online']);
                $this->app::redirect(true);
            } else {
                if ($this->isAjax()) {
                    $this->ajaxFail($this->msg['undefined_error']);
                }
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
            }
        } else {
            if ($result && !$result->online) {
                $model->update($id, ['online' => 1]);

                if ($this->isAjax()) {
                    echo '<i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>';
                    exit;
                }

                $this->flash->set('success', $this->msg['post_online_success']);
                $this->app::redirect(true);
            } elseif ($result && $result->online) {
                $model->update($id, ['online' => 0]);

                if ($this->isAjax()) {
                    echo '<i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>';
                    exit;
                }

                $this->flash->set('success', $this->msg['post_offline_success']);
                $this->app::redirect(true);
            } else {
                if ($this->isAjax()) {
                    $this->ajaxFail($this->msg['undefined_error']);
                }
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
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
        $posts = $this->blog->orderBy('id', 'DESC');
        $article = $this->blog->last();
        $this->pageManager::setName('Adm - blog');
        $this->setLayout("admin/default");
        $this->viewRender(
            "back_end/blog/index",
            compact(
                "posts",
                "article"
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
                $this->validator->isEmpty('title', $this->msg['form_all_required']);
                $this->validator->isEmpty('content', $this->msg['form_all_required']);
                $this->validator->isEmpty('slug', $this->msg['form_all_required']);
                $this->validator->isKebabCase('slug', $this->msg['form_bad_slug']);

                if ($this->validator->isValid()) {
                    $title = $this->str::escape($post->get('title'));
                    $content = $post->get('content');
                    $slug = $this->str::escape($post->get('slug'));
                    $category_id = (int)$post->get('category') ?? 1;

                    $this->blog->update($id, compact('title', 'content', 'slug', 'category_id'));
                    $this->flash->set("success", $this->msg['post_edit_success']);
                    $this->app::redirect(ADMIN . "/blog");
                } else {
                    var_dump($this->validator->getErrors());
                }
            } else {
                $this->flash->set('danger', $this->msg['form_all_required']);
            }
        }

        $this->pageManager::setName('Adm - blog.edit');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/blog/edit', compact('article', 'categories', 'post'));
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
                    $this->validator->isKebabCase('slug', $this->msg['form_bad_slug']);
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
                            $isUploaded = ImageManager::upload($file, 'blog', "ngpictures-{$slug}-{$last_id}", 'article');

                            if ($isUploaded) {
                                ImageManager::upload($file, 'blog-thumbs', "ngpictures-{$slug}-{$last_id}", 'small');
                                $this->blog->update($last_id, ['thumb' => "ngpictures-{$slug}-{$last_id}.jpg"]);
                                $this->flash->set('success', $this->msg['form_post_submitted']);
                                $this->app::redirect(ADMIN . "/blog");
                            } else {
                                $this->flash->set('danger', $this->msg['files_not_uploaded']);
                                $this->blog->delete($last_id);
                            }
                        } else {
                            var_dump($this->validator->getErrors());
                        }
                    } else {
                        $this->flash->set('danger', $this->msg['post_requries_picture']);
                    }
                }
            } else {
                $this->flash->set('danger', $this->msg['form_all_required']);
            }
        }

        $this->pageManager::setName('Adm - blog.add');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/blog/add', compact('post', 'categories'));
    }


    /**
     * liste des differentes categories
     */
    public function categories()
    {
        $categories = $this->categories->all();

        $this->pageManager::setName('admin categories');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/blog/categories', compact('categories'));
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
                $this->flash->set('success', $this->msg['form_post_submitted']);
                $this->app::redirect(ADMIN . "/blog/categories");
            } else {
                $this->flash->set('danger', $this->msg['form_all_required']);
            }
        }

        $this->pageManager::setName('admin categories.add');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/blog/categories.add', compact('post'));
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
                    $this->flash->set('success', $this->msg['post_edit_success']);
                    $this->app::redirect(ADMIN . "/blog/categories");
                } else {
                    $this->flash->set('danger', $this->msg['form_all_required']);
                }
            }

            $this->pageManager::setName('admin categories.edit');
            $this->setLayout('admin/default');
            $this->viewRender('back_end/blog/categories.edit', compact('post', 'category'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
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
        $this->pageManager::setName('Adm - gallery');
        $this->setLayout("admin/default");
        $this->viewRender("back_end/gallery/index", compact('photos', 'photo'));
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
                $isUploaded = ImageManager::upload($file, 'gallery', "{$name}-{$last_id}", 'ratio');

                if ($isUploaded) {
                    ImageManager::upload($file, 'gallery-thumbs', "{$name}-{$last_id}", 'small');

                    $this->gallery->update($last_id, ["thumb" => "{$name}-{$last_id}.jpg"]);
                    $this->flash->set('success', $this->msg['form_post_submitted']);
                    $this->app::redirect(ADMIN . "/gallery");
                } else {
                    $this->flash->set('danger', $this->msg['files_not_uploaded']);
                    $this->gallery->delete($last_id);
                }
            } else {
                $this->flash->set('danger', $this->msg['post_requries_picture']);
                $this->app::redirect(true);
            }
        }
        $this->pageManager::setName('Adm - gallery.add');
        $this->setLayout("admin/default");
        $this->viewRender("back_end/gallery/add", compact('post', 'categories'));
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
                    $this->flash->set("success", $this->msg['post_edit_success']);
                    $this->app::redirect(ADMIN . "/gallery");
                }
            }
            $this->pageManager::setName('Adm - gallery.edit');
            $this->setLayout("admin/default");
            $this->viewRender("back_end/gallery/edit", compact('photo', 'categories'));
        } else {
            $this->flash->set('danger', $this->msg['post_not_found']);
            $this->app::redirect(true);
        }
    }


    /**
     * modal de selection d'imageManager
     * c'est juste un mediabrowser pour les posts
     */
    public function mediaBrowser()
    {
        $images = $this->gallery->all();
        $this->pageManager::setName('admin media-browser');
        $this->setLayout('modal');
        $this->viewRender('back_end/gallery/media-browser', compact('images'));
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
            if ($this->app::hasDebug()) {
                die($e->getMessage());
            } else {
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
            }
        } catch (RuntimeException $e) {
            if ($this->app::hasDebug()) {
                die($e->getMessage());
            } else {
                $this->flash->set('danger', $this->msg['files_not_directory']);
                $this->app::redirect(true);
            }
        }

        $this->pageManager::setName('admin file-browser');
        $this->setLayout('modal');
        $this->viewRender('back_end/gallery/file-browser', compact('files', 'relative_dos'));
    }


    /**
     * list les differents albums
     * un album poura contenir des photo de n'importe quel categorie
     */
    public function album()
    {
        $albums = $this->albums->all();

        $this->pageManager::setName('admin gallery.album');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/gallery/albums', compact('albums'));
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
                $this->flash->set('success', $this->msg['form_post_submitted']);
                $this->app::redirect(ADMIN . "/gallery");
            } else {
                $this->flash->set('danger', $this->msg['form_all_required']);
            }
        }

        $this->pageManager::setName('admin album.add');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/gallery/albums.add', compact('post'));
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
                    $this->flash->set('success', $this->msg['post_edit_success']);
                    $this->app::redirect(ADMIN . "/gallery");
                } else {
                    $this->flash->set('danger', $this->msg['form_all_required']);
                }
            }

            $this->pageManager::setName('admin album.edit');
            $this->setLayout('admin/default');
            $this->viewRender('back_end/gallery/albums.edit', compact('post', 'album'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }



    /*********************************************************************************************************
     *                                     Website admin. -users
     **********************************************************************************************************/

    /**
     * gestion d'Managersisateur
     */
    public function users()
    {
        $users = $this->users->all();
        $user = $this->users->last();

        $this->pageManager::setName("Adm - users");
        $this->setLayout("admin/default");
        $this->viewRender(
            "back_end/users/index",
            compact('users', 'user', 'bugs', 'ideas')
        );
    }



    /**
     * gestion d'posts des utilisateurs
     */
    public function posts()
    {
        $posts = $this->posts->orderBy('id', 'DESC');
        $article = $this->posts->last();
        $this->pageManager::setName('Adm - posts');
        $this->setLayout("Admin/default");
        $this->viewRender(
            "back_end/posts/index",
            compact(
                "posts",
                "article"
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
                $this->app::redirect(true);
            } else {
                $this->users->update($user->id, ['rank' => 'admin']);
                $this->flash->set('success', $this->msg['admin_added_admin']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    /**
     * gestion des bugs
     */
    public function bugs()
    {
        $bugs = $this->bugs->all();
        $this->pageManager::setName('Adm - bugs');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/users/bugs', compact('bugs'));
    }


    /**
     * gestion des ideas
     */
    public function ideas()
    {
        $ideas = $this->ideas->all();
        $this->pageManager::setName('Adm - ideas');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/users/ideas', compact('ideas'));
    }


    /*********************************************************************************************************
     *                                     Website admin. -message logs
     **********************************************************************************************************/

     /**
      * affiche les erreurs grace au logMessageManager
      */
    public function showLogs()
    {
        if (is_file(ROOT."/system-logs")) {
            $logs = file_get_contents(ROOT."/system-logs");
        } else {
            $logs = "file : system-logs not found";
        }

        $this->pageManager::setName('Adm - Logs');
        $this->setLayout("admin/default");
        $this->viewRender('back_end/logs', compact('logs'));
    }


    /**
     * supprimer les erreurs logs, renitialise
     *
     * @return void
     */
    public function deleteLogs()
    {
        LogMessageManager::clear();
        $this->flash->set("success", $this->msg['success']);
        $this->app::redirect(true);
    }


    /**
     * envoyer les logs a l'admin par mail
     *
     * @return void
     */
    public function sendLogs()
    {
        $email = (new ConfigManager(ROOT."/config/SystemConfig.php"))->get('site.email');
        try {
            (new Mailer())->sendLogs($email);
            $this->flash->set("success", $this->msg['success']);
            $this->app::redirect(true);
        } catch (RuntimeException $e) {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    /*********************************************************************************************************
     *                                     Website admin. - page html modifiable
    **********************************************************************************************************/

    public function showPages()
    {
        $path = APP."/Views/front_end/static/";

        try {
            $files = new DirectoryIterator($path);
        } catch (UnexpectedValueException $e) {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        } catch (RuntimeException $e) {
            $this->flash->set('danger', $this->msg['files_not_directory']);
            $this->app::redirect(true);
        }

        $this->pageManager::setName("Adm - Les Pages");
        $this->setLayout('admin/default');
        $this->viewRender("back_end/pages/pages", compact('files'));
    }


    public function editPages(string $page_name)
    {
        $file_url = APP."/Views/front_end/static/{$page_name}";
        $file_name = $page_name;

        if (is_file($file_url)) {
            $post = new Collection($_POST);
            $file_content = file_get_contents($file_url);

            if (isset($_POST) && !empty($_POST)) {
                $file_content = $post->get('file_content');
                $file = fopen($file_url, 'w');
                fwrite($file, $post->get('file_content'));
                fclose($file);
            }

            $this->setLayout("admin/default");
            $this->pageManager::setName("Adm - Modifier une page");
            $this->viewRender("back_end/pages/edit", compact('file_content', 'file_name', 'post'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }

}
