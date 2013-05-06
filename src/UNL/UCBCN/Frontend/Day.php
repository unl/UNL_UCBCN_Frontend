<?php
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\Event\Occurrences;

use UNL\UCBCN\RuntimeException;

use \UNL\UCBCN\Calendar;

/**
 * This class contains the information needed for viewing a single day view calendar.
 * 
 * PHP version 5
 * 
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License 
 * @version   CVS: $id$
 * @link      http://code.google.com/p/unl-event-publisher/
 */

/**
 * Object for the view of a single day for a calendar.
 * 
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://code.google.com/p/unl-event-publisher/
 */
class Day extends Occurrences
{
    /**
     * Calendar \UNL\UCBCN\Calendar Object
     * 
     * @var \UNL\UCBCN\Calendar
     */
    public $calendar;
    
    /**
     * Year the user is viewing.
     * 
     * @var int
     */
    public $year;
    
    /**
     * Month the user is viewing.
     * 
     * @var int
     */
    public $month;
    
    /**
     * Day to show events for
     * 
     * @var int
     */
    public $day;
    
    /**
     * Listing of events on this day.
     * 
     * @var UNL_UCBCN_EventListing
     */
    public $output;
    
    /**
     * Display ongoing events?
     * 
     * @var bool
     */
    public $ongoing = true;
    
    /**
     * Events that are both recurring and ongoing.
     * 
     * @var array UNL_UCBCN_Event or UNL_UCBCN_EventInstance objects
     */
    public $ongoing_recurring = array();
    
    /**
     * no events message
     * 
     * @var string
     */
    public $noevents = 'Sorry, no new events were found for today!';
    
    /**
     * Constructor for an individual day.
     * 
     * @param array $options Associative array of options to apply.
     */
    public function __construct($options)
    {
        if (isset($options['calendar'])) {
            $this->calendar = $options['calendar'];
        }
        
        $this->output[] = $this->showEventListing($ongoing_recurring);
        if ($this->ongoing===true) {
            $this->output[] = $this->showOngoingEventListing($ongoing_recurring);
        }
    }
    
    /**
     * Shows the listing of new events for this day
     * 
     * @param $oarevents UNL_UCBCN_Event or UNL_UCBCN_EventInstance objects
     * 
     * @return mixed UNL_UCBCN_EventListing or string for noevents.
     */
    public function showEventListing(&$oarevents)
    {
        $options = array('year'=>$this->year,
                         'month'=>$this->month,
                         'day'=>$this->day,
                         'calendar'=>$this->calendar);
        // Fetch the day evenlisting for this day.
        $eventlist = new UNL_UCBCN_EventListing('day', $options, $oarevents);
        
        if (count($eventlist->events)) {
            return $eventlist;
        } else {
			include_once 'UNL/UCBCN/Frontend/NoEvents.php';
            return new UNL_UCBCN_Frontend_NoEvents($this->noevents);
        }
    }
    
    /**
     * Returns the listing of ongoing events for this day.
     * 
     * @return object UNL_UCBCN_EventListing
     */
    public function showOngoingEventListing(&$oarevents)
    {
        $options = array('year'=>$this->year,
                         'month'=>$this->month,
                         'day'=>$this->day,
                         'calendar'=>$this->calendar);
        // Fetch the day evenlisting for this day.
        $eventlist = new UNL_UCBCN_EventListing('ongoing', $options, $oarevents);
        
        if (count($eventlist->events)) {
            return $eventlist;
        } else {
            return null;
        }
    }
    
    /**
     * Returns the permalink URL to this specific day.
     * 
     * @return string URL to this day.
     */
    public function getURL()
    {
        $url = Controller::$url;
        if (isset($this->calendar)) {
            $url .= $this->calendar->shortname . '/';
        }
        return $url . $this->year. '/' . $this->month .'/' . $this->day;
    }
    
}
