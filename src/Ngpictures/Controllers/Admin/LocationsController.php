<?php
namespace Application\Controllers\Admin;

use Framework\Managers\Collection;
use Psr\Container\ContainerInterface;
use Application\Controllers\AdminController;
use Application\Traits\Controllers\PaginationTrait;

class LocationsController extends AdminController
{
    use PaginationTrait;

    /**
     * list les differents Locations
     * un album poura contenir des photo de n'importe quel categorie
     */
    public function index()
    {
        $locations = $this->locations->orderBy('id', 'DESC', 0, 10);
        $total = $this->locations->countAll()->num;

        $pagination = $this->setPagination($total, "locations");
        $currentPage = $pagination['currentPage'];
        $totalPage = $pagination['totalPage'];
        $prevPage = $pagination['prevPage'];
        $nextPage = $pagination['nextPage'];
        $locations = $pagination['result'] ?? $locations;

        $this->pageManager::setTitle('admin location');
        $this->view(
            'backend/photographers/location',
            compact('locations', "currentPage", 'totalPage', 'prevPage', 'nextPage', 'total')
        );
    }


    /**
     * cree une  locationn
     *
     * @return void
     */
    public function add()
    {
        $post = new Collection($_POST);
        $errors = new Collection();
        $photographers = $this->photographers->all();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('name', 'required');
            $this->validator->setRule('address', 'required');
            $this->validator->setRule('lat', 'required');
            $this->validator->setRule('lng', 'required');
            $this->validator->setRule('type', 'required');
            $this->validator->setRule('photographer', 'required');

            if ($this->validator->isValid()) {
                $name               = $this->str->escape($post->get('name'));
                $address            = $this->str->escape($post->get('address'));
                $lat                = $this->str->escape($post->get('lat'));
                $lng                = $this->str->escape($post->get('lng'));
                $type               = $this->str->escape($post->get('type'));
                $photographers_id   = intval($post->get('photographer'));

                $this->locations->create(compact('name', 'address', 'lat', 'lng', 'type', 'photographers_id'), false);
                $this->flash->set('success', $this->flash->msg['success']);
                $this->redirect(ADMIN.'/locations');
            } else {
                $this->sendFormError();
            }
        }

        $this->pageManager::setTitle("admin location.add");
        $this->view(
            "backend/photographers/location.add",
            compact('post', 'errors', 'photographers')
        );
    }


    public function edit($id)
    {
        $location = $this->locations->find(intval($id));
        $photographers = $this->photographers->all();

        if ($location) {
            $post = new Collection($_POST);
            $errors = new Collection();

            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('name', 'required');
                $this->validator->setRule('address', 'required');
                $this->validator->setRule('lat', 'required');
                $this->validator->setRule('lng', 'required');
                $this->validator->setRule('type', 'required');

                if ($this->validator->isValid()) {
                    $lat                = $post->get('lat')?     $this->str->escape($post->get('lat'))     : $location->lat;
                    $lng                = $post->get('lng')?     $this->str->escape($post->get('lng'))     : $location->lng;
                    $name               = $post->get('name')?    $this->str->escape($post->get('name'))    : $location->name;
                    $type               = $post->get('type')?    $this->str->escape($post->get('type'))    : $location->type;
                    $address            = $post->get('address')? $this->str->escape($post->get('address')) : $location->address;

                    $this->locations->update($location->id, compact('name', 'address', 'lat', 'lng', 'type'));
                    $this->flash->set('success', $this->flash->msg['success']);
                    $this->redirect(ADMIN . '/locations');
                } else {
                    $this->sendFormError();
                }
            }

            $this->pageManager::setTitle("admin location.edit");
            $this->view(
                "backend/photographers/location.edit",
                compact('post', 'errors', 'location', 'photographers')
            );
        } else {
            $this->flash->set('danger', $this->flash->msg['post_not_found']);
            $this->redirect(true);
        }
    }
}
