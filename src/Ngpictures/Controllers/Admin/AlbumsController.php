<?php
namespace Ngpictures\Controllers\Admin;


use Ng\Core\Managers\Collection;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Managers\PageManager;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Controllers\PaginationTrait;

class AlbumsController extends AdminController
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('albums');
    }


    use PaginationTrait;

    /**
     * list les differents albums
     * un album poura contenir des photo de n'importe quel categorie
     */
    public function index()
    {
        $albums = $this->albums->all();
        $total          =   count($this->albums->all());

        $pagination     = $this->setPagination($total, "albums");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $albums         = $pagination['result'] ?? $albums;

        $this->pageManager::setName('admin gallery.album');
        $this->setLayout('admin/default');
        $this->viewRender(
            'back_end/gallery/albums',
            compact('albums', "currentPage", 'totalPage', 'prevPage', 'nextPage', 'total')
        );
    }



    /**
     * ajout d'un nouvelle album
     */
    public function add()
    {
        $post = new Collection($_POST);
        $errors = new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('title', 'required');
            $this->validator->setRule('description', 'required');

            if ($this->validator->isValid()) {
                $title          =   $this->str::escape($post->get('title'));
                $slug           =   $this->str::slugify($title);
                $description    =   $post->get('description');

                $this->albums->create(compact('title', 'description', 'slug'));
                $this->flash->set('success', $this->msg['form_post_submitted']);
                $this->app::redirect(ADMIN . "/gallery/albums");
            } else {
                $this->flash->set('danger', $this->msg['form_multi_errors']);
                $errors = new Collection($this->validator->getErrors());
            }
        }

        $this->pageManager::setName('admin album.add');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/gallery/albums.add', compact('post', 'errors'));
    }



    /**
     * edition d'information d'un album
     * @param int $id
     */
    public function edit($id)
    {
        $post = new Collection($_POST);
        $errors = new Collection();
        $album = $this->albums->find(intval($id));

        if ($album) {
            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('title', 'required');
                $this->validator->setRule('description', 'required');

                if ($this->validator->isValid()) {
                    $title          =   $this->str::escape($post->get('title')) ?? $album->title;
                    $slug           =   $this->str::slugify($title);
                    $description    =   $post->get('description') ?? $album->description;

                    $this->albums->update($album->id, compact('title', 'description', 'slug'));
                    $this->flash->set('success', $this->msg['post_edit_success']);
                    $this->app::redirect(ADMIN . "/gallery/albums");
                } else {
                    $this->flash->set('danger', $this->msg['form_multi_errors']);
                    $errors = new Collection($this->validator->getErrors());
                }
            }

            $this->pageManager::setName('admin album.edit');
            $this->setLayout('admin/default');
            $this->viewRender('back_end/gallery/albums.edit', compact('post', 'album', 'errors'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }
}