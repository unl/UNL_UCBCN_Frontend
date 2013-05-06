<?php
/**
 * This class contains the information needed for viewing the list of upcoming
 * events within the calendar system.
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
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\EventListing;

/**
 * A list of upcoming events for a calendar.
 * 
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License 
 * @link      http://code.google.com/p/unl-event-publisher/
 */
class Upcoming extends EventListing
{
    /**
     * Calendar \UNL\UCBCN\Calendar Object
     * 
     * @var \UNL\UCBCN\Calendar
     */
    public $calendar;

    public $options = array(
            'limit'  => 10,
            'offset' => 0,
            );
    
    /**
     * Constructs an upcoming event view for this calendar.
     * 
     * @param array $options Associative array of options.
     */
    public function __construct($options = array())
    {
        if (isset($options['calendar'])) {
            $this->calendar = $options['calendar'];
        }

        // Set defaults
        $this->options['m'] = date('m');
        $this->options['d'] = date('d');
        $this->options['y'] = date('Y');

        parent::__construct($options = array());
    }

    /**
     * Get the date and time for this day
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return new \DateTime('@'.mktime(0, 0, 0, $this->options['m'], $this->options['d'], $this->options['y']));
    }

    /**
     * Get the SQL for finding events
     * 
     * @see \UNL\UCBCN\ActiveRecord\RecordList::getSQL()
     */
    function getSQL()
    {
        $timestamp = $this->getDateTime()->getTimestamp();

        $sql = 'SELECT eventdatetime.id FROM eventdatetime
                INNER JOIN event ON eventdatetime.event_id = event.id
                WHERE
                    eventdatetime.starttime >= "'.date('Y-m-d', $timestamp).'"
                ORDER BY eventdatetime.starttime ASC, event.title ASC
                ';
        return $sql;
    }
    
    /**
     * Get a permanent URL to this object.
     * 
     * @return string URL to this specific upcoming.
     */
    public function getURL()
    {
        return 'upcoming';
    }
    
}
