<?php
namespace Framework\Managers;

use \DateTime;
use \InvalidArgumentException;

/**
 * Class CalendarManager
 * @package Framework\Managers
 */
class CalendarManager
{
    public $days = [
        'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'
    ];

    private $months = [
        'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet',
        'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    ];

    private $month;
    private $year;

    /**
     * CalendarManager constructor.
     * @param array|null $param
     */
    public function __construct(array $param = null)
    {

        if ($param !== null) {
            $month = ($param['month'] == 0) ? intval(date('m')) : $param['month'];
            $year = ($param['year'] == 0) ? intval(date('Y')) : $param['year'];
        } else {
            $month = intval(date('m'));
            $year = intval(date('Y'));
        }

        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException("the month {$month} is not valide");
        }

        $this->month = $month;
        $this->year = $year;
    }


    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }


    /**
     * @return int
     */
    public function getWeeks() : int
    {
        $start = $this->getStratingDay();
        $end = (clone $start)->modify('+1 month -1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;

        if ($weeks < 0) {
            $weeks = intval($end->format('W'));
        }

        return $weeks;
    }


    /**
     * @return DateTime
     */
    public function getStratingDay() : DateTime
    {
        return new DateTime("{$this->year}-{$this->month}-01");
    }


    /**
     * @param DateTime $date
     * @return bool
     */
    public function withInMonth(DateTime $date) : bool
    {
        return $this->getStratingDay()->format('Y-m') === $date->format('Y-m');
    }


    /**
     * @return CalendarManager
     */
    public function nextMonth() : self
    {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12) {
            $month = 1;
            $year += 1;
        }
        return new self(compact('month', 'year'));
    }


    /**
     * @return CalendarManager
     */
    public function previousMonth() : self
    {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1) {
            $month = 12;
            $year -= 1;
        }
        return new self(compact('month', 'year'));
    }

    /**
     * Get the value of month
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Get the value of year
     */
    public function getYear()
    {
        return $this->year;
    }
}
