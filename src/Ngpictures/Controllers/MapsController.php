<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ngpictures\Managers\PageManager;

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
        PageManager::setTitle('Localisation des photographes');
        PageManager::setDescription("Rétrouver les photographes locaux qui sont proche de vous");
        $this->view("frontend/maps/photographers", compact('markers'));
    }

    public function show()
    {
        $this->flash->set('info', $this->flash->msg['not_ready']);
        $this->redirect(true);
    }
}
