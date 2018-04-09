<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ngpictures\Traits\Controllers\ShowPostTrait;
use Ngpictures\Traits\Controllers\StoryPostTrait;
use Ngpictures\Managers\PageManager;
use Ngpictures\Ngpictures;

class PostsController extends Controller
{
    public $table = "posts";

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('posts');
        $this->loadModel('categories');
    }

    use StoryPostTrait;
    use ShowPostTrait;


    public function showPosts(string $token)
    {
        $this->callController("users")->restrict();
        if ($this->session->read(TOKEN_KEY) == $token) {
            $user = $this->session->read(AUTH_KEY);

            if ($user) {
                $posts = $this->posts->findWithUser($user->id);
                $this->pageManager::setName("Mes publications");
                $this->setLayout("posts/default");
                $this->viewRender("front_end/users/posts/posts", compact('posts', 'user'));
            } else {
                $this->flash->set("danger", $this->msg['users_not_found']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set("danger", $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    public function add()
    {
        $this->callController("users")->restrict();
        $post           =   new Collection($_POST);
        $file           =   new Collection($_FILES);
        $errors         =   new Collection();
        $categories     =   $this->categories->orderBy('title', 'ASC');

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('title', 'required');
            $this->validator->setRule('content', 'required');

            if ($this->validator->isValid()) {
                $title          =   $this->str::escape($post->get('title'));
                $content        =   $this->str::escape($post->get('content'));
                $slug           =   $this->str::slugify($title);
                $categories_id    =   ($post->get('category') == 0) ? 1 : $post->get('category');
                $users_id        =   intval($this->session->getValue(AUTH_KEY, 'id'));
            } else {
                $errors = new Collection($this->validator->getErrors());
                $this->flash->set('danger', $this->msg['form_multi_errors']);
            }

            if (isset($_FILES) && !empty($_FILES)) {
                if (!empty($file->get('thumb.name'))) {
                    if ($this->validator->isValid()) {
                        $this->posts->create(compact('users_id', 'title', 'content', 'slug', 'categories_id'));

                        $last_id    =   $this->posts->lastInsertId();
                        $isUploaded =   ImageManager::upload($file, 'posts', "ngpictures-{$slug}-{$last_id}", 'article');

                        if ($isUploaded) {
                            ImageManager::upload($file, 'posts-thumbs', "ngpictures-{$slug}-{$last_id}", 'medium');
                            $this->posts->update($last_id, ['thumb' => "ngpictures-{$slug}-{$last_id}.jpg"]);
                            $this->flash->set('success', $this->msg['form_post_submitted']);
                            $this->app::redirect("/posts");
                        } else {
                            $this->flash->set('danger', $this->msg['files_not_uploaded']);
                            $this->posts->delete($last_id);
                        }
                    } else {
                        $errors = new Collection($this->validator->getErrors());
                        $this->flash->set('danger', $this->msg['form_multi_errors']);
                    }
                } else {
                    $this->flash->set('danger', $this->msg['post_requires_picture']);
                }
            } else {
                $this->flash->set('danger', $this->msg['post_requires_picture']);
            }
        }

        $this->pageManager::setName("Publication");
        $this->viewRender("front_end/users/posts/add", compact('post', 'categories'));
    }


    public function edit($id, $token)
    {
        $this->callController("users")->restrict();
        $categories = $this->categories->orderBy('title', 'ASC');

        if ($token == $this->session->read(TOKEN_KEY)) {
            $post       =   new Collection($data ?? $_POST);
            $errors     =   new Collection();
            $article    =   $this->posts->find(intval($id));

            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('title', 'required');
                $this->validator->setRule('content', 'required');

                if ($this->validator->isValid()) {
                    $title          =   $this->str::escape($post->get('title'));
                    $content        =   $this->str::escape($post->get('content'));
                    $slug           =   $this->str::slugify($title);
                    $categories_id    =   intval($post->get('category')) ?? 1;

                    $this->posts->update($id, compact('title', 'content', 'slug', 'categories_id'));
                    $this->flash->set("success", $this->msg['post_edit_success']);
                    $this->app::redirect("/account/post");
                } else {
                    $errors = new Collection($this->validator->getErrors());
                    $this->flash->set('danger', $this->msg['form_multi_errors']);
                }
            }

            $this->pageManager::setName("Edition");
            $this->viewRender("front_end/users/posts/edit", compact('article', 'categories', 'post', 'errors'));
        }
    }


    /**
     * suppression des publications des users
     * @param string $token
     */
    public function delete($token)
    {
        $this->callController("users")->restrict();
        $model  =   $this->loadModel("posts");
        $post   =   new Collection($_POST);
        $post   =   $model->find(intval($post->get('id')));

        if ($this->session->read(TOKEN_KEY) == $token) {
            if ($post && $post->users_id == $this->session->getValue(AUTH_KEY, 'id')) {
                $model->delete($post->id);
                if ($this->isAjax()) {
                    exit();
                }
                $this->flash->set('success', $this->msg['post_delete_success']);
                $this->app::redirect(true);
            } else {
                if ($this->isAjax()) {
                    $this->ajaxFail($this->msg['undefined_error']);
                }
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
            }
        } else {
            if ($this->isAjax()) {
                $this->ajaxFail($this->msg['delete_not_allowed']);
            }
            $this->flash->set('danger', $this->msg['delete_not_allowed']);
            $this->app::redirect(true);
        }
    }
}
