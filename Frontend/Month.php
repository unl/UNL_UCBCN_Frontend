<?php

/**
 * This class contains the information needed for viewing a month view calendar.
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */

require_once 'UNL/UCBCN/Frontend.php';
require_once 'Calendar/Calendar.php';
require_once 'Calendar/Month/Weekdays.php';
require_once 'Calendar/Util/Textual.php';

class UNL_UCBCN_Frontend_Month extends UNL_UCBCN
{
	/** Calendar to show events for UNL_UCBCN_Month object */
	var $calendar;
	/** Year the user is viewing. */
	var $year;
	/** Month the user is viewing. */
	var $month;
	/** array of days */
	var $days = array();
	
	var $thead;
	var $tfoot;
	var $tbody;
	
	/**
	 * This function constructs the month widget and populates the heading,
	 * caption, footer and body for the MonthWidget.
	 * 
	 * @param int $y Year
	 * @param int $m Month
	 */
	function __construct($y,$m,$calendar=NULL)
	{
		$this->year = $y;
		$this->month = $m;
		$this->calendar = $calendar;
		$Month = new Calendar_Month_Weekdays($y, $m);
		$PMonth = $Month->prevMonth('object'); // Get previous month as object
		$prev = $_SERVER['PHP_SELF'].'?y='.$PMonth->thisYear().'&amp;m='.$PMonth->thisMonth().'&amp;d='.$PMonth->thisDay();
		$NMonth = $Month->nextMonth('object');
		$next = $_SERVER['PHP_SELF'].'?y='.$NMonth->thisYear().'&amp;m='.$NMonth->thisMonth().'&amp;d='.$NMonth->thisDay();
		
		$this->caption = '<ul>
<li><a href="'.$prev.'" id="prev_month" title="View events for '.Calendar_Util_Textual::thisMonthName($PMonth).' '.$PMonth->thisYear().'"><< </a></li>
<li id="monthvalue"><a href="?y='.$Month->thisYear().'&amp;m='.$Month->thisMonth().'">'.Calendar_Util_Textual::thisMonthName($Month).'</a></li>
<li id="yearvalue"><a href="?y='.$Month->thisYear().'">'.$Month->thisYear().'</a></li>
<li><a href="'.$next.'" id="next_month" title="View events for '.Calendar_Util_Textual::thisMonthName($NMonth).' '.$NMonth->thisYear().'"> >></a></li>
</ul>';
		
		//Determine selected days
		$selectedDays = array();
		$Month->build($selectedDays);
		
		while ( $Day = $Month->fetch() ) {
	
	    	// Build a link string for each day
			$link = $_SERVER['PHP_SELF'].
			'?y='.$Day->thisYear().
			'&amp;m='.$Day->thisMonth().
			'&amp;d='.$Day->thisDay();
			
			// isFirst() to find start of week
			if ( $Day->isFirst() )
				$this->tbody .= "<tr>\n";
			if ( $Day->isEmpty() ) {
				$this->tbody .= "<td class='empty'>".$Day->thisDay()."</td>\n";
			} else {
				$this->tbody .= "<td>".$Day->thisDay().$this->dayEventList($Day)."</td>\n";
			}
			
			// isLast() to find end of week
			if ( $Day->isLast() )
				$this->tbody .= "</tr>\n";
		}
	}
	
	function dayEventList($day)
	{
		$eventdatetime = $this->factory('eventdatetime');
		$eventdatetime->whereAdd('starttime LIKE \''.date('Y-m-d',$day->getTimestamp()).'%\'');
		if (isset($this->calendar)) {
			$eventdatetime->joinAdd($this->calendar);
		}
		if ($eventdatetime->find()) {
			$return = array();
			$return[] = '<ul>';
			while ($eventdatetime->fetch()) {
				$event = $eventdatetime->getLink('event_id');
				if (isset($event) && is_object($event)) {
					$return[] = '<li><a href="?id='.$eventdatetime->id.'">'.$event->title.'</a></li>';
				}
			}
			$return[] = '</ul>';
			return implode("\n",$return);
		} else {
			return '';
		}
	}
	
}

?>