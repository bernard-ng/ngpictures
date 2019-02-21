<?php
namespace Application\Controllers;

use Framework\Managers\Collection;

class MapsController extends Controller
{


    /**
     * localisation des photographes
     *
     * @return void
     */
    public function photographers()
    {
        $photogaphers = (new Collection($this->loadModel('photographers')->all()))->asList(', ', "id");
        $markers = $this->loadModel('locations')->findList($photogaphers);
        $markers = (new Collection($markers))->asJson();

        if ($this->isAjax() && isset($_GET['option']) && !empty($_GET['option'])) {
            echo $markers;
            exit();
        }

        $this->turbolinksLocation("/maps/photographers");
        $this->pageManager::setTitle('Localisation des photographes');
        $this->pageManager::setDescription("Rétrouver les photographes locaux qui sont proche de vous");
        $this->view("frontend/maps/photographers", compact('markers'));
    }

    public function show()
    {
        $this->flash->set('info', $this->flash->msg['not_ready']);
        $this->redirect(true);
    }
}
