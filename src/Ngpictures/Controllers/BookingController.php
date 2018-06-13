<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;
use Ng\Core\Managers\CalendarManager;



class BookingController extends Controller
{
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
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
            $this->calendar = new CalendarManager();
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


        $this->setLayout('blank');
        $this->pageManager::setName('Réservation');
        $this->viewRender('frontend/others/booking', compact(
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
