<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\CalendarManager;
use Psr\Container\ContainerInterface;



class BookingController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService->restrict();
        $this->loadModel('booking');
    }


    public function index()
    {
        if (isset($_GET['m'])) {
            $month = intval($_GET['m']);
            $year = intval($_GET['y']);
            $this->calendar = new CalendarManager(compact('month', 'year'));
        } else {
            $this->calendar = $this->container->get(CalendarManager::class);
        }

        $days = $this->calendar->days;
        $weeks = $this->calendar->getWeeks();
        $start = $this->calendar->getStratingDay();
        $start = $start->format('N') === '1' ? $start : $this->calendar->getStratingDay()->modify('last monday');

        $end = (clone $start)->modify('+' . (6 * 7 - ($weeks - 1)) . 'days');
        $calendar = $this->calendar;
        $current_month = $this->calendar->toString();
        $nextMonth = $this->calendar->nextMonth()->getMonth();
        $nextYear = $this->calendar->nextMonth()->getYear();
        $previousMonth = $this->calendar->previousMonth()->getMonth();
        $previousYear = $this->calendar->previousMonth()->getYear();

        $this->turbolinksLocation('/booking');
        $this->pageManager::setTitle('Réservation');
        $this->view('frontend/others/booking', compact(
            'current_month',
            'nextMonth',
            'nextYear',
            'previousMonth',
            'previousYear',
            'calendar',
            'events',
            'start',
            'days',
            'weeks'
        ));
    }
}
