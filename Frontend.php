<?php
/**
 * This is the primary viewing interface for the events.
 * This would be the 'model/controller' if you follow that paradigm.
 * 
 * This file contains functions used throughout the frontend views.
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */
require_once 'UNL/UCBCN.php';
require_once 'UNL/UCBCN/EventInstance.php';
require_once 'UNL/UCBCN/Frontend/Day.php';
require_once 'UNL/UCBCN/Frontend/Month.php';
require_once 'UNL/UCBCN/Frontend/Year.php';
require_once 'Date.php';

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
	/** URI to the management frontend */
	public $uri = '';
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
	/** Page Title */
	public $doctitle;
	/** Section Title */
	public $sectitle;
	
	function __construct($options)
	{
		parent::__construct($options);
		if (!isset($this->calendar)) {
			$this->calendar = $this->factory('calendar');
			if (isset($_GET['calendar_id'])) {
				$this->calendar->get($_GET['calendar_id']);
			} elseif (!$this->calendar->get(1)) {
				return new UNL_UCBCN_Error('No calendar specified or could be found.');
			}
		}
		$this->navigation = $this->showNavigation();
		$this->doctitle = 'Events';
	}
	
	function showNavigation()
	{
		$n = array();
		$n[] = '<ul id="frontend_view_selector">';
		$n[] = '<li id="todayview"><a href="'.$this->uri.'">Today\'s Events</a></li>';
		$n[] = '<li id="monthview"><a href="'.$this->uri.'?'.date('\m=m\&\a\m\p\;\y=Y').'">This Month</a></li>';
		$n[] = '<li id="yearview"><a href="'.$this->uri.'?'.date('\y=Y').'">This Year</a></li>';
		$n[] = '</ul>';
		return implode("\n",$n);
	}
	
	function run($view=NULL,$format=NULL)
	{
		switch($view) {
			case 'event':
				if (isset($_GET['id'])) {
					$id = $_GET['id'];
				}
				$this->output = $this->getEventInstance($id);
				$this->right = new UNL_UCBCN_Frontend_MonthWidget($this->year,$this->month,$this->calendar);
			break;
			default:
			case 'day':
				$this->output = new UNL_UCBCN_Frontend_Day(array(
											'dsn'		=> $this->dsn,
											'year'		=> $this->year,
											'month'		=> $this->month,
											'day'		=> $this->day,
											'calendar'	=> $this->calendar));
				$this->right = new UNL_UCBCN_Frontend_MonthWidget($this->year,$this->month,$this->calendar);
			break;
			case 'month':
				$this->output = new UNL_UCBCN_Frontend_Month($this->year,$this->month);
			break;
			case 'year':
				$this->output[] = '<h1 class="year_main">'.$this->year.'</h1>';
				$this->output[] = new UNL_UCBCN_Frontend_Year($this->year);
			break;
		}
		switch($format) {
			case 'xml':
				UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend','Frontend_XML');
			break;
			case 'hcalendar':
				UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend','Frontend_hcalendar');
			break;
			case 'ics':
				// Add header for ics file..?
			case 'ical':
			case 'icalendar':
				UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend','Frontend_icalendar');
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
}
?>