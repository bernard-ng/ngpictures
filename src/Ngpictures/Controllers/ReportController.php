<?php
namespace  Ngpictures\Controllers;

use Ngpictures\Traits\Util\TypesActionTrait;



class ReportController extends Controller
{

    use TypesActionTrait;

    public function index($type, $slug, $id)
    {
        $model = $this->loadModel($this->getAction(intval($type)));
        $post = $model->find(intval($id));
        if ($post) {
            if (isset($_POST) && !empty($_POST)) {
                $data = new Collection($_POST);
                $this->validator->setRule('report', 'require');
                if ($this->validator->isValid()) {
                    $report = $this->str->escape($data->get('report'));
                    $this->loadModel('report')->create(compact('report', 'type', 'id'));
                    $this->flash->set('danger', $this->flash->msg['form_report_submitted'], false);
                    redirect(true, true);
                } else {
                    $this->sendFormError();
                }
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['post_not_found'], false);
            redirect(true);
        }
    }
}
