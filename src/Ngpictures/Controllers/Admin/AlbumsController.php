<?php
namespace Ngpictures\Controllers\Admin;


use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Traits\Controllers\PaginationTrait;

class AlbumsController extends AdminController
{
    use PaginationTrait;

    /**
     * list les differents albums
     * un album poura contenir des photo de n'importe quel categorie
     */
    public function index()
    {
        $albums         = $this->albums->orderBy('id', 'DESC', 0, 10);
        $total          = $this->albums->countAll()->num;

        $pagination     = $this->setPagination($total, "albums");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $albums         = $pagination['result'] ?? $albums;

        $this->pageManager::setName('admin gallery.album');
        $this->view(
            'backend/gallery/albums',
            compact('albums', "currentPage", 'totalPage', 'prevPage', 'nextPage', 'total')
        );
    }



    /**
     * ajout d'un nouvelle album
     */
    public function add()
    {
        $post   = new Collection($_POST);
        $errors = new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('title', 'required');
            $this->validator->setRule('description', 'required');

            if ($this->validator->isValid()) {
                $title          =   $this->str->escape($post->get('title'));
                $slug           =   $this->str->slugify($title);
                $description    =   $post->get('description');

                $this->albums->create(compact('title', 'description', 'slug'));
                $this->flash->set('success', $this->flash->msg['form_post_submitted'], false);
                $this->redirect(ADMIN . "/gallery/albums", false);
            } else {
                $this->sendFormError();
            }
        }

        $this->pageManager::setName('admin album.add');
        $this->view('backend/gallery/albums.add', compact('post', 'errors'));
    }



    /**
     * edition d'information d'un album
     * @param int $id
     */
    public function edit($id)
    {
        $post       = new Collection($_POST);
        $album      = $this->albums->find(intval($id));
        $errors     = new Collection();

        if ($album) {
            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('title', 'required');
                $this->validator->setRule('description', 'required');

                if ($this->validator->isValid()) {
                    $title          =   $this->str->escape($post->get('title')) ?? $album->title;
                    $slug           =   $this->str->slugify($title);
                    $description    =   $post->get('description') ?? $album->description;

                    $this->albums->update($album->id, compact('title', 'description', 'slug'));
                    $this->flash->set('success', $this->flash->msg['post_edit_success']);
                    $this->redirect(ADMIN . "/gallery/albums");
                } else {
                    $this->sendFormError();
                }
            }

            $this->pageManager::setName('admin album.edit');
            $this->view('backend/gallery/albums.edit', compact('post', 'album', 'errors'));
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }
    }
}