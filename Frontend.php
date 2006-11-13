<?php
/**
 * This is the primary viewing interface for the events.
 * This would be the 'model/controller' if you follow that paradigm.
 * 
 * This file contains functions used throughout the frontend views.
 * 
 * @package	UNL_UCBCN_Frontend
 * @author	Brett Bieber
 * @todo	Add new output formats such as serialized PHP, XML, and JSON.
 */

/**
 * Require the backend UNL_UCBCN to extend it.
 */
require_once 'UNL/UCBCN.php';

/**
 * Event instance is a simple class used to hold details about a single event instance
 * which is a UNL_UCBCN_Event and a UNL_UCBCN_Location.
 */
require_once 'UNL/UCBCN/EventInstance.php';

/**
 * The PEAR Date class is used for its knowledge about dates & times.
 */
require_once 'Date.php';

/**
 * This is the basic frontend output class through which all output to the public is generated.
 * This class handles the determination of what view the user requested and what information to send.
 * 
 * @package UNL_UCBCN_Frontend
 */
class UNL_UCBCN_Frontend extends UNL_UCBCN
{
	/** Calendar UNL_UCBCN_Calendar Object **/
	var $calendar;
	/** Year the user is viewing. */
	var $year;
	/** Month the user is viewing. */
	var $month;
	/** Day to show events for */
	var $day;
	/** Specific eventdatetime_id (if used) */
	var $eventdatetime_id = NULL;
	/** URI to the management frontend */
	public $uri = '';
	/** Format of URI's  querystring|rest */
	public $uriformat = 'querystring';
	/** URI to the management interface UNL_UCBCN_Manager */
	public $manageruri = '';
	/** Navigation */
	public $navigation;
	/** Right column (usually the month widget) */
	public $right;
	/** Unique body ID */
	public $uniquebody;
	/** Main content of the page sent to the client. */
	public $output;
	/** Section Title */
	public $sectitle;
	/** View to be displayed */
	public $view = 'day';
	/** format of view */
	public $format = 'html';
	
	function __construct($options)
	{
		parent::__construct($options);
		if (!isset($this->calendar)) {
			$this->calendar = $this->factory('calendar');
			if (isset($_GET['calendar_id'])) {
				$this->calendar->get($_GET['calendar_id']);
			} elseif (!$this->calendar->get($this->default_calendar_id)) {
				return new UNL_UCBCN_Error('No calendar specified or could be found.');
			}
		}
	}
	
	function showNavigation()
	{
		$n = array();
		$n[] = '<ul id="frontend_view_selector" class="'.$this->view.'">';
		$n[] = '<li id="todayview"><a href="'.self::formatURL(array('calendar'=>$this->calendar->id)).'">Today\'s Events</a></li>';
		$n[] = '<li id="monthview"><a href="'.self::formatURL(array('y'=>date('Y'),'m'=>date('m'),'calendar'=>$this->calendar->id)).'">This Month</a></li>';
		$n[] = '<li id="yearview"><a href="'.self::formatURL(array('y'=>date('Y'),'calendar'=>$this->calendar->id)).'">This Year</a></li>';
		$n[] = '</ul>';
		return implode("\n",$n);
	}
	
	/**
	 * This function is called before the run() function to handle
	 * any details prior to populating the data in the object, and 
	 * sends output headers.
	 * 
	 * @param bool $cache_hit if data is already cached or not.
	 */
	function preRun($cache_hit=false)
	{
		switch($this->format) {
			case 'ics':
				// We'll be outputting a ics file
				header('Content-type: text/calendar');
				header('Content-Disposition: attachment; filename="events.ics"');
			break;
			case 'rss':
			    header('Content-type: text/xml');
		    break;
		}
		/*
		if ($cache_hit == true) {
			// cached output is about to be sent to the browser.
		} else {
			// output is not already cached.
		}
		*/
	}
	
	/**
	 * Runs/builds the frontend object with the display parameters set.
	 * This function will populate all of the output and member variables with the
	 * data for the current view.
	 */
	function run()
	{
		$this->navigation = $this->showNavigation();
		switch($this->view) {
			case 'upcoming':
				require_once 'UNL/UCBCN/Frontend/Upcoming.php';
				require_once 'UNL/UCBCN/Frontend/MonthWidget.php';
				$this->output[] = new UNL_UCBCN_Frontend_Upcoming(array(
													'dsn'=>$this->dsn,
													'calendar'=>$this->calendar));
				$this->right = new UNL_UCBCN_Frontend_MonthWidget(date('Y'),date('m'),$this->calendar);
			break;
			case 'event':
			    require_once 'UNL/UCBCN/Frontend/MonthWidget.php';
				if (isset($_GET['eventdatetime_id'])) {
					$id = $_GET['eventdatetime_id'];
				}
				$this->output[] = $this->getEventInstance($id);
				$this->right = new UNL_UCBCN_Frontend_MonthWidget($this->year,$this->month,$this->calendar);
			break;
			default:
			case 'day':
			    require_once 'UNL/UCBCN/Frontend/Day.php';
			    require_once 'UNL/UCBCN/Frontend/MonthWidget.php';
				$this->output[] = new UNL_UCBCN_Frontend_Day(array(
											'dsn'		=> $this->dsn,
											'year'		=> $this->year,
											'month'		=> $this->month,
											'day'		=> $this->day,
											'calendar'	=> $this->calendar));
				$this->right = new UNL_UCBCN_Frontend_MonthWidget($this->year,$this->month,$this->calendar);
			break;
			case 'month':
			    require_once 'UNL/UCBCN/Frontend/Month.php';
				$this->output[] = new UNL_UCBCN_Frontend_Month($this->year,$this->month,$this->calendar,$this->dsn);
			break;
			case 'monthwidget':
			    require_once 'UNL/UCBCN/Frontend/MonthWidget.php';
			    UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend','Frontend_hcalendar');
			    $this->output[] = new UNL_UCBCN_Frontend_MonthWidget($this->year,$this->month,$this->calendar);
		    break;
			case 'year':
			    require_once 'UNL/UCBCN/Frontend/Year.php';
				$this->output[] = new UNL_UCBCN_Frontend_Year($this->year,$this->calendar);
			break;
			case 'search':
			    require_once 'UNL/UCBCN/Frontend/Search.php';
			    if (isset($_GET['q'])) {
			        $q = $_GET['q'];
			    } else {
			        $q = NULL;
			    }
			    $this->output[] = new UNL_UCBCN_Frontend_Search(array('calendar'=>$this->calendar,'query'=>$q));
			break;
		}
		switch($this->format) {
			case 'xml':
				UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend','Frontend_XML');
			break;
			case 'hcalendar':
				UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend','Frontend_hcalendar');
			break;
			case 'ics':
			case 'ical':
			case 'icalendar':
				UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend','Frontend_icalendar');
			break;
			case 'rss':
				UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend','Frontend_rss');
			break;
			case 'html':
			default:
				// Standard template works for html.
			break;
		}
	}
	
	/**
	 * Gets the specified event instance.
	 * 
	 * @param int id
	 * @return object UNL_UCBCN_EventInstance on success UNL_UCBCN_Error on error.
	 */
	function getEventInstance($id)
	{
		return new UNL_UCBCN_EventInstance($id);
	}
	
	/**
	 * Returns a formatted URL.
	 * 
	 * @param array Associative array of the values to add to the URL
	 * @param bool If true and format is querystring, ampersands will be &amp;
	 * @return string URL to a frontend which has the data in the format requested.
	 */
	function formatURL($values,$encode = true)
	{
		$order = array('calendar','upcoming','search','y','m','d','eventdatetime_id');
		global $_UNL_UCBCN;
		$url = '?';
		if (isset($_UNL_UCBCN['uri']) && !empty($_UNL_UCBCN['uri'])) {
			$url = $_UNL_UCBCN['uri'];
		}
		switch(UNL_UCBCN_Frontend::uriFormat()) {
			case 'rest':
			case 'REST':
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
			break;
			case 'querystring':
			default:
				foreach ($order as $val) {
					if (isset($values[$val])) {
						if ($val == 'calendar' && isset($_UNL_UCBCN['default_calendar_id'])) {
							if (is_numeric($values[$val])) {
								$cid = $values[$val];
							} else {
								$cid = UNL_UCBCN_Frontend::getCalendarID($values[$val]);
							}
							if ($cid != $_UNL_UCBCN['default_calendar_id']) {
								// This is link is not for the default calendar, add it to the url.
								$url .= 'calendar_id='.$values[$val];
							}
						} else {
							$url .= $val.'='.$values[$val];
						}
						if ($encode == true) {
							$url .= '&amp;';
						} else {
							$url .= '&';
						}
					}
				}
			    // Final check for the format (rss, ics, etc).
				if (isset($values['format'])) {
				    $url .= 'format='.$values['format'];
				}
			break;
		}
		return $url;
	}
	
	/**
	 * This function is for reformmating URL address. IE, you have the 
	 * url to the object, but simply want to change the format to ics etc.
	 * 
	 * @param string $url Url of the form http://
	 * @param array $values
	 * @return string The URL reformatted to a different output format.
	 */
	function reformatURL($url,$values)
	{
		if (isset($values['format'])) {
		    switch(UNL_UCBCN_Frontend::uriFormat()) {
				case 'rest':
				case 'REST':
				    $url .= '?format='.$values['format'];
			    break;
			    case 'querystring':
				default:
				    $url .= 'format='.$values['format'];
				break;
		    }
		}
		return $url;
	}
	
	/**
	 * Sets and/or returns the uri format.
	 * 
	 * @param string $set optional string, pass it to set the uriFormat, don't pass it to retrieve.
	 * @return string rest or querystring
	 */
	function uriFormat($set=NULL)
	{
	    global $_UNL_UCBCN;
	    if (isset($set)) {
	        switch($set){
	            case 'rest':
	            case 'REST':
	                $format = 'rest';
	            break;
	            default:
	            case 'querystring':
	                $format = 'querystring';
	            break;
	        }
	        $_UNL_UCBCN['uriformat'] = $format;
	    } else {
		    if (isset($_UNL_UCBCN['uriformat'])) {
				$format = $_UNL_UCBCN['uriformat'];
			} else {
				$format = 'querystring';
			}
	    }
	    return $format;
	}
	
