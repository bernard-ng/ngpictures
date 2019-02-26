<?php
namespace Application\Controllers;

use Framework\Managers\Collection;
use Application\Managers\PageManager;
use Application\Traits\Util\TypesActionTrait;

class ReportsController extends Controller
{

    use TypesActionTrait;

    public function index($type, $slug, $id)
    {
        $id = intval($id);
        $type = intval($type);
        $model = $this->loadModel($this->getAction(intval($type)));
        $post = $model->find(intval($id));

        if ($post) {
            if (isset($_POST) && !empty($_POST)) {
                $data = new Collection($_POST);
                $this->validator->setRule('report', 'required');
                if ($this->validator->isValid()) {
                    $content = $this->str->escape($data->get('report'));
                    $publication_id = $id;

                    $this->loadModel('reports')->create(compact('content', 'type', 'publication_id'));
                    $this->flash->set('success', $this->flash->msg['form_report_submitted'], false);
                    $this->redirect("/" . $this->getAction($type));
                } else {
                    $this->sendFormError();
                }
            }

            PageManager::setTitle('Signaler une publication');
            PageManager::setDescription("Veuillez nous dire ce qui ne va pas avec cette publication");
            $this->turbolinksLocation("/report/{$type}/{$slug}-{$id}");
            $this->view('frontend/others/report', compact('post'));
        } else {
            $this->flash->set('danger', $this->flash->msg['post_not_found'], false);
            $this->redirect(true);
        }
    }
}
