<?php
namespace Ngpictures\Controllers;

use Psr\Container\ContainerInterface;

class GalleryController extends Controller
{

    /**
     * @inheritDoc
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->loadModel('gallery');
    }


    /**
     * page par default
     *
     * @return void
     */
    public function index()
    {
        $photo = $this->gallery->random(4);
        $photos = $this->gallery->lastOnline();

        $this->turbolinksLocation("/gallery");
        $this->pageManager::setTitle('Galerie');
        $this->view('frontend/gallery/index', compact('photo', 'photos'));
    }


    /**
     * affiche un article
     *
     * @param integer $id
     * @return void
     */
    public function show($slug, $id)
    {
        $article = $this->gallery->find(intval($id));

        if (!empty($id)) {
            $this->loadModel('users');
            $this->loadModel('gallery');


            $user = $this->users;
            $article = $this->loadModel("gallery")->find(intval($id));

            $comments = $this->loadModel('comments');
            $commentsNumber = $comments->count($id, "gallery_id")->num;
            $comments = $comments->get($id, "gallery_id", 0, 4);
            $categories = $this->loadModel('categories')->orderBy('title', 'ASC', 0, 5);


            if ($article) {
                if ($article->online == 1) {
                    $similars = $this->gallery->findSimilars($article->id);
                    $author = $this->users->find($article->users_id);
                    $altName = " gallery - publication - " . $article->id;


                    $this->pageManager::setTitle($article->name ?? $altName);
                    $this->turbolinksLocation("/gallery/{$article->slug}-{$id}");
                    $this->view(
                        "frontend/gallery/show",
                        compact("article", "comments", "commentsNumber", "user", "categories", "author", "similars")
                    );
                } else {
                    $this->flash->set("warning", $this->flash->msg['post_private'], false);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set("danger", $this->flash->msg['post_not_found'], false);
                $this->redirect(true);
            }
        } else {
            $this->flash->set("danger", $this->flash->msg['undefined_error'], false);
            $this->index();
        }
    }


    /**
     * affiche les albums
     *
     * @return void
     */
    public function albums()
    {
        $albums = $this->loadModel('albums')->all();
        $thumbs = [];
        $nb     = [];

        foreach ($albums as $album) {
            $thumbs[$album->id] =
                $this->gallery->findWith('albums_id', $album->id, true)->smallThumbUrl ??
                '/imgs/default.jpeg';
        }

        foreach ($albums as $album) {
            $nb[$album->id] =
                count($this->gallery->findWith('albums_id', $album->id, false));
        }

        $this->turbolinksLocation("/gallery/albums");
        $this->pageManager::setTitle('albums');
        $this->view('frontend/gallery/albums', compact("albums", "thumbs", "nb"));
    }


    public function album_show($slug, $id)
    {
        $album = $this->loadModel('albums')->find(intval($id));
        if ($album && $album->slug == $slug) {
            $author = $this->loadModel('users')->find($album->photographers_id);
            $gallery = $this->loadModel('gallery')->findWith('albums_id', $album->id, false);
            $posts  = $this->loadModel('posts')->findWith('albums_id', $album->id, false);

            $this->pageManager::setTitle("{$album->title}");
            $this->pageManager::setDescription("Toutes les photos de l'album : {$album->title}, {$album->description}");
            $this->turbolinksLocation("/gallery/albums/{$slug}-{$id}");
            $this->view("frontend/gallery/album_show", compact("album", "author", "gallery", "posts"));
        } else {
            $this->flash->set('danger', "Cet album n'existe pas ou plus");
            $this->redirect(true);
        }
    }


    /**
     * affiche en slider
     *
     * @return void
     */
    public function slider()
    {
        if (isset($_GET['last_id']) && !empty($_GET['last_id'])) {
            $lastId = $this->str->escape($_GET['last_id']);

            if ($this->gallery->find(intval($lastId))) {
                $photos = $this->gallery->findGreater($lastId, 4);
                $last_id = $photos == null ? 1 : end($photos)->id;

                $this->pageManager::setTitle('Diaporama');
                $this->pageManager::setDescription("Voir les photos de la galerie, en diaporama");
                $this->view('frontend/gallery/slider', compact('photos', 'last_id'));
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect('/gallery');
            }
        } else {
            $photos = $this->gallery->latest();
            $last_id =  $photos == null ? 1 : end($photos)->id;
            $this->pageManager::setTitle('Diaporama');
            $this->pageManager::setDescription("Voir les photos de la galerie, en diaporama");
            $this->view('frontend/gallery/slider', compact('photos', 'last_id'));
        }
    }
}
