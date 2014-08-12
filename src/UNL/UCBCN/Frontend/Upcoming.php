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
class Upcoming extends EventListing implements RoutableInterface
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
        // Set defaults
        $options['m'] = date('m');
        $options['d'] = date('d');
        $options['y'] = date('Y');

        parent::__construct($options);
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

        $sql = '
                SELECT e.id as id, recurringdate.id as recurringdate_id
                FROM eventdatetime as e
                INNER JOIN event ON e.event_id = event.id
                INNER JOIN calendar_has_event ON calendar_has_event.event_id = event.id
                LEFT JOIN recurringdate ON (recurringdate.event_id = event.id)
                WHERE
                    calendar_has_event.calendar_id = ' . (int)$this->calendar->id . '
                    AND (
                         calendar_has_event.status =\'posted\'
                         OR calendar_has_event.status =\'archived\'
                    )
                    AND (
                        e.starttime >= "'.date('Y-m-d', $timestamp).'"
                        OR recurringdate.recurringdate >= "'.date('Y-m-d', $timestamp).'"
                    )
                ORDER BY e.starttime ASC, recurringdate.recurringdate ASC, event.title ASC
                LIMIT ' . (int)$this->options['limit'];
        return $sql;
    }
    
    /**
     * Get a permanent URL to this object.
     * 
     * @return string URL to this specific upcoming.
     */
    public function getURL()
    {
        return $this->generateURL($this->calendar);
    }

    /**
     * Generate an Upcoming URL for a specific calendar
     *
     * @param Calendar $calendar
     * @return string
     */
    public static function generateURL(Calendar $calendar)
    {
        return $calendar->getURL() . 'upcoming/';
    }

    /**
     * Get the month widget for the context's month
     *
     * @return MonthWidget
     */
    public function getMonthWidget()
    {
        return new MonthWidget($this->options);
    }
}
