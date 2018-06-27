<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\Mailer\Mailer;
use PHPMailer\PHPMailer\Exception;
use Ng\Core\Managers\ValidationManager;

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
                $name       = $this->str::escape($post->get('name'));
                $email      = $this->str::escape($post->get('email'));
                $message    = $this->str::escape($post->get('message'));

                $this->contaiener->get(Mailer::class)->contact($name, $email, $message);
                $this->flash->set('success', $this->flash->msg['form_contact_submitted']);
            } else {
                $errors = new Collection($this->validator->getErrors());
                $this->flash->set("danger", $this->flash->msg['form_multi_errors']);
            }
        }

        $this->turbolinksLocation("/contact");
        $this->pageManager::setName("Contact");
        $this->viewRender("frontend/others/contact", compact("post", "errors"));
    }
}
