<?php

/**
 * This class contains the information needed for viewing the list of upcoming
 * events within the calendar system.
 * 
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */

require_once 'UNL/UCBCN/Frontend.php';
require_once 'UNL/UCBCN/Frontend/MonthWidget.php';
require_once 'UNL/UCBCN/EventListing.php';

class UNL_UCBCN_Frontend_Upcoming extends UNL_UCBCN
{
	/** Calendar UNL_UCBCN_Calendar Object **/
	var $calendar;
	/** Listing of events on this day. */
	var $output;
	/** URL of events on this day. */
	var $url;
	
	function __construct($options)
	{
		parent::__construct($options);
		if (!isset($this->calendar)) {
			$this->calendar = UNL_UCBCN::factory('calendar');
			if (!$this->calendar->get(1)) {
				return new UNL_UCBCN_Error('No calendar specified or could be found.');
			}
		}
		$this->output = $this->showEventListing();
		$this->url = $this->getURL();
	}
	
	function showEventListing()
	{
		$options = array('calendar'=>$this->calendar,
		                 'limit'=>10);
	    // Fetch the day evenlisting for this day.
		$eventlist = new UNL_UCBCN_EventListing('upcoming',$options);
	    
		if (count($eventlist->events)) {
			return $eventlist;
		} else {
			return 'Sorry, no events were found!';
		}
	}
	
	function getURL()
	{
		return UNL_UCBCN_Frontend::formatURL(array(    'upcoming'=>'upcoming',
		                                               'calendar'=>$this->calendar->id));
	}
	
}

?>