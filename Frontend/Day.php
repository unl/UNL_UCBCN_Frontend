<?php
/**
 * This class contains the information needed for viewing a single day view calendar.
 * 
 * PHP version 5
 * 
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2007 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License 
 * @version   CVS: $id$
 * @link      http://pear.unl.edu/
 */

require_once 'UNL/UCBCN/Frontend.php';

/**
 * Month widget is used for navigation within the month this day resides
 */
require_once 'UNL/UCBCN/Frontend/MonthWidget.php';

/**
 * Event listings hold an array of events for this day.
 */
require_once 'UNL/UCBCN/EventListing.php';

/**
 * Calendar_Day is used for day manipulation and date verification.
 */
require_once 'Calendar/Day.php';

/**
 * Object for the view of a single day for a calendar.
 * 
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2007 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://pear.unl.edu/
 */
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
    
    /**
     * Constructor for an individual day.
     * 
     * @param array $options Associative array of options to apply.
     */
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
    
    /**
     * Shows the listing of new events for this day.
     * 
     * @return mixed UNL_UCBCN_EventListing or string for noevents.
     */
    public function showEventListing()
    {
        $options = array('year'=>$this->year,
                         'month'=>$this->month,
                         'day'=>$this->day,
                         'calendar'=>$this->calendar);
        // Fetch the day evenlisting for this day.
        $eventlist = new UNL_UCBCN_EventListing('day', $options);
        
        if (count($eventlist->events)) {
            return $eventlist;
        } else {
            return $this->noevents;
        }
    }
    
    /**
     * Returns the listing of ongoing events for this day.
     * 
     * @return object UNL_UCBCN_EventListing
     */
    public function showOngoingEventListing()
    {
        $options = array('year'=>$this->year,
                         'month'=>$this->month,
                         'day'=>$this->day,
                         'calendar'=>$this->calendar);
        // Fetch the day evenlisting for this day.
        $eventlist = new UNL_UCBCN_EventListing('ongoing', $options);
        
        if (count($eventlist->events)) {
            return $eventlist;
        } else {
            return null;
        }
    }
    
    /**
     * Returns the permanent URL to this specific day.
     * 
     * @return string URL to this day.
     * @access public
     */
    public function getURL()
    {
        return UNL_UCBCN_Frontend::formatURL(array('d'=>$this->day,
                                                   'm'=>$this->month,
                                                   'y'=>$this->year,
                                                   'calendar'=>$this->calendar->id));
    }
    
}

?>