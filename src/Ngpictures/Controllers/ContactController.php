<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\Mailer\Mailer;
use PHPMailer\PHPMailer\Exception;

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
                $email      = $this->str::escape($post->get('email'));
                $name       = $this->str::escape($post->get('name'));
                $message    = $this->str::escape($post->get('message'));

                (new Mailer())->contact($name, $email, $message);
                $this->flash->set('success', $this->msg['form_contact_submitted']);
            } else {
                $errors = new Collection($this->validator->getErrors());
                $this->flash->set("danger", $this->msg['form_multi_errors']);
            }
        }

        $this->app::turbolinksLocation("/contact");
        $this->pageManager::setName("Contact");
        $this->setLayout("posts/default");
        $this->viewRender("frontend/others/contact", compact("post", "errors"));
    }
}
