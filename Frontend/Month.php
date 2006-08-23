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
		$Month = new Calendar_Month_Weekdays($y, $m, 0);
		$PMonth = $Month->prevMonth('object'); // Get previous month as object
		$prev = UNL_UCBCN_Frontend::formatURL(array(	'y'=>$PMonth->thisYear(),
														'm'=>$PMonth->thisMonth(),
														'calendar'=>$this->calendar->id));
		$NMonth = $Month->nextMonth('object');
		$next = UNL_UCBCN_Frontend::formatURL(array(	'y'=>$NMonth->thisYear(),
														'm'=>$NMonth->thisMonth(),
														'calendar'=>$this->calendar->id));
		
		$this->caption = '<ul>
		<li><a href="'.$prev.'" id="prev_month" title="View events for '.Calendar_Util_Textual::thisMonthName($PMonth).' '.$PMonth->thisYear().'">&lt;&lt; </a></li>
		<li id="monthvalue"><a href="'.
						UNL_UCBCN_Frontend::formatURL(array(	'y'=>$Month->thisYear(),
																'm'=>$Month->thisMonth(),
																'calendar'=>$this->calendar->id)).'">'.Calendar_Util_Textual::thisMonthName($Month).'</a></li>
		<li id="yearvalue"><a href="'.
						UNL_UCBCN_Frontend::formatURL(array(	'y'=>$Month->thisYear(),
																'calendar'=>$this->calendar->id)).'">'.$Month->thisYear().'</a></li>
		<li><a href="'.$next.'" id="next_month" title="View events for '.Calendar_Util_Textual::thisMonthName($NMonth).' '.$NMonth->thisYear().'"> &gt;&gt;</a></li>
		</ul>';
		
		//Determine selected days
		$selectedDays = array();
		$Month->build($selectedDays);
		
		while ( $Day = $Month->fetch() ) {

			// Build a link string for each day
			$link = UNL_UCBCN_Frontend::formatURL(array(	'y'=>$Day->thisYear(),
															'm'=>$Day->thisMonth(),
															'd'=>$Day->thisDay(),
															'calendar'=>$this->calendar->id));
			
			// isFirst() to find start of week
			if ( $Day->isFirst() )
				$this->tbody .= "<tr>\n";
			if ( $Day->isEmpty() ) {
				$this->tbody .= "<td class='empty'><a href='".$link."'>".$Day->thisDay()."</a></td>\n";
			} else {
				$this->tbody .= "<td><a href='".$link."'>".$Day->thisDay().'</a>'.$this->dayEventList($Day)."</td>\n";
			}
			
			// isLast() to find end of week
			if ( $Day->isLast() )
				$this->tbody .= "</tr>\n";
		}
	}
	
	function dayEventList($day)
	{
		$return = array();
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
		$return[] = '<ul>';
		while ($eventdatetime->fetch()) {
			$einstance = new UNL_UCBCN_EventInstance($eventdatetime,$this->calendar);
			$li = '<li>';
			if (strpos($eventdatetime->starttime,'00:00:00')===false) {
				$li .= date('ga',strtotime($eventdatetime->starttime));
				if (isset($eventdatetime->endtime) &&
			    	($eventdatetime->endtime != $eventdatetime->starttime) &&
			    	($eventdatetime->endtime > $eventdatetime->starttime)) {
			    		$li .= '-'.date('ga',strtotime($eventdatetime->endtime));
		    	}
		    	$li .= ': ';
			}
			$li .= '<a href="'.$einstance->getURL().'">'.$einstance->event->title.'</a></li>';
			$return[] = $li;
		}
		$return[] = '</ul>';
		if (count($return)>2) {
			return implode("\n",$return);
		} else {
			return '';
		}
	}
	
}

?>