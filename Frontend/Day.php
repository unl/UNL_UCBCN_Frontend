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
	
	function __construct($options)
	{
		parent::__construct($options);
		if (!isset($this->calendar)) {
			$this->calendar = $this->factory('calendar');
			if (!$this->calendar->get(1)) {
				return new UNL_UCBCN_Error('No calendar specified or could be found.');
			}
		}
		$this->output = $this->showEventListing();
	}
	
	function showEventListing()
	{
		$day = new Calendar_Day($this->year,$this->month,$this->day);
		$eventdatetime = $this->factory('eventdatetime');
		if (isset($this->calendar)) {
			$eventdatetime->joinAdd($this->calendar);
		}
		$eventdatetime->whereAdd('starttime LIKE \''.date('Y-m-d',$day->getTimestamp()).'%\'');
		if ($eventdatetime->find()) {
			$eventlist = new UNL_UCBCN_EventListing();
			while ($eventdatetime->fetch()) {
				// Populate the events to display.
				$event = $eventdatetime->getLink('event_id');
				if ($event) {
					$eventlist->events[] = $event;
				}
			}
			return $eventlist;
		} else {
			return 'Sorry, no events were found for today!';
		}
	}
	
}

?>