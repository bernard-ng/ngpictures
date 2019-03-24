<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Repositories\BookingRepository;
use Application\Repositories\UsersRepository;
use Application\Repositories\Validators\BookingValidator;
use Awurth\SlimValidation\Validator;
use Framework\Managers\Collection;
use Framework\Managers\Mailer\Mailer;
use Application\Managers\PageManager;
use Psr\Container\ContainerInterface;

/**
 * Class BookingController
 * @package Application\Controllers
 */
class BookingController extends Controller
{
    /**
     * @var BookingRepository
     */
    private $booking;

    /**
     * BookingController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->booking = $container->get(BookingRepository::class);
    }


    public function index()
    {
        if ($this->request->is('post')) {
            $input = $this->request->input();
            $validator = $this->container->get(Validator::class);
            $validator->validate($input, BookingValidator::getValidationRules());

            if ($validator->isValid()) {
                $name = $input->get('name');
                $email = $input->get('email');
                $booking_date = $input->get('date');
                $booking_time = $input->get('time');
                $description = $input->get('description');
                $created_at = date('Y-M-d H:i:s');

                $this->booking->create(
                    compact('name', 'email', 'created_at', 'booking_date', 'booking_time', 'description')
                );
                $this->flash->set('success', 'form_booking_submitted');
                $this->redirect();
            } else {
                $errors = $validator->getErrors();
                $this->flash->set('danger', 'form_multi_errors');
            }
        }

        $this->turbolinksLocation($this->url('booking'));
        PageManager::setDescription("Envie de faire un shooting avec nous, pour vous ? faites vos réservations facilement");
        PageManager::setTitle('Réservation');
        $this->view('frontend/others/booking', compact('errors', 'input'));
    }
}
