<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Entities\PostsEntity;
use Application\Repositories\CategoriesRepository;
use Application\Repositories\CollectionsRepository;
use Application\Repositories\PostsRepository;
use Application\Repositories\UsersRepository;

/**
 * Class AjaxController
 * @package Application\Controllers
 */
class AjaxController extends Controller
{
    public function users_posts()
    {
        if ($this->request->ajax()) {
            $ids = explode("@", $_GET['lastId']);
            $lastId = intval($ids[1]) ?? 0;


            $user = $this->container->get(UsersRepository::class)->find(intval($ids[0]) ?? 0);
            if ($user) {
                $posts = $this->container->get(PostsRepository::class)->userFindLess($user->id, $lastId);
                if ($posts) {
                    echo $this->view('/components/users/posts', compact("posts"));
                    exit();
                } else {
                    $this->flash->set('danger', 'nothing_to_load');
                }
            } else {
                $this->flash->set('danger', 'undefined_error');
            }
        } else {
            $this->flash->set("warning", 'undefined_error');
            $this->redirect(true);
        }
    }

    public function community()
    {
        if ($this->request->ajax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $users = $this->container->get(UsersRepository::class)->findLess($lastId);
            if ($users) {
                echo $this->view('/components/users/community', compact("users"));
                exit();
            } else {
                $this->flash->set('danger', 'nothing_to_load', true);
            }
        } else {
            $this->flash->set("warning", 'undefined_error');
            $this->redirect(true);
        }
    }

    public function posts()
    {
        if ($this->request->ajax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $posts = $this->container->get(PostsRepository::class)->findLess($lastId);

            if ($posts) {
                echo $this->view('/components/imageCard', compact("posts"));
                exit();
            } else {
                $this->flash->set('danger', 'nothing_to_load', true);
            }
        } else {
            $this->flash->set("warning", 'undefined_error');
            $this->redirect(true);
        }
    }

    public function categories()
    {
        if ($this->request->ajax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $categories = $this->container->get(CategoriesRepository::class)->findLess($lastId);

            if ($categories) {
                $posts = $this->container->get(PostsRepository::class);

                foreach ($categories as $category) {
                    /** @var PostsEntity $thumb */
                    $thumb = $posts->findWith('categories_id', $category->id)[0];
                    $categoriesThumbs[$category->id] =
                        (is_null($thumb)) ? "/imgs/default.jpeg" : $thumb->getSmallThumb();
                }

                foreach ($categories as $category) {
                    $categoriesCount[$category->id] = $posts->countWith('categories_id', $category->id);
                }

                echo $this->view('/components/categoriesCard', compact("categories", "categoriesCount", "categoriesThumbs"));
                exit();
            } else {
                $this->flash->set('danger', 'nothing_to_load', true);
            }
        } else {
            $this->flash->set("warning", 'undefined_error');
            $this->redirect();
        }
    }

    public function collections()
    {
        if ($this->request->ajax()) {
            $lastId = intval($_GET['lastId']) ?? 0;
            $posts = $this->container->get(PostsRepository::class);
            $collections = $this->container->get(CollectionsRepository::class)->findLess($lastId);

            if ($collections) {
                foreach ($collections as $c) {
                    /** @var PostsEntity $thumb */
                    $thumb = $posts->findWith('collections_id', $c->id)[0];
                    $collectionsThumbs[$c->id] =
                        (is_null($thumb)) ? "/imgs/default.jpeg" : $thumb->getSmallThumb();
                }

                foreach ($collections as $c) {
                    $collectionsCount[$c->id] = $posts->countWith('collections_id', $c->id);
                }

                echo $this->view('/components/collectionsCard', compact("collections", "collectionsThumbs", "collectionsCount"));
                exit();
            } else {
                $this->flash->set('danger', 'nothing_to_load', true);
            }
        } else {
            $this->flash->set("warning", 'undefined_error');
            $this->redirect();
        }
    }
}
