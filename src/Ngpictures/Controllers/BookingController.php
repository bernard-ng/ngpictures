<?php
namespace Application\Controllers;

use Framework\Managers\Collection;
use Framework\Managers\Mailer\Mailer;
use Framework\Managers\CalendarManager;
use Psr\Container\ContainerInterface;

class BookingController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->loadModel('booking');
    }


    public function index()
    {
        $this->calendar = $this->container->get(CalendarManager::class);
        $calendar = $this->calendar;
        $current_month = $this->calendar->toString();
        $photographers = $this->loadModel('photographers')->all();

        if (isset($_POST) && !empty($_POST)) {
            $post = new Collection($_POST);
            $errors = new Collection();

            $this->validator->setRule('name', 'required');
            $this->validator->setRule('email', 'valid_email');
            $this->validator->setRule('date', 'required');
            $this->validator->setRule('time', 'required');
            $this->validator->setRule('description', 'required');

            if ($this->validator->isValid()) {
                $name = $this->str->escape($post->get('name'));
                $email = $this->str->escape($post->get('email'));
                $date = $this->str->escape($post->get('date'));
                $time = $this->str->escape($post->get('time'));
                $description = $this->str->escape($post->get('description'));
                $photographers_id = empty($post->get('photographer')) ?  1 : intval($post->get('photographer'));

                $photographer = $this->loadModel('photographers')->find($photographers_id);
                if ($photographer) {
                    $this->booking->create(compact('name', 'email', 'date', 'time', 'description', 'photographers_id'), false);
                    $this->container->get(Mailer::class)->booking($photographer->id, $name, $email, $date, $time, $description);
                    $this->flash->set('success', $this->flash->msg['form_booking_submitted'], false);
                    $this->redirect("/");
                } else {
                    $this->flash->set('danger', $this->flash->msg['undefined_error']);
                }
            } else {
                $this->sendFormError('form_all_required');
            }
        }

        $this->turbolinksLocation('/booking');
        $this->pageManager::setDescription("Envie de faire un shooting avec nous, pour vous ? faites vos réservations facilement");
        $this->pageManager::setTitle('Réservation');
        $this->view('frontend/others/booking', compact('current_month', 'post', 'errors', 'photographers'));
    }
}
