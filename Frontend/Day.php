<?php

/**
 * This class contains the information needed for viewing a single day view calendar.
 * 
 */

require_once 'UNL/UCBCN/Frontend.php';
require_once 'UNL/UCBCN/Frontend/MonthWidget.php';

class UNL_UCBCN_Frontend_Day extends UNL_UCBCN_Frontend
{
	/** Year the user is viewing. */
	var $year;
	/** Month the user is viewing. */
	var $month;
	/** array of days */
	var $day;
	/** Listing of events on this day. */
	var $events = array();
	/** UNL_UCBCN_MonthWidget */
	var $monthwidget;
	
	function __construct($options)
	{
		parent::__construct($options);
		$this->monthwidget = new UNL_UCBCN_MonthWidget($this->year,$this->month);
		$this->findEvents();
	}
	
	function findEvents()
	{
		$events = $this->factory('event');
		// Need to figure out how events are dated.
		if ($events->find()) {
			// Populate the events to display.
			$this->events = array('Event1','Event2 etc etc');
		} else {
			$this->events = 'Sorry, no events were found for today!';
		}
	}
	
}

?>