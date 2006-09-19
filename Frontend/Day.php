<?php

/**
 * This class contains the information needed for viewing a single day view calendar.
 * 
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */

require_once 'UNL/UCBCN/Frontend.php';
require_once 'UNL/UCBCN/Frontend/MonthWidget.php';
require_once 'UNL/UCBCN/EventListing.php';
require_once 'Calendar/Day.php';

class UNL_UCBCN_Frontend_Day extends UNL_UCBCN
{
	/** Calendar UNL_UCBCN_Calendar Object **/
	var $calendar;
	/** Year the user is viewing. */
	var $year;
	/** Month the user is viewing. */
	var $month;
	/** Day to show events for */
	var $day;
	/** Listing of events on this day. */
	var $output;
	/** URL of events on this day. */
	var $url;
	/** Display ongoing events? */
	var $ongoing = true;
	/** no events message */
	var $noevents = 'Sorry, no events were found for today!';
	
	function __construct($options)
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
	
	function showEventListing()
	{
		$options = array(   'year'=>$this->year,
		                    'month'=>$this->month,
		                    'day'=>$this->day,
		                    'calendar'=>$this->calendar);
	    // Fetch the day evenlisting for this day.
		$eventlist = new UNL_UCBCN_EventListing('day',$options);
	    
		if (count($eventlist->events)) {
			return $eventlist;
		} else {
			return $this->noevents;
		}
	}
	
	function showOngoingEventListing()
	{
	    $options = array(   'year'=>$this->year,
		                    'month'=>$this->month,
		                    'day'=>$this->day,
		                    'calendar'=>$this->calendar);
	    // Fetch the day evenlisting for this day.
		$eventlist = new UNL_UCBCN_EventListing('ongoing',$options);
	    
		if (count($eventlist->events)) {
			return $eventlist;
		} else {
			return NULL;
		}
	}
	
	function getURL()
	{
		return UNL_UCBCN_Frontend::formatURL(array(	'd'=>$this->day,
														'm'=>$this->month,
														'y'=>$this->year,
														'calendar'=>$this->calendar->id));
	}
	
}

?>