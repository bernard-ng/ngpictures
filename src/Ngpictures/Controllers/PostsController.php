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


    public function showPosts(string $name, int $id, string $token)
    {
        $this->callController("users")->restrict();
        if ($this->session->read(TOKEN_KEY) == $token) {
            $user = $this->loadModel('users')->find(intval($id));

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
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $categories = $this->categories->orderBy('title', 'ASC');

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('title')) && !empty($post->get('content')) && !empty($file->get('thumb.name'))) {
                $title = $this->str::escape($post->get('title'));
                $content = $this->str::escape($post->get('content'));
                $slug = $this->str::slugify($title);
                $category_id = ($post->get('category') == 0) ? 1 : $post->get('category');
                $user_id = (int) $this->session->getValue(AUTH_KEY, 'id');

                if (isset($_FILES) && !empty($_FILES)) {
                    if (!empty($file->get('thumb.name'))) {
                        if ($this->validator->isValid()) {
                            $this->posts->create(compact('user_id', 'title', 'content', 'slug', 'category_id'));

                            $last_id = $this->posts->lastInsertId();
                            $isUploaded = ImageManager::upload($file, 'posts', "ngpictures-{$slug}-{$last_id}", 'article');

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
                            var_dump($this->validator->getErrors());
                        }
                    } else {
                        $this->flash->set('danger', $this->msg['post_requires_picture']);
                    }
                }
            } else {
                $this->flash->set('danger', $this->msg['form_all_required']);
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
            $post = new Collection($_POST);
            $article = $this->posts->find(intval($id));
            $post = new Collection($data ?? $_POST);
            $errors = [];

            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('title', 'required');
                $this->validator->setRule('content', 'required');

                if ($this->validator->isValid()) {
                    $title = $this->str::escape($post->get('title'));
                    $content = $this->str::escape($post->get('content'));
                    $slug = $this->str::slugify($title);
                    $category_id = (int) $post->get('category') ?? 1;

                    $this->posts->update($id, compact('title', 'content', 'slug', 'category_id'));
                    $this->flash->set("success", $this->msg['post_edit_success']);
                    $this->app::redirect("/account/post");
                } else {
                    $errors = $this->validator->getErrors();
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
        $model = $this->loadModel("posts");
        $post = new Collection($_POST);
        $post = $model->find(intval($post->get('id')));

        if ($this->session->read(TOKEN_KEY) == $token) {
            if ($post && $post->user_id == $this->session->getValue(AUTH_KEY, 'id')) {
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
