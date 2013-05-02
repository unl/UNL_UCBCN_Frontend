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
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\RuntimeException;

use UNL\UCBCN\UnexpectedValueException;

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
class Controller
{
    /**
     * Calendar UNL_UCBCN_Calendar Object
     *
     * @var UNL_UCBCN_Calendar
     */
    public $calendar;
    
    /**
     * URI to the frontend
     *
     * @var string
     */
    public static $url = '/workspace/UNL_UCBCN_Frontend/www/';

    /**
     * URI to the management interface UNL_UCBCN_Manager
     *
     * @var string EG: http://events.unl.edu/manager/
     */
    public static $manager_url = '';

    /**
     * Configurable ID for the base/master calendar
     *
     * @var int
     */
    public static $default_calendar_id = 1;

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
    public function __construct($options = array())
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
     * @throws Exception if view is unregistered
     */
    public function run()
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

    public function getURL()
    {
        return self::$url;
    }

    /**
     * Gets the specified event instance.
     *
     * @param int                $id       The id of the event instance to get.
     * @param UNL_UCBCN_Calendar $calendar The calendar to get the event for.
     *
     * @return object UNL_UCBCN_EventInstance on success UNL_UCBCN_Error on error.
     */
    public function getEventInstance($id, $calendar=null, $event_id=null)
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
     * Add a file extension to the existing URL
     *
     * @param string $url       The URL
     * @param string $extension The file extension to add, e.g. csv
     */
    public static function addURLExtension($url, $extension)
    {
        $extension = trim($extension, '.');

        return preg_replace('/^([^?]+)(\.[\w]+)?(\?.*)?$/', '$1.'.$extension.'$3', $url);
    }

    /**
     * Add unique querystring parameters to a URL
     *
     * @param string $url               The URL
     * @param array  $additional_params Additional querystring parameters to add
     *
     * @return string
     */
    public static function addURLParams($url, $additional_params = array())
    {
        $params = self::getURLParams($url);

        $params = array_merge($params, $additional_params);

        if (strpos($url, '?') !== false) {
            $url = substr($url, 0, strpos($url, '?'));
        }

        $url .= '?';

        foreach ($params as $option=>$value) {
            if ($option == 'driver') {
                continue;
            }
            if ($option == 'format'
                && $value == 'html') {
                continue;
            }
            if (isset($value)) {
                if (is_array($value)) {
                    foreach ($value as $arr_value) {
                        $url .= "&{$option}[]=$arr_value";
                    }
                } else {
                    $url .= "&$option=$value";
                }
            }
        }
        $url = str_replace('?&', '?', $url);

        return trim($url, '?;=');
    }

    /**
     * Get the querystring parameters for a URL
     *
     * @param string $url 
     *
     * @return array key=>value pairs
     */
    public static function getURLParams($url)
    {
        $params = array();
        if (strpos($url, '?') !== false) {
            list($url, $existing_params) = explode('?', $url);
            $existing_params = explode('&', html_entity_decode($existing_params, ENT_QUOTES, 'UTF-8'));
            foreach ($existing_params as $val) {
                $split = explode('=', $val);
                $params[$split[0]] = '';
                if (isset($split[1])) {
                    $params[$split[0]] = $split[1];
                }
            }
        }

        return $params;
    }

    /**
     * This function checks if a calendar has events on the day requested.
     *
     * @param string             $epoch    Unix epoch of the day to check.
     * @param UNL_UCBCN_Calendar $calendar The calendar to check.
     *
     * @return bool true or false
     */
    public function dayHasEvents($epoch, $calendar = null)
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

    public static function redirect($url, $exit = true)
    {
        header('Location: '.$url);
        if (!defined('CLI')
            && false !== $exit) {
            exit($exit);
        }
    }
}
