<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Repositories\Validators\ContactValidator;
use Awurth\SlimValidation\Validator;
use Framework\Managers\Mailer\Mailer;
use Application\Managers\PageManager;

/**
 * Class ContactController
 * @package Application\Controllers
 */
class ContactController extends Controller
{
    public function index()
    {
        if ($this->request->is('post')) {
            $input = $this->request->input();
            $validator = $this->container->get(Validator::class);
            $validator->validate($input->toArray(), ContactValidator::getValidationRules());

            if ($validator->isValid()) {
                $name       = $input->get('name');
                $email      = $input->get('email');
                $message    = $input->get('message');

                $this->container->get(Mailer::class)->contact($name, $email, $message);
                $this->flash->success('form_contact_submitted');
                $this->redirect($this->url('home'));
            } else {
                $errors = $validator->getErrors();
                $this->flash->error('form_multi_errors');
            }
        }

        $this->turbolinksLocation($this->url('contact'));
        PageManager::setTitle("Contact");
        $this->view("frontend/others/contact", compact("input", "errors"));
    }
}
