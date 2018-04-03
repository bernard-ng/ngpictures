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
            if ($this->session->read(AUTH_KEY)) {
                $this->validator->setRule('message', 'required');

                if ($this->validator->isValid()) {
                    $email = $this->session->getValue(AUTH_KEY, 'email');
                    $name = $this->session->getValue(AUTH_KEY, 'name');
                    $message = $this->str::escape($post->get('message'));

                    try {
                        (new Mailer())->contact($name, $email, $message);
                    } catch (Exception $e) {
                        $this->flash->set("danger", $this->msg['undefined_error']);
                    }
                } else {
                    $errors = new Collection($this->validator->getErrors());
                }
            } else {
                $this->validator->setRule('email', 'valid_email');
                $this->validator->setRule('name', 'required');
                $this->validator->setRule('message', 'required');

                if ($this->validator->isValid()) {
                    $email = $this->str::escape($post->get('email'));
                    $name = $this->str::escape($post->get('name'));
                    $message = $this->str::escape($post->get('message'));

                    try {
                        (new Mailer())->contact($name, $email, $message);
                    } catch (Exception $e) {
                        $this->flash->set("danger", $this->msg['undefined_error']);
                    }
                } else {
                    $errors = new Collection($this->validator->getErrors());
                    $this->flash->set("danger", $this->msg['form_multi_errors']);
                }
            }
        }

        $this->pageManager::setName("Contact");
        $this->setLayout("posts/default");
        $this->viewRender("front_end/others/contact", compact("post", "errors"));
    }
}
