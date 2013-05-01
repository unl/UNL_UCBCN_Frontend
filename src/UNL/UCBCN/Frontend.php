<?php
/**
 * This is the primary viewing interface for the events.
 * This would be the 'model/controller' if you follow that paradigm.
 *
 * This file contains functions used throughout the frontend views.
 *
 * PHP version 5
 *
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://code.google.com/p/unl-event-publisher/
 * @todo      Add new output formats such as serialized PHP, XML, and JSON.
 */


/**
 * This is the basic frontend output class through which all output to the public is
 * generated. This class handles the determination of what view the user requested
 * and what information to send.
 *
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://code.google.com/p/unl-event-publisher/
 */
class UNL_UCBCN_Frontend
{
    /**
     * Calendar UNL_UCBCN_Calendar Object
     *
     * @var UNL_UCBCN_Calendar
     */
    public $calendar;
    
    /**
     * URI to the management frontend
     *
     * @var string
     */
    public $uri = '';
    
    /**
     * URI to the management interface UNL_UCBCN_Manager
     *
     * @var string EG: http://events.unl.edu/manager/
     */
    public $manageruri = '';
    
    /**
     * Right column (usually the month widget)
     *
     * @var string
     */
    public $right;
    
    /**
     * Main content of the page sent to the client.
     *
     * @var mixed
     */
    public $output;

    /**
     * Options array
     * Will include $_GET vars
     */
    public $options = array(
        'model'  => false,
        'format' => 'html',
    );
    
    /**
     * Constructor for the frontend.
     *
     * @param array $options Associative array of options for the frontend.
     */
    function __construct($options = array())
    {
        $this->options = $options + $this->options;

        try {
            $this->run();
        } catch (\Exception $e) {
            $this->output = $e;
        }

    }
    
    /**
     * Runs/builds the frontend object with the display parameters set.
     * This function will populate all of the output and member variables with the
     * data for the current view.
     *
     * @return void
     */
    function run()
    {
        $this->determineCalendar();

        if (!isset($this->options['model'])
            || false === $this->options['model']) {
            throw new UnexpectedValueException('Un-registered view', 404);
        }

        if (is_callable($this->options['model'])) {
            $this->output = call_user_func($this->options['model'], $this->options);
        } else {
            $this->output = new $this->options['model']($this->options);
        }
    }

    protected function determineCalendar()
    {
        if (isset($this->options['calendar_shortname'])) {
            // Try and get by shortname
            $this->options['calendar'] = \UNL\UCBCN\Calendar::getByShortName($this->options['calendar_shortname']);
        } else {
            $this->options['calendar'] = \UNL\UCBCN\Calendar::getByID(self::$default_calendar_id);
        }

        if (!$this->options['calendar']) {
            throw new RuntimeException('No calendar could be found.', 404);
        }
    }
    
    /**
     * Gets the specified event instance.
     *
     * @param int                $id       The id of the event instance to get.
     * @param UNL_UCBCN_Calendar $calendar The calendar to get the event for.
     *
     * @return object UNL_UCBCN_EventInstance on success UNL_UCBCN_Error on error.
     */
    function getEventInstance($id, $calendar=null, $event_id=null)
    {
        // Get recurring dates, if any
        if (isset($event_id)) {
            $db  = $this->getDatabaseConnection();
            $sql = 'SELECT recurringdate FROM recurringdate WHERE event_id='.$event_id.';';
            $res = $db->query($sql);
            $rdates = $res->fetchCol();
        }
        $event_instance = new UNL_UCBCN_EventInstance($id, $calendar);
        if (isset($_GET['y'], $_GET['m'], $_GET['d'])) {
            $in_date   = str_replace(array('/',' '), '', $_GET['y'].'-'.$_GET['m'].'-'.$_GET['d']);
            $in_date   = date('Y-m-d', strtotime($in_date));
            $real_date = $date = date('Y-m-d', strtotime($event_instance->eventdatetime->starttime));
 
            // Check if the date is a recurring date for this event
            if (isset($rdates) && in_array($in_date, $rdates)) {
                //$starttime =& $event_instance->eventdatetime->starttime;
                //$starttime = $in_date . substr($starttime, 10);
                $sql = 'SELECT recurringdate, recurrence_id, ongoing FROM recurringdate '.
                       'WHERE event_id='.$event_id.' '.
                   	   'AND recurringdate LIKE \''.$in_date.'\';';
                $res = $db->query($sql);
                $rinfo = $res->fetchRow();
                $event_instance->fixRecurringEvent($event_instance, $rinfo[0], $rinfo[1], $rinfo[2]);
            }
            // Verify the date is correct, otherwise, redirect to the correct location.
            else if ($in_date != $real_date) {
                header('HTTP/1.0 301 Moved Permanently');
                header('Location: '.html_entity_decode($event_instance->url));
                exit;
            }
        }
        return $event_instance;
    }
    
