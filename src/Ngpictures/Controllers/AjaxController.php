<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;

class AjaxController extends Controller
{
    public function users_posts()
    {
        if ($this->isAjax()) {
            $ids = explode("@", $_GET['lastId']);
            $lastId = intval($ids[1]) ?? 0;


            $user = $this->loadModel('users')->find(intval($ids[0]) ?? 0);
            if ($user) {
                $posts = $this->loadModel('posts')->userFindLess($user->id, $lastId);
                if ($posts) {
                    echo $this->view('/ajax/users/posts', compact("posts"), true);
                    exit();
                } else {
                    $this->flash->set('danger', $this->flash->msg['nothing_to_load']);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
            }
        } else {
            $this->flash->set("warning", $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }

    public function community()
    {
        if ($this->isAjax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $users = $this->loadModel('users')->findLess($lastId);
            if ($users) {
                echo $this->view('/ajax/users/community', compact("users"), true);
                exit();
            } else {
                $this->flash->set('danger', $this->flash->msg['nothing_to_load']);
            }
        } else {
            $this->flash->set("warning", $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }


    public function photographers()
    {
        if ($this->isAjax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $this->loadModel(['users', 'photographers']);

            $photographers = $this->photographers->findLess($lastId);
            $photographers = (new Collection($photographers))->asList(', ', "users_id");
            $users = $this->users->findList($photographers);

            if ($users) {
                echo $this->view('/ajax/users/community', compact("users"), true);
                exit();
            } else {
                $this->flash->set('danger', $this->flash->msg['nothing_to_load']);
            }
        } else {
            $this->flash->set("warning", $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }


    public function posts()
    {
        if ($this->isAjax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $posts = $this->loadModel('posts')->findLess($lastId);
            if ($posts) {
                echo $this->view('/ajax/posts/cards', compact("posts"), true);
                exit();
            } else {
                $this->flash->set('danger', $this->flash->msg['nothing_to_load']);
            }
        } else {
            $this->flash->set("warning", $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }


    public function categories()
    {
        if ($this->isAjax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $categories = $this->loadModel('categories')->findLess($lastId);

            if ($categories) {
                $nb = [];
                $thumbs = [];
                $this->loadModel(['blog', 'gallery', 'posts']);

                foreach ($categories as $category) {
                    $thumbs[$category->id] =
                        $this->blog->findWith('categories_id', $category->id, true)->smallThumbUrl ??
                        $this->gallery->findWith('categories_id', $category->id, true)->smallThumbUrl ??
                        $this->posts->findWith('categories_id', $category->id, true)->smallThumbUrl ??
                        '/imgs/default.jpeg';
                }

                foreach ($categories as $category) {
                    $nb[$category->id] =
                        count($this->blog->findWith('categories_id', $category->id, false)) +
                        count($this->gallery->findWith('categories_id', $category->id, false)) +
                        count($this->posts->findWith('categories_id', $category->id, false));
                    ;
                }
                echo $this->view('/ajax/blog/categories_cards', compact("categories", "nb", "thumbs"), true);
                exit();
            } else {
                $this->flash->set('danger', $this->flash->msg['nothing_to_load']);
            }
        } else {
            $this->flash->set("warning", $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }


    public function albums()
    {
        if ($this->isAjax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $albums = $this->loadModel('albums')->findLess($lastId);
            if ($albums) {
                $this->loadModel('gallery');
                $thumbs = [];
                $nb = [];

                foreach ($albums as $album) {
                    $thumbs[$album->id] =
                        $this->gallery->findWith('albums_id', $album->id, true)->smallThumbUrl ??
                        '/imgs/default.jpeg';
                }

                foreach ($albums as $album) {
                    $nb[$album->id] =
                        count($this->gallery->findWith('albums_id', $album->id, false));
                }

                echo $this->view('/ajax/gallery/albums_cards', compact("albums", "thumbs", "nb"), true);
                exit();
            } else {
                $this->flash->set('danger', $this->flash->msg['nothing_to_load']);
            }
        } else {
            $this->flash->set("warning", $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }


    public function gallery()
    {
        if ($this->isAjax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $photos = $this->loadModel('gallery')->findLess($lastId);
            if ($photos) {
                echo $this->view('/ajax/gallery/cards', compact("photos"), true);
                exit();
            } else {
                $this->flash->set('danger', $this->flash->msg['nothing_to_load']);
            }
        } else {
            $this->flash->set("warning", $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }


    public function blog()
    {
        if ($this->isAjax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $posts = $this->loadModel('blog')->findLess($lastId);
            if ($posts) {
                echo $this->view('/ajax/blog/cards', compact("posts"), true);
                exit();
            } else {
                $this->flash->set('danger', $this->flash->msg['nothing_to_load']);
            }
        } else {
            $this->flash->set("warning", $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }


    public function verset()
    {
        $verse = $this->callController('verses')->index();
        require(APP . "/Views/ajax/verset.php");
    }
}
