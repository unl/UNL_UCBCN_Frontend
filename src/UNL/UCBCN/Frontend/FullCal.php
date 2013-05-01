<?php
namespace UNL\UCBCN\Frontend;

class FullCal
{
    public $events = array();
    
    public $calendar;
    
    public $dsn;
    
    public $start;
    
    public $end;

    function __construct($calendar, $dsn, $start = null, $end = null) 
    {
        $this->setOptions(array('calendar'=>$calendar));
        $this->calendar = $calendar;
        $this->dsn      = $dsn;
        $this->start    = time();
        $this->end      = time();
        if (isset($start)) {
            $this->start = (int)$start;
        }
        
        if (isset($end)) {
            $this->end = (int)$end;
        }
    }

    function getCacheKey()
    {
        return md5('fullcal'.$this->calendar->id.$this->start.$this->end);
    }
    
    function run()
    {
        $day   = date('d', $this->start);
        $month = (int)date('m', $this->start);
        $year  = date('Y', $this->start);
        $diff  = ($this->end - $this->start)/3600;

        switch($diff) {
            case 168: // week
                $weekList = new UNL_UCBCN_Frontend_Week(array('calendar' => $this->calendar, 'dsn' => $this->dsn, 'month' => $month, 'day' => $day, 'year' => $year));
                foreach ($weekList->output as $day) {
                    if (isset($day->output[0]->events)) {
                        foreach ($day->output[0]->events as $event) {
                            $this->events[] = $event;
                        }
                    }
                }
                break;

            case 24: // day
                $dayList = new UNL_UCBCN_EventListing('day', array('calendar' => $this->calendar, 'dsn' => $this->dsn, 'month' => $month, 'day' => $day, 'year' => $year));
                foreach ($dayList->events as $event) {
                    $this->events[] = $event;
                }
                break;

            default:
                //recalculate the startdate.  WARNING: UGLY HACK
                $month = (int)date('m', $this->start+604800);  //Works because 7 days + whatever will always be in the correct month
                
                $monthList = new UNL_UCBCN_Frontend_Month($year,$month,$this->calendar,$this->dsn);
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
        }
    }
}