<?php
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\RuntimeException;
use UNL\UCBCN\Calendar;

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
class Day extends EventListing
{
    /**
     * Calendar \UNL\UCBCN\Calendar Object
     * 
     * @var \UNL\UCBCN\Calendar
     */
    public $calendar;

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

        // Set defaults
        $this->options['m'] = date('m');
        $this->options['d'] = date('d');
        $this->options['y'] = date('Y');

        parent::__construct($options);
    }

    /**
     * Get the SQL for finding events
     * 
     * @see \UNL\UCBCN\ActiveRecord\RecordList::getSQL()
     */
    function getSQL()
    {
        $timestamp = $this->getDateTime()->getTimestamp();

        $sql = '
                SELECT DISTINCT eventdatetime.id FROM eventdatetime
                INNER JOIN event ON eventdatetime.event_id = event.id
                INNER JOIN calendar_has_event ON calendar_has_event.event_id = event.id
                WHERE
                    calendar_has_event.calendar_id = ' . (int)$this->calendar->id . '
                    AND ((eventdatetime.starttime >= "'.date('Y-m-d', $timestamp).'"
                        AND eventdatetime.starttime < "'.date('Y-m-d', $timestamp+86400).'")
                        OR (NOW() BETWEEN eventdatetime.starttime AND eventdatetime.endtime))
                ORDER BY eventdatetime.starttime ASC, event.title ASC
                ';
        return $sql;
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
        return $url . date('Y/m/d', $this->getDateTime()->getTimestamp());
    }
    
}
