<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ng\Core\Managers\Collection;
use Ngpictures\Managers\PageManager;


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
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->authService->isAdmin();

        $this->pageManager::setMeta(['name' => 'robots', 'content' => 'noindex']);
        $this->loadModel(['users', 'posts', 'blog', 'gallery', 'ideas', 'bugs', 'categories', 'verses', 'albums']);
    }


    /**
     * la method par default
     */
    public function index()
    {
        $posts         =  $this->posts->latest();
        $blog          =  $this->blog->latest();
        $photo         =  $this->gallery->latest();

        $site_posts    = [count($this->blog->lastOnline()), count($this->blog->lastOffline())];
        $users_posts   = [count($this->posts->lastOnline()), count($this->posts->lastOffline())];
        $site_photos   = [count($this->gallery->lastOnline()), count($this->gallery->lastOffline())];
        $users         = [count($this->users->lastConfirmed()), count($this->users->lastNotConfirmed())];

        $disk_space    = disk_free_space(CORE) * 100 / disk_total_space(CORE);
        $used_space    = 100 - ceil($disk_space);
        $total_space   = ceil($disk_space);

        $site_bugs          =   count($this->loadModel('bugs')->all());
        $site_ideas         =   count($this->loadModel('ideas')->all());
        $users_online       =   count($this->loadModel('online')->all());
        $site_categories    =   count($this->loadModel('categories')->all());

        $this->pageManager::setName('admin');
        $this->setLayout('admin/default');
        $this->viewRender(
            'back_end/index',
            compact(
                'posts',
                'blog',
                'photo',
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
            $model      =    $this->loadModel($this->getType($post->get('type')));
            $result     =    $model->find(intval($post->get('id')));

            if ($result) {
                $model->delete($post->get('id'));
                $this->flash->set('success', $msg ?? $this->msg['post_delete_success']);
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
                $tdir = str_replace('/uploads/thumbs/', UPLOAD.'/', $post->get('dir'));

                if (is_dir($dir)) {
                    $file = $dir.'/'.$post->get('name');
                    $thumb = $tdir.'/'.$post->get('name');

                    if (is_file($file) || is_file($thumb)) {
                        unlink($file);
                        unlink($thumb);

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
     * @param int  $t
     * @param int $id
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
                    echo '<i class="icon icon-download" style="font-size: smaller !important;"></i>';
                    exit;
                }

                $this->flash->set('success', $this->msg['post_online_success']);
                $this->app::redirect(true);
            } elseif ($result && $result->online) {
                $model->update($id, ['online' => 0]);

                if ($this->isAjax()) {
                    echo '<i class="icon icon-upload" style="font-size: smaller !important;"></i>';
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
}