    /**
     * Returns a formatted URL.
     *
     * @param array $values Associative array of the values to add to the URL
     * @param bool  $encode If true and format is querystring, ampersands will be &amp;
     *
     * @return string URL to a frontend which has the data in the format requested.
     */
    function formatURL($values,$encode = true)
    {
        $order = array('calendar','upcoming','search','y','m','d','eventdatetime_id','q', 'event_id');
        global $_UNL_UCBCN;
        $url = '';
        if (isset($_UNL_UCBCN['uri']) && !empty($_UNL_UCBCN['uri'])) {
            $url = $_UNL_UCBCN['uri'];
        }
        foreach ($order as $val) {
            if (isset($values[$val])) {
                if ($val == 'calendar' && isset($_UNL_UCBCN['default_calendar_id'])) {
                    /* A calendar needs to be formmatted into the URL.
                     * We need to take care to not include it if it is the
                     * default calendar.
                     */
                    if (is_numeric($values[$val])) {
                        $cid = $values[$val];
                    } else {
                        $cid = UNL_UCBCN_Frontend::getCalendarID($values[$val]);
                    }
                    if ($cid != $_UNL_UCBCN['default_calendar_id']) {
                        // This is link is not for the default calendar, add it to the url.
                        $url .= UNL_UCBCN_Frontend::getCalendarShortname($cid).'/';
                    }
                } else {
                    $url .= $values[$val].'/';
                }
            }
        }
        // Final check for the format (rss, ics, etc).
        if (isset($values['format'])) {
            $url .= '?format='.$values['format'];
        }
        return $url;
    }
    
    /**
     * This function is for reformmating URL address. IE, you have the
     * url to the object, but simply want to change the format to ics etc.
     *
     * @param string $url    Url of the form http://
     * @param array  $values Associative array of values to apply. format
     *
     * @return string The URL reformatted to a different output format.
     */
    function reformatURL($url, $values)
    {
        $url .= '?format='.$values['format'];
        return $url;
    }
    
    /**
     * Get's a uniqe key for this object for reference in cache.
     *
     * @return string A unique identifier for this view of the calendar.
     */
    function getCacheKey()
    {
        if ($this->view == 'search' || $this->view == 'upcoming' || $this->view == 'fullcal') {
            // Right now we aren't caching search results or upcoming pages.
            return false;
        }

        return md5(serialize(array_merge($this->options,
                                         array($this->calendar->id))));
    }
    
    /**
     * Returns a calendar shortname for the calendar with the given ID.
     *
     * @param int $id Calendar ID within the database.
     *
     * @return int on success, false on error.
     */
    function getCalendarShortname($id)
    {
        $c = UNL_UCBCN_Frontend::factory('calendar');
        if ($c->get($id)) {
            return $c->shortname;
        }

        return false;

    }
    
    /**
     * Gets the calendar id from a shortname.
     *
     * @param string $shortname The value for the shortname field in the calendar table.
     *
     * @return int id on success, false on error.
     */
    function getCalendarID($shortname)
    {
        $c            = UNL_UCBCN_Frontend::factory('calendar');
        $c->shortname = $shortname;
        if ($c->find() && $c->fetch()) {
            return $c->id;
        }

        return false;

    }
    
    /**
     * Get a list of calendars with a given status
     *
     * @param string $status The value of the status in the calendar table
     *
     * @return
     */
    function getCalendarsByStatus($status)
    {
		$c = UNL_UCBCN_Frontend::factory('calendar');
		$c->calendarstatus = $status;
		$c->orderBy('name ASC');
		if ($c->find()) {
			return $c;
		}

		return false;
    }
    
    /**
     * Get a list of event types
     *
     * @return
     */
    function getEventTypes()
    {
		$e = UNL_UCBCN_Frontend::factory('eventtype');
		$e->orderBy('name ASC');
		if ($e->find()) {
			return $e;
		}

		return false;
    }
    
    /**
     * This function converts a string stored in the database to html output.
     * & becomes &amp; etc.
     *
     * @param string $t Normally a varchar string from the database.
     *
     * @return String encoded for output to html.
     */
    function dbStringToHtml($text)
    {
        $text = str_replace(array('&amp;', '&'), array('&', '&amp;'), $text);
        return nl2br($text);
    }
    
    /**
     * This function checks if a calendar has events on the day requested.
     *
     * @param string             $epoch    Unix epoch of the day to check.
     * @param UNL_UCBCN_Calendar $calendar The calendar to check.
     *
     * @return bool true or false
     */
    function dayHasEvents($epoch, $calendar = null)
    {
        
        if (isset($calendar)) {
            $db  =& $calendar->getDatabaseConnection();
            $res =& $db->query('SELECT DISTINCT eventdatetime.id FROM calendar_has_event,eventdatetime
                                WHERE calendar_has_event.calendar_id='.$calendar->id.'
                                AND (calendar_has_event.status =\'posted\'
                                     OR calendar_has_event.status =\'archived\')
                                AND calendar_has_event.event_id = eventdatetime.event_id
                                AND (eventdatetime.starttime LIKE \''.date('Y-m-d', $epoch).'%\'
                                    OR (eventdatetime.starttime<\''.date('Y-m-d 00:00:00', $epoch).'\'
                                        AND eventdatetime.endtime > \''.date('Y-m-d 00:00:00', $epoch).'\'))
                                LIMIT 1');
            if (!PEAR::isError($res)) {
                return $res->numRows();
            }

            return new UNL_UCBCN_Error($res->getMessage());
        }

        $eventdatetime = UNL_UCBCN_Frontend::factory('eventdatetime');
        $eventdatetime->whereAdd('starttime LIKE \''.date('Y-m-d', $epoch).'%\'');
        return $eventdatetime->find();
    }
    
    /**
     * When the image view is set, the image for a given event will be displayed
     * to the end user.  $_GET['id'] must be set to the event.id which has the image.
     *
     * @return void
     */
    function displayImage()
    {
        if (isset($_GET['id'])) {
            $event = UNL_UCBCN_Frontend::factory('event');
            if ($event->get($_GET['id'])) {
                header('Content-type: '.$event->imagemime);
                echo $event->imagedata;
                exit();
            }
        }
        header('HTTP/1.0 404 Not Found');
        echo '404';
        exit(0);
    }
}
?>