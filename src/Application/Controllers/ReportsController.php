<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Repositories\PostsRepository;
use Framework\Managers\Collection;
use Application\Managers\PageManager;

/**
 * Class ReportsController
 * @package Application\Controllers
 */
class ReportsController extends Controller
{


    public function index($id)
    {
        $id = intval($id);
        $model = $this->container->get(PostsRepository::class);
        $post = $model->find(intval($id));

        if ($post) {
            if (isset($_POST) && !empty($_POST)) {
                $data = new Collection($_POST);
                $this->validator->setRule('report', 'required');
                if ($this->validator->isValid()) {
                    $content = $this->str->escape($data->get('report'));
                    $publication_id = $id;

                    $this->loadRepository('reports')->create(compact('content', 'type', 'publication_id'));
                    $this->flash->set('success', $this->flash->msg['form_report_submitted'], false);
                    $this->redirect();
                } else {
                    $this->sendFormError();
                }
            }

            PageManager::setTitle('Signaler une publication');
            PageManager::setDescription("Veuillez nous dire ce qui ne va pas avec cette publication");
            $this->turbolinksLocation("/report/{$id}");
            $this->view('frontend/others/report', compact('post'));
        } else {
            $this->flash->set('danger', $this->flash->msg['post_not_found'], false);
            $this->redirect(true);
        }
    }
}
