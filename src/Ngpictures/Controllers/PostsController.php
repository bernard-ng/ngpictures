<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Psr\Container\ContainerInterface;
use Ngpictures\Traits\Controllers\ShowPostTrait;
use Ngpictures\Traits\Controllers\StoryPostTrait;
use Ngpictures\Services\Notification\NotificationService;

class PostsController extends Controller
{
    use StoryPostTrait, ShowPostTrait;

    public $table = "posts";


    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->loadModel(['posts', 'categories']);
        $this->authService->restrict();
    }


    /**
     * affiches les publication d'un user
     *
     * @param string $token
     * @return void
     */
    public function showPosts(string $token)
    {
        if ($this->authService->getToken() == $token) {
            $user = $this->authService->isLogged();

            if ($user) {
                $posts = $this->posts->findWithUser($user->id);

                $this->turbolinksLocation("/my-posts");
                $this->pageManager::setTitle("Mes publications");
                $this->view("frontend/users/posts/posts", compact('posts', 'user'));
            } else {
                $this->flash->set("danger", $this->flash->msg['users_not_found'], false);
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set("danger", $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }
    }


    /**
     * ajout d'une publication
     *
     * @return void
     */
    public function add()
    {
        $post           =   new Collection($_POST);
        $file           =   new Collection($_FILES);
        $errors         =   new Collection();
        $notifier       =   $this->container->get(NotificationService::class);
        $categories     =   $this->categories->orderBy('title', 'ASC');

        if (isset($_POST) && !empty($_POST)) {
            $title          =   $this->str->escape($post->get('title'));
            $content        =   $this->str->escape($post->get('content'));
            $slug           =   $this->str->slugify(empty($title)? "publication" : $title);
            $categories_id  =   (intval($post->get('category')) == 0) ? 1 : intval($post->get('category'));
            $users_id       =   $this->authService->isLogged()->id;

            if (isset($_FILES) && !empty($_FILES)) {
                if (!empty($file->get('thumb.name'))) {
                    if ($this->validator->isValid()) {
                        $this->posts->create(compact('users_id', 'title', 'content', 'slug', 'categories_id'));

                        $last_id    =   $this->posts->lastInsertId();
                        $isUploaded =   $this
                            ->container
                            ->get(ImageManager::class)
                            ->upload($file, 'posts', "ngpictures-{$slug}-{$last_id}", 'article');

                        if ($isUploaded) {
                            $this
                                ->container
                                ->get(ImageManager::class)
                                ->upload($file, 'posts-thumbs', "ngpictures-{$slug}-{$last_id}", 'medium');

                            $this->posts->update(
                                $last_id,
                                [
                                    'thumb' => "ngpictures-{$slug}-{$last_id}.jpg",
                                    'exif' => $this->container->get(ImageManager::class)->getExif($file)
                                ]
                            );

                            $notifier->notify(1, [$this->posts->find($last_id)]);
                            $this->flash->set('success', $this->flash->msg['form_post_submitted'], false);
                            $this->redirect("/posts", true);
                        } else {
                            $this->posts->delete($last_id);
                            $this->flash->set('danger', $this->flash->msg['files_not_uploaded']);
                        }
                    } else {
                        $this->sendFormError();
                    }
                } else {
                    $this->flash->set('danger', $this->flash->msg['post_requires_picture']);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['post_requires_picture']);
            }
        }

        $this->turbolinksLocation('/submit-photo');
        $this->pageManager::setTitle("Publication");
        $this->view("frontend/users/posts/add", compact('post', 'categories', 'errors'));
    }


    /**
     * edition d'une publication
     *
     * @param int $id
     * @param string $token
     * @return void
     */
    public function edit($id, $token)
    {
        $categories = $this->categories->orderBy('title', 'ASC');

        if ($token == $this->authService->getToken()) {
            $publication = $this->posts->find(intval($id));
            if ($publication) {
                $post       =   new Collection($data ?? $_POST);
                $errors     =   new Collection();
                $article    =   $this->posts->find(intval($id));

                if (isset($_POST) && !empty($_POST)) {
                    $title          =   $this->str->escape($post->get('title'));
                    $content        =   $this->str->escape($post->get('content'));
                    $slug           =   $this->str->slugify($title ?? 'publication');
                    $categories_id  =   intval($post->get('category')) ?? 1;

                    $this->posts->update($id, compact('title', 'content', 'slug', 'categories_id'));
                    $this->flash->set("success", $this->flash->msg['post_edit_success'], false);
                    $this->redirect("/my-posts/{$token}", true);
                }

                $this->turbolinksLocation("/my-posts/edit/{$id}/{$token}");
                $this->pageManager::setTitle("Edition");
                $this->view(
                    "frontend/users/posts/edit",
                    compact('article', 'categories', 'post', 'errors')
                );
            } else {
                $this->flash->set("danger", $this->flash->msg['post_not_found'], false);
            }
        }
    }


    /**
     * suppression des publications des users
     * @param string $token
     */
    public function delete($token)
    {
        $model  =   $this->loadModel("posts");
        $post   =   new Collection($_POST);
        $post   =   $model->find(intval($post->get('id')));

        if ($this->authService->getToken() == $token) {
            if ($post && $post->users_id == $this->authService->isLogged()->id) {
                $model->delete($post->id);
                if ($this->isAjax()) {
                    exit();
                }
                $this->flash->set('success', $this->flash->msg['post_delete_success'], false);
                $this->redirect(true, false);
            } else {
                $this->flash->set('danger', $this->flash->msg['delete_not_allowed']);
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['delete_not_allowed']);
            $this->redirect(true, false);
        }
    }
}