	/**
	 * This function attempts to determine the view parameters for the frontend output.
	 * 
	 * @return array options to be sent to the constructor.
	 */
	function determineView($method='GET')
	{
		$view = array();
		switch ($method) {
			case 'GET':
			case '_GET':
			case 'get':
			default:
				$method = '_GET';
			break;
			case 'post':
			case 'POST':
			case '_POST':
				$method = '_POST';
			break;
		}
		$view['view'] = 'day';
		if (isset($GLOBALS[$method]['y'])&&!empty($GLOBALS[$method]['y'])) {
			$view['year'] = (int)$GLOBALS[$method]['y'];
			$view['view'] = 'year';
		} else {
			$view['year'] = date('Y');
		}
		if (isset($GLOBALS[$method]['m'])&&!empty($GLOBALS[$method]['m'])) {
			$view['view'] = 'month';
			$view['month'] = (int)$GLOBALS[$method]['m'];
		} else {
			$view['month'] = date('m');
		}
		if (isset($GLOBALS[$method]['d'])&&!empty($GLOBALS[$method]['d'])) {
			$view['view'] = 'day';
			$view['day'] = (int)$GLOBALS[$method]['d'];
		} else {
			$view['day'] = date('j');
		}
		if (isset($GLOBALS[$method]['eventdatetime_id'])&&!empty($GLOBALS[$method]['eventdatetime_id'])) {
			$view['view'] = 'event';
			$view['eventdatetime_id'] = $GLOBALS[$method]['eventdatetime_id'];
		}
		
		if (isset($GLOBALS[$method]['month'])) {
		    $view['view'] = 'month';
		}
		if (isset($GLOBALS[$method]['search'])) {
		    $view['view'] = 'search';
		}
		if (isset($GLOBALS[$method]['upcoming'])) {
		    $view['view'] = 'upcoming';
		}
		if (isset($GLOBALS[$method]['monthwidget'])) {
		    $view['view'] = 'monthwidget';
		}
		
		if (isset($GLOBALS[$method]['format'])) {
			$view['format'] = $GLOBALS[$method]['format'];
		} else {
			$view['format'] = 'html';
		}
		return $view;
	}
	
	/**
	 * Get's a uniqe key for this object for reference in cache.
	 */
	function getCacheKey()
	{
	    if ($this->view == 'search') {
	        // Right now we aren't caching search reseults pages.
	        return false;
	    } else {
	        return md5(serialize(array_merge($this->determineView(),array($this->calendar->id))));
	    }
	}
	
	/**
	 * Returns a calendar shortname for the calendar with the given ID.
	 * @param int Calendar ID within the database.
	 * @return int on success, false on error.
	 */
	function getCalendarShortname($id)
	{
		$c = UNL_UCBCN::factory('calendar');
		if ($c->get($id)) {
			return $c->shortname;
		} else {
			return false;
		}
	}
	
	/**
	 * Gets the calendar id from a shortname.
	 * @param string shortname
	 * @return int id on success, false on error.
	 */
	function getCalendarID($shortname)
	{
		$c = UNL_UCBCN::factory('calendar');
		$c->shortname = $shortname;
		if ($c->find() && $c->fetch()) {
			return $c->id;
		} else {
			return false;
		}
	}
	
	/**
	 * This function converts a string stored in the database to html output.
	 * 
	 * & becomes &amp; etc.
	 * @param string Normally a varchar string from the database.
	 */
	function dbStringToHtml($t)
	{
		return str_replace('& ','&amp; ',$t);
	}
	
/**
	 * This function checks if a calendar has events on the day requested.
	 * @param object Calendar_Day object
	 * @param calendar UNL_UCBCN_Calendar object
	 * @return bool true or false
	 */
	function dayHasEvents($epoch,$calendar = NULL)
	{
		
		if (isset($calendar)) {
			$db =& $calendar->getDatabaseConnection();
			$res =& $db->query('SELECT DISTINCT eventdatetime.id FROM calendar_has_event,eventdatetime ' .
									'WHERE calendar_has_event.calendar_id='.$calendar->id.' ' .
											'AND (calendar_has_event.status =\'posted\' OR calendar_has_event.status =\'archived\') '.
											'AND calendar_has_event.event_id = eventdatetime.event_id ' .
											'AND (eventdatetime.starttime LIKE \''.date('Y-m-d',$epoch).'%\' 
												OR (eventdatetime.starttime<\''.date('Y-m-d 00:00:00',$epoch).'\' AND eventdatetime.endtime > \''.date('Y-m-d 00:00:00',$epoch).'\'))');
			if (!PEAR::isError($res)) {
				return $res->numRows();
			} else {
				return new UNL_UCBCN_Error($res->getMessage());
			}
		} else {
			$eventdatetime = $this->factory('eventdatetime');
			$eventdatetime->whereAdd('starttime LIKE \''.date('Y-m-d',$epoch).'%\'');
			return $eventdatetime->find();
		}
	}
}
?>