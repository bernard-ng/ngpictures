<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Framework\Managers\Collection;
use Application\Managers\PageManager;
use Psr\Container\ContainerInterface;

/**
 * Class AdminController
 * @package Application\Controllers
 */
class AdminController extends Controller
{
    /**
     * AdminController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->loggedOnly();
        $this->auth->isAdmin();
        PageManager::setMeta(['name' => 'robots', 'content' => 'noindex']);
    }


    /**
     * la method par default
     */
    public function index()
    {
        $blog = $this->blog->latest();
        $posts = $this->posts->latest();
        $photo = $this->gallery->latest();
        $users = [count($this->users->lastConfirmed()), count($this->users->lastNotConfirmed())];
        $site_bugs = $this->bugs->countAll()->num;
        $site_ideas = $this->ideas->countAll()->num;
        $site_posts = [$this->blog->countOnline()->num, $this->blog->countOffline()->num];
        $users_posts = [$this->posts->countOnline()->num, $this->posts->countOffline()->num];
        $site_photos = [$this->gallery->countOnline()->num, $this->gallery->countOffline()->num];
        $users_online = $this->online->countAll()->num;
        $site_categories = $this->categories->countAll()->num;

        $disk_space = disk_free_space(CORE) * 100 / disk_total_space(CORE);
        $used_space = 100 - ceil($disk_space);
        $total_space = ceil($disk_space);

        PageManager::setTitle('admin');
        $this->view(
            'backend/index',
            compact(
                'blog',
                'users',
                'posts',
                'photo',
                'site_bugs',
                'site_ideas',
                'used_space',
                'site_posts',
                'total_space',
                'users_posts',
                'site_photos',
                'users_photos',
                'users_online',
                'site_categories'
            )
        );
    }

    /**
     * @param array|null $data
     * @param string|null $msg
     */
    public function delete(array $data = null, string $msg = null)
    {
        $post = new Collection($data ?? $_POST);

        if ($post->get('id') && $post->get('type')) {
            $model = $this->loadRepository($this->getType($post->get('type')));
            $result = $model->find(intval($post->get('id')));

            if ($result) {
                $model->delete($post->get('id'));
                $this->flash->set('success', $msg ?? $this->flash->msg['post_delete_success'], false);
                $this->redirect(true, false);
            } else {
                $this->flash->set('danger', $this->flash->msg['post_not_found'], false);
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['post_delete_failed'], false);
            $this->redirect(true, false);
        }
    }


    /**
     * permet de supprimer un fichier sur le server
     */
    public function deleteFile()
    {
        if (isset($_POST) && !empty($_POST)) {
            $post = $this->request->input();
            if (!empty($post->get('name')) && !empty($post->get('dir'))) {
                $dir = str_replace('/uploads/', UPLOAD . '/', $post->get('dir'));
                $tdir = str_replace('/uploads/thumbs/', UPLOAD . '/', $post->get('dir'));

                if (is_dir($dir)) {
                    $file = $dir . '/' . $post->get('name');
                    $thumb = $tdir . '/' . $post->get('name');

                    if (is_file($file) || is_file($thumb)) {
                        unlink($file);
                        unlink($thumb);

                        $this->flash->set('success', $this->flash->msg['post_delete_success'], false);
                        $this->redirect(true, false);
                    } else {
                        $this->flash->set('danger', $this->flash->msg['post_delete_failed']);
                        $this->redirect(true, false);
                    }
                } else {
                    $this->flash->set('danger', $this->flash->msg['files_not_directory']);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->redirect(true, false);
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
        $model = $this->loadRepository($this->getType($t));
        $result = $model->find(intval($id));

        if (intval($t) === 5) {
            if ($result->confirmed_at === null) {
                $model->unsetConfirmationToken($result->id);
                $this->redirect(true, false);
            } elseif ($result->confirmed_at !== null) {
                $this->flash->set('success', $this->flash->msg['post_already_online']);
                $this->redirect(true, false);
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect(true, false);
            }
        } else {
            if ($result && !$result->online) {
                $model->update($id, ['online' => 1]);

                if ($this->isAjax()) {
                    echo '<i class="icon icon-download" style="font-size: smaller !important;"></i>';
                    exit;
                }

                $this->flash->set('success', $this->flash->msg['post_online_success'], false);
                $this->redirect(true, false);
            } elseif ($result && $result->online) {
                $model->update($id, ['online' => 0]);

                if ($this->isAjax()) {
                    echo '<i class="icon icon-upload" style="font-size: smaller !important;"></i>';
                    exit;
                }

                $this->flash->set('success', $this->flash->msg['post_offline_success'], false);
                $this->redirect(true, false);
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect(true, false);
            }
        }
    }
}
