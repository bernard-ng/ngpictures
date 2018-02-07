<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ngpictures\Traits\Controllers\ShowPostTrait;
use Ngpictures\Traits\Controllers\StoryPostTrait;

class ArticlesController extends Controller
{
    public $table = "articles";

    use StoryPostTrait;
    use ShowPostTrait;


    public function showPosts()
    {
        $this->callController("users")->restrict();
        $user_id = $this->session->getValue(AUTH_KEY, "id");
        $articles = $this->loadModel('articles')->findWith('user_id', $user_id, false);

        $this->pageManager::setName("Mes publications");
        $this->setLayout("articles/default");
        $this->viewRender("front_end/users/posts/posts", compact('articles'));
    }


    public function add()
    {
        $this->callController("users")->restrict();
        $this->loadModel('articles');
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $categories = $this->loadModel('categories')->orderBy('title', 'ASC');

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
                            $this->articles->create(compact('user_id', 'title', 'content', 'slug', 'category_id'));

                            $last_id = $this->articles->lastInsertId();
                            $isUploaded = Image::upload($file, 'posts', "ngpictures-{$slug}-{$last_id}", 'article');

                            if ($isUploaded) {
                                Image::upload($file, 'posts-thumbs', "ngpictures-{$slug}-{$last_id}", 'medium');
                                $this->articles->update($last_id, ['thumb' => "ngpictures-{$slug}-{$last_id}.jpg"]);
                                $this->flash->set('success', $this->msg['admin_post_success']);
                                $this->app::redirect("/account/post");
                            } else {
                                $this->flash->set('danger', $this->msg['admin_file_notUploaded']);
                                $this->articles->delete($last_id);
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

        $this->pageManager::setName("Publier un article");
        $this->viewRender("front_end/users/posts/add", compact('post', 'categories'));
    }


    public function edit($slug, $id, $token)
    {
        $this->callController("users")->restrict();
        $categories = $this->loadModel('categories')->orderBy('title', 'ASC');

        if ($token == $this->session->read(TOKEN_KEY)) {
            $post = new Collection($_POST);
            $article = $this->articles->find(intval($id));
            $post = new Collection($data ?? $_POST);

            if (isset($_POST) && !empty($_POST)) {
                if (!empty($post->get('content')) && !empty($post->get('title'))) {
                    $this->validator->isEmpty('title', $this->msg['admin_all_fields']);
                    $this->validator->isEmpty('content', $this->msg['admin_all_fields']);

                    if ($this->validator->isValid()) {
                        $title = $this->str::escape($post->get('title'));
                        $content = $this->str::escape($post->get('content'));
                        $slug = $this->str::slugify($title);
                        $category_id = (int) $post->get('category') ?? 1;

                        $this->articles->update($id, compact('title', 'content', 'slug', 'category_id'));
                        $this->flash->set("success", $this->msg['admin_modified_success']);
                        $this->app::redirect("/account/post");
                    } else {
                        var_dump($this->validator->getErrors());
                    }
                } else {
                    $this->flash->set('danger', $this->msg['admin_all_fields']);
                }
            }

            $this->pageManager::setName("Publier un article");
            $this->viewRender("front_end/users/posts/edit", compact('post', 'categories'));
        }
    }


    /**
     * suppression des publications des users
     * @param int $id
     * @param string $token
     */
    public function delete($id, $token)
    {
        $this->callController("users")->restrict();
        $model = $this->loadModel("articles");
        $post = $model->find(intval($id));

        if ($this->session->read(TOKEN_KEY) == $token) {
            if ($post && $post->user_id == $this->session->getValue(AUTH_KEY, 'id')) {
                $model->delete($post->id);
                if ($this->isAjax()) {
                    exit();
                }
                $this->flash->set('success', $this->msg['admin_delete_success']);
                $this->app::redirect(true);
            } else {
                if ($this->isAjax()) {
                    $this->ajaxFail($this->msg['indefined_error']);
                }
                $this->flash->set('danger', $this->msg['indefined_error']);
                $this->app::redirect(true);
            }
        } else {
            if ($this->isAjax()) {
                $this->ajaxFail($this->msg['admin_delete_notAllowed']);
            }
            $this->flash->set('danger', $this->msg['admin_delete_notAllowed']);
            $this->app::redirect(true);
        }
    }
}
