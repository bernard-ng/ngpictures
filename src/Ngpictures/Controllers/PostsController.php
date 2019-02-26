<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ngpictures\Managers\PageManager;
use Ngpictures\Models\CategoriesModel;
use Ngpictures\Models\CommentsModel;
use Ngpictures\Models\PostsModel;
use Ngpictures\Models\UsersModel;
use Ngpictures\Services\Notification\NotificationService;
use Psr\Container\ContainerInterface;

/**
 * Class PostsController
 * @package Ngpictures\Controllers
 */
class PostsController extends Controller
{

    public $table = "posts";

    /**
     * @var mixed|CategoriesModel
     */
    protected $categories;

    /**
     * @var mixed|PostsModel
     */
    protected $posts;

    /**
     * PostsController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->posts = $container->get(PostsModel::class);
        $this->categories = $container->get(CategoriesModel::class);
    }

    public function show(string $slug, $id)
    {
        if (!empty($slug) && !empty($id)) {
            $id = intval($id);
            $user = $this->container->get(UsersModel::class);
            $article = $this->posts->find($id);

            $comments = $this->container->get(CommentsModel::class);
            $commentsNumber = $comments->count($id, "posts_id")->num;
            $comments = $comments->get($id, "posts_id", 0, 4);
            $categories = $this->categories->orderBy('title', 'ASC', 0, 5);

            if ($article && $article->slug === $slug) {
                if ($article->online == 1) {
                    $similars = $this->loadModel($this->table)->findSimilars($article->id);
                    $author = $this->loadModel('users')->find($article->users_id);
                    $altName = "ngpictures-photo ($article->id) ";

                    $this->turbolinksLocation("/posts/{$slug}-{$id}");
                    PageManager::setTitle($article->title ?? $altName);
                    PageManager::setDescription($article->snipet);
                    PageManager::setImage($article->smallThumbUrl);

                    $this->view(
                        "frontend/posts/show",
                        compact("article", "comments", "commentsNumber", "user", "categories", "author", "similars")
                    );
                } else {
                    $this->flash->set("warning", $this->flash->msg['post_private'], false);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set("danger", $this->flash->msg['post_not_found'], false);
                http_response_code(404);
                $this->redirect(true);
            }
        } else {
            $this->flash->set("danger", $this->flash->msg['undefined_error'], false);
            $this->index();
        }
    }

    public function index()
    {
        $posts = $this->posts->latest(0, 8);
        $this->turbolinksLocation("/posts");
        PageManager::setTitle("Fil d'actualité");
        PageManager::setDescription("
            Découvez les photos et les articles des passionnés de la photographie, partager vos photos avec la
            communauté.
        ");
        $this->view("frontend/posts/index", compact("posts"));
    }

    /**
     * affiches les publication d'un user
     *
     * @param string $token
     * @return void
     */
    public function showPosts(string $token)
    {
        $this->authService->restrict();
        if ($this->authService->getToken() == $token) {
            $user = $this->authService->isLogged();

            if ($user) {
                $posts = $this->posts->findWithUser($user->id);

                $this->turbolinksLocation("/my-posts");
                PageManager::setTitle("Mes publications");
                $this->view("frontend/posts/users", compact('posts', 'user'));
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
        $this->authService->restrict();
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $errors = new Collection();
        $notifier = $this->container->get(NotificationService::class);
        $categories = $this->categories->orderBy('title', 'ASC');

        if (isset($_POST) && !empty($_POST)) {
            $title = $this->str->escape($post->get('title'));
            $content = $this->str->escape($post->get('content'));
            $slug = $this->str->slugify(empty($title) ? "publication" : $title);
            $categories_id = (intval($post->get('category')) == 0) ? 1 : intval($post->get('category'));
            $users_id = $this->authService->isLogged()->id;

            if (isset($_FILES) && !empty($_FILES)) {
                if (!empty($file->get('thumb.name'))) {
                    if ($this->validator->isValid()) {
                        $this->posts->create(compact('users_id', 'title', 'content', 'slug', 'categories_id'));

                        $last_id = $this->posts->lastInsertId();
                        if ($last_id) {
                            $isUploaded = $this
                                ->container
                                ->get(ImageManager::class)
                                ->upload($file, 'posts', "ngpictures-{$slug}-{$last_id}", 'article');

                            if ($isUploaded) {
                                $this
                                    ->container
                                    ->get(ImageManager::class)
                                    ->upload($file, 'posts-thumbs', "ngpictures-{$slug}-{$last_id}", 'medium');

                                $exif = $this->container->get(ImageManager::class)->getExif($file);
                                $color = $this->container->get(ImageManager::class)->getColor($file);
                                $this->posts->update(
                                    $last_id,
                                    [
                                        'thumb' => "ngpictures-{$slug}-{$last_id}.jpg",
                                        'exif' => $exif,
                                        'color' => $color,
                                    ]
                                );

                                $notifier->notify(1, [$this->posts->find($last_id)]);
                                $this->flash->set('success', $this->flash->msg['form_post_submitted'], false);
                                $this->redirect("/posts", true);
                            } else {
                                $this->posts->delete($last_id);
                                $this->flash->set('danger', $this->flash->msg['files_not_uploaded'], false);
                            }
                        } else {
                            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
                            $this->redirect(true, false);
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
        PageManager::setTitle("Publication");
        $this->view("frontend/posts/add", compact('post', 'categories', 'errors'));
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
        $this->authService->restrict();
        $categories = $this->categories->orderBy('title', 'ASC');

        if ($token == $this->authService->getToken()) {
            $publication = $this->posts->find(intval($id));
            if ($publication) {
                $post = new Collection($data ?? $_POST);

                if (isset($_POST) && !empty($_POST)) {
                    $title = $this->str->escape($post->get('title'));
                    $content = $this->str->escape($post->get('content'));
                    $slug = empty($post->get('title')) ? 'publication' : $this->str->slugify($title);
                    $categories_id = (intval($post->get('category')) == 0) ? 1 : intval($post->get('category'));

                    $this->posts->update($id, compact('title', 'content', 'slug', 'categories_id'));
                    $this->flash->set("success", $this->flash->msg['post_edit_success'], false);
                    $this->redirect("/posts", true);
                }

                PageManager::setTitle("Edition");
                PageManager::setDescription("Editer vos publications, rajouter du contenu ou faites une mise à jour");
                $this->turbolinksLocation("/my-posts/edit/{$id}/{$token}");
                $this->view("frontend/posts/edit", compact('publication', 'categories', 'post'));
            } else {
                $this->flash->set("danger", $this->flash->msg['post_not_found'], false);
            }
        }
    }


    /**
     * suppression des publications des users
     * @param string $token
     */
    public function delete($id, $token)
    {
        $this->authService->restrict();
        $data = new Collection($_POST);
        $post = $this->posts->find(intval($id));

        if ($this->authService->getToken() == $token) {
            if ($post && ($post->users_id == $this->authService->isLogged()->id)) {
                if (isset($_POST) && !empty($_POST)) {
                    $this->posts->delete($post->id);
                    $this->flash->set('success', $this->flash->msg['post_delete_success'], false);
                    $this->redirect("/posts");
                }

                PageManager::setTitle("Supprimer une publication");
                PageManager::setDescription("suppresion d'une publication");
                $this->turbolinksLocation("/my-posts/delete/{$id}/{$token}");
                $this->view("frontend/posts/delete", compact('post'));
            } else {
                $this->flash->set('danger', $this->flash->msg['delete_not_allowed'], false);
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['delete_not_allowed'], false);
            $this->redirect(true, false);
        }
    }
}
