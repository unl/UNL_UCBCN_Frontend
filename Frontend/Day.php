<?php

/**
 * This class contains the information needed for viewing a single day view calendar.
 * 
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */

require_once 'UNL/UCBCN/Frontend.php';
require_once 'UNL/UCBCN/Frontend/MonthWidget.php';
require_once 'UNL/UCBCN/EventListing.php';
require_once 'Calendar/Day.php';

class UNL_UCBCN_Frontend_Day extends UNL_UCBCN
{
    /** Calendar UNL_UCBCN_Calendar Object **/
    public $calendar;
    /** Year the user is viewing. */
    public $year;
    /** Month the user is viewing. */
    public $month;
    /** Day to show events for */
    public $day;
    /** Listing of events on this day. */
    public $output;
    /** URL of events on this day. */
    public $url;
    /** URL to the next day */
    public $next_url;
    /** URL to the previous day */
    public $prev_url;
    /** Display ongoing events? */
    public $ongoing = true;
    /** no events message */
    public $noevents = '<p class="noentry">Sorry, no new events were found for today!</p>';
    
    public function __construct($options)
    {
        parent::__construct($options);
        if (!isset($this->calendar)) {
            $this->calendar = UNL_UCBCN::factory('calendar');
            if (!$this->calendar->get(1)) {
                return new UNL_UCBCN_Error('No calendar specified or could be found.');
            }
        }
        $this->output[] = $this->showEventListing();
        if ($this->ongoing===true) {
            $this->output[] = $this->showOngoingEventListing();
        }
        $this->url = $this->getURL();
    }
    
    public function showEventListing()
    {
        $options = array('year'=>$this->year,
                         'month'=>$this->month,
                         'day'=>$this->day,
                         'calendar'=>$this->calendar);
        // Fetch the day evenlisting for this day.
        $eventlist = new UNL_UCBCN_EventListing('day',$options);
        
        if (count($eventlist->events)) {
            return $eventlist;
        } else {
            return $this->noevents;
        }
    }
    
    public function showOngoingEventListing()
    {
        $options = array('year'=>$this->year,
                         'month'=>$this->month,
                         'day'=>$this->day,
                         'calendar'=>$this->calendar);
        // Fetch the day evenlisting for this day.
        $eventlist = new UNL_UCBCN_EventListing('ongoing',$options);
        
        if (count($eventlist->events)) {
            return $eventlist;
        } else {
            return NULL;
        }
    }
    
    public function getURL()
    {
        return UNL_UCBCN_Frontend::formatURL(array('d'=>$this->day,
                                                   'm'=>$this->month,
                                                   'y'=>$this->year,
                                                   'calendar'=>$this->calendar->id));
    }
    
}

?>