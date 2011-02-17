<?php
require_once 'UNL/UCBCN/Frontend.php';
require_once 'UNL/UCBCN/Frontend/Day.php';
require_once 'Calendar/Calendar.php';
require_once 'Calendar/Month/Weekdays.php';
require_once 'Calendar/Util/Textual.php';

class UNL_UCBCN_Frontend_FullCal extends UNL_UCBCN
{
    public $events = array();

    function __construct($calendar, $dsn) 
    {
        $start = date('U');
        $end   = date('U');
        
        if (isset($_GET['start'])) {
            $start = (int)$_GET['start'];
        }
        
        if (isset($_GET['end'])) {
            $end = (int)$_GET['end'];
        }
        
        $day   = date('d', $start);
        $month = (int)date('m', $start);
        $year  = date('Y', $start);
        $diff  = ($end - $start)/3600;

        switch($diff) {
            case 24:
                $type = "day";
                break;
            case 168:
                $type = "week";
                break;
            default:
                $type = "month";
                break;
        }

        switch($type) {
            case 'month':
                //recalculate the startdate.  WARNING: UGLY HACK
                $month = (int)date('m', $start+604800);  //Works because 7 days + whatever will always be in the correct month
                
                $monthList = new UNL_UCBCN_Frontend_Month($year,$month,$calendar,$dsn);
                foreach ($monthList->weeks as $week) {
                    foreach ($week as $day) {
                        if (isset($day->output[0]->events)) {
                            foreach ($day->output[0]->events as $event) {
                                $this->events[] = $event;
                            }
                        }
                    }
                }
                break;
                
            case 'day':
                $dayList = new UNL_UCBCN_EventListing('day', array('calendar' => $calendar, 'dsn' => $dsn, 'month' => $month, 'day' => $day, 'year' => $year));
                foreach ($dayList->events as $event) {
                    $this->events[] = $event;
                }
                break;
                
            case 'week':
                $weekList = new UNL_UCBCN_Frontend_Week(array('calendar' => $calendar, 'dsn' => $dsn, 'month' => $month, 'day' => $day, 'year' => $year));
                foreach ($weekList->output as $day) {
                    if (isset($day->output[0]->events)) {
                        foreach ($day->output[0]->events as $event) {
                            $this->events[] = $event;
                        }
                    }
                }
                break;
        }
    }
}