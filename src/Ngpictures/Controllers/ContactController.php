<?php
namespace Application\Controllers;

use Framework\Managers\Collection;
use Framework\Managers\Mailer\Mailer;

class ContactController extends Controller
{
    public function index()
    {
        $post = new Collection($_POST);
        $errors = new Collection();

        if (!empty($_POST) && isset($_POST)) {
            $this->validator->setRule('name', 'required');
            $this->validator->setRule('email', 'valid_email');
            $this->validator->setRule('message', 'required');

            if ($this->validator->isValid()) {
                $name       = $this->str->escape($post->get('name'));
                $email      = $this->str->escape($post->get('email'));
                $message    = $this->str->escape($post->get('message'));

                $this->container->get(Mailer::class)->contact($name, $email, $message);
                $this->flash->set('success', $this->flash->msg['form_contact_submitted'], false);
                $this->redirect("/");
            } else {
                $this->sendFormError();
            }
        }

        $this->turbolinksLocation("/contact");
        $this->pageManager::setTitle("Contact");
        $this->view("frontend/others/contact", compact("post", "errors"));
    }
}
