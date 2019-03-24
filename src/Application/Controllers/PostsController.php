<?php
namespace Application\Controllers;

use Framework\Managers\Collection;
use Framework\Managers\ImageManager;
use Application\Managers\PageManager;
use Application\Repositories\CategoriesRepository;
use Application\Repositories\CommentsRepository;
use Application\Repositories\PostsRepository;
use Application\Repositories\UsersRepository;
use Psr\Container\ContainerInterface;

/**
 * Class PostsController
 * @package Application\Controllers
 */
class PostsController extends Controller
{
    /**
     * @var mixed|CategoriesRepository
     */
    private $categories;

    /**
     * @var mixed|PostsRepository
     */
    private $posts;

    /**
     * PostsController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->posts = $container->get(PostsRepository::class);
    }

    public function index()
    {
        /** @var PostsEntity[] $posts */
        $posts = $this->posts->getLast(8);
        $this->turbolinksLocation($this->url('posts'));

        PageManager::setTitle("Galerie");
        PageManager::setDescription("
            Découvez les photos des passionnés de la photographie, partager vos photos avec la
            communauté.
        ");
        PageManager::setImage($posts[0]->getSmallThumb());
        $this->view("frontend/posts/index", compact("posts"));
    }

    public function slider()
    {
        if (isset($_GET['last']) && !empty($_GET['last'])) {
            $lastId = intval($_GET['last']);

            if ($this->posts->find(intval($lastId))) {
                $posts = $this->posts->findLess($lastId, 8);
                $last = $posts == null ? 1 : end($posts)->id;

                PageManager::setTitle('Diaporama');
                PageManager::setDescription("Voir les photos de la galerie, en diaporama");
                $this->view('frontend/posts/slider', compact('posts', 'last'));
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect($this->url("posts"));
            }
        } else {
            $posts = $this->posts->getLast();
            $last =  $posts == null ? 1 : end($posts)->id;
            PageManager::setTitle('Diaporama');
            PageManager::setDescription("Voir les photos de la galerie, en diaporama");
            $this->view('frontend/posts/slider', compact('posts', 'last'));
        }
    }

    /**
     * @param string $slug
     * @param $id
     */
    public function show(string $slug, $id)
    {
        $id = intval($id);
        $post = $this->posts->find($id);
        if ($post && $post->slug == $slug) {
            $comments = $this->container->get(CommentsRepository::class);
            $commentsCount = $comments->count($id);
            $comments = $comments->get($id);
            $similar = $this->container->get(PostsRepository::class)->findWithSameCategory($post->categoriesId, $post->id);
            $author = $this->container->get(UsersRepository::class)->find($post->usersId);

            $this->turbolinksLocation($this->url("posts.show", compact('id', 'slug')));
            PageManager::setTitle($post->name . " Photo #{$post->id}");
            PageManager::setDescription($post->description);
            PageManager::setImage($post->getSmallThumb());

            $this->view(
                "frontend/posts/show",
                compact("post", "comments", "commentsCount", "user", "author", "similar")
            );
        } else {
            $this->notFound();
        }
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
                $this->redirect();
            }
        } else {
            $this->flash->set("danger", $this->flash->msg['undefined_error'], false);
            $this->redirect();
        }
    }


    /**
     * ajout d'une publication
     *
     * @return void
     */
    public function create()
    {
        $input = $this->request->input();
        $file = new Collection($_FILES);
        $notifier = null;
        $categories = null;

        if (isset($_POST) && !empty($_POST)) {
            $title = $this->str->escape($input->get('title'));
            $content = $this->str->escape($input->get('content'));
            $slug = $this->str->slugify(empty($title) ? "publication" : $title);
            $categories_id = (intval($input->get('category')) == 0) ? 1 : intval($input->get('category'));
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
                            $this->redirect();
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

        $this->turbolinksLocation($this->url('posts.create'));
        PageManager::setTitle("Upload");
        $this->view("frontend/posts/add", compact('input', 'categories', 'errors'));
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
        $data = $this->request->input();
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
                $this->redirect();
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['delete_not_allowed'], false);
            $this->redirect();
        }
    }
}
