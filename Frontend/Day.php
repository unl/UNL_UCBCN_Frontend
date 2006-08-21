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
		$eventlist = new UNL_UCBCN_EventListing();
		$day = new Calendar_Day($this->year,$this->month,$this->day);
		$eventdatetime = $this->factory('eventdatetime');
		if (isset($this->calendar)) {
			$eventdatetime->query('SELECT DISTINCT eventdatetime.* FROM event,calendar_has_event,eventdatetime ' .
									'WHERE calendar_has_event.calendar_id='.$this->calendar->id.' ' .
											'AND (calendar_has_event.status =\'posted\' OR calendar_has_event.status =\'archived\') '.
											'AND calendar_has_event.event_id = eventdatetime.event_id ' .
											'AND eventdatetime.starttime LIKE \''.date('Y-m-d',$day->getTimestamp()).'%\' ' .
									'ORDER BY eventdatetime.starttime ASC');
		} else {
			$eventdatetime->whereAdd('starttime LIKE \''.date('Y-m-d',$day->getTimestamp()).'%\'');
			$eventdatetime->find();
		}
		while ($eventdatetime->fetch()) {
			// Populate the events to display.
			$eventlist->events[] = new UNL_UCBCN_EventInstance($eventdatetime,$this->calendar);
		}
		if (count($eventlist->events)) {
			return $eventlist;
		} else {
			return 'Sorry, no events were found for today!';
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