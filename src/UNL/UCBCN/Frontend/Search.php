<?php
/**
 * Search class for frontend users to search for events.
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
 * @todo      Add searching by eventtype.
 */
namespace UNL\UCBCN\Frontend;

/**
 * Container for search results for the frontend.
 *
 * PHP version 5
 * 
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License 
 * @link      http://code.google.com/p/unl-event-publisher/
 */
class Search extends EventListing implements RoutableInterface
{
    public $search_query = '';

    /**
     * Constructs this search output.
     *
     * @param array $options Associative array of options.
     * @throws UnexpectedValueException
     */
    public function __construct($options=array())
    {
        if (!isset($options['q'])) {
            throw new UnexpectedValueException('Enter a search string to search for events.', 400);
        }
        
        $this->search_query = $options['q'];
        
        parent::__construct($options);
    }

    /**
     * Get the SQL for finding events
     *
     * @see \UNL\UCBCN\ActiveRecord\RecordList::getSQL()
     */
    function getSQL()
    {
        $sql = '
                SELECT DISTINCT e.id as id, recurringdate.id as recurringdate_id
                FROM eventdatetime as e
                INNER JOIN event ON e.event_id = event.id
                INNER JOIN calendar_has_event ON calendar_has_event.event_id = event.id
                LEFT JOIN recurringdate ON (recurringdate.event_id = event.id AND recurringdate.unlinked = 0)
                LEFT JOIN event_has_eventtype ON (event_has_eventtype.event_id = event.id)
                LEFT JOIN eventtype ON (eventtype.id = event_has_eventtype.eventtype_id)
                LEFT JOIN location ON (location.id = e.location_id)
                WHERE
                    calendar_has_event.calendar_id = ' . (int)$this->calendar->id . '
                    AND calendar_has_event.status IN ("posted", "archived")
                    AND  (';

        if (($t = strtotime($this->search_query)) && ($this->search_query != 'art')) {
            // This is a time...
            $sql .= 'e.starttime LIKE \''.date('Y-m-d', $t).'%\'';
        } else {
            // Do a textual search.
            $sql .=
                '(event.title LIKE \'%'.self::escapeString($this->search_query).'%\' OR '.
                '(eventtype.name LIKE \'%'.self::escapeString($this->search_query).'%\') OR '.

                'event.description LIKE \'%'.self::escapeString($this->search_query).'%\' OR '.
                '(location.name LIKE \'%'.self::escapeString($this->search_query).'%\')) AND '.
                '(e.starttime>=\''.date('Y-m-d').' 00:00:00\' OR '.
                'e.endtime>\''.date('Y-m-d').' 00:00:00\')';
        }

        $sql.= ')
                ORDER BY e.starttime ASC, recurringdate.recurringdate ASC, event.title ASC';

        return $sql;
    }
    
    /**
     * returns the url to this search page.
     *
     * @return string
     */
    public function getURL()
    {
        $url = $this->options['calendar']->getURL() . 'search/';
        
        if (!empty($this->search_query)) {
            $url .= $this->search_query . '/';
        }
        
        return $url;
    }
    
}
