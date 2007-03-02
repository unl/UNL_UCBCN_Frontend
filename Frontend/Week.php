<?php

/**
 * This class contains the information needed for viewing a month view calendar.
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */

require_once 'UNL/UCBCN/Frontend.php';
require_once 'UNL/UCBCN/Frontend/Day.php';
require_once 'Calendar/Calendar.php';
require_once 'Calendar/Month/Week.php';

class UNL_UCBCN_Frontend_Week extends UNL_UCBCN
{
	/** Calendar to show events for UNL_UCBCN_Month object */
	var $calendar;
	/** Year the user is viewing. */
	var $year;
	/** Month the user is viewing. */
	var $month;
	/** Week the user is viewing. */
	var $week;
	/** start day of the week */
	var $firstDay = 0;
	/** Listing of events on this week. */
	var $output;
	/** URL of events on this day. */
	var $url;
	/** URL to the next week */
	var $next_url;
	/** URL to the previous week */
	var $prev_url;
	
	function __construct($options)
	{
		parent::__construct($options);
		if (!isset($this->calendar)) {
			$this->calendar = UNL_UCBCN::factory('calendar');
			if (!$this->calendar->get(1)) {
				return new UNL_UCBCN_Error('No calendar specified or could be found.');
			}
		}
		$this->output[] = $this->showWeek();
		if ($this->ongoing===true) {
		    $this->output[] = $this->showOngoingEventListing();
		}
		$this->url = $this->getURL();
	}
	
	function showWeek()
	{
		$week = new Calendar_Week(  $this->year,
									$this->month,
									$this->day,
									$this->firstDay);
		$week->build();
		while ($day = $week->fetch()) {
			$this->output[] = new UNL_UCBCN_Frontend_Day(array(	'y'=>$day->thisYear(),
							'm'=>$day->thisMonth(),
							'd'=>$day->thisDay(),
							'calendar'=>$this->calendar));
		}
	}
	
	function getURL()
	{
		return UNL_UCBCN_Frontend::formatURL(array(		's'=>$this->startDay,
														'd'=>$this->day,
														'm'=>$this->month,
														'y'=>$this->year,
														'calendar'=>$this->calendar->id));
	}
}