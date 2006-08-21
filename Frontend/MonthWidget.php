<?php

/**
 * This class defines a 30 day widget containing information for a given month.
 * 
 * 
 * @package UNL_UCBCN_Frontend
 * @author bbieber
 */

require_once 'UNL/UCBCN.php';
require_once 'Calendar/Calendar.php';
require_once 'Calendar/Month/Weekdays.php';
require_once 'Calendar/Util/Textual.php';

class UNL_UCBCN_Frontend_MonthWidget extends UNL_UCBCN
{	

	/** Calendar UNL_UCBCN_Calendar Object **/
	var $calendar;
	/** Year for this month widget */
	var $year;
	/** Month for this month widget. */
	var $month;
	/** Caption for the month widget. */
	var $caption;
	
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
		$Month = new Calendar_Month_Weekdays($y, $m, 0);
		$PMonth = $Month->prevMonth('object'); // Get previous month as object
		$prev = UNL_UCBCN_Frontend::formatURL(array(	'y'=>$PMonth->thisYear(),
														'm'=>$PMonth->thisMonth()));
		$NMonth = $Month->nextMonth('object');
		$next = UNL_UCBCN_Frontend::formatURL(array(	'y'=>$NMonth->thisYear(),
														'm'=>$NMonth->thisMonth()));
		
		$this->caption = '<ul>
		<li><a href="'.$prev.'" id="prev_month" title="View events for '.Calendar_Util_Textual::thisMonthName($PMonth).' '.$PMonth->thisYear().'"><< </a></li>
		<li id="monthvalue"><a href="'.
						UNL_UCBCN_Frontend::formatURL(array(	'y'=>$Month->thisYear(),
																'm'=>$Month->thisMonth(),
																'calendar'=>$this->calendar->id)).'">'.Calendar_Util_Textual::thisMonthName($Month).'</a></li>
		<li id="yearvalue"><a href="'.
						UNL_UCBCN_Frontend::formatURL(array(	'y'=>$Month->thisYear(),
																'calendar'=>$this->calendar->id)).'">'.$Month->thisYear().'</a></li>
		<li><a href="'.$next.'" id="next_month" title="View events for '.Calendar_Util_Textual::thisMonthName($NMonth).' '.$NMonth->thisYear().'"> >></a></li>
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
			if ( $this->dayHasEvents($Day,$this->calendar) ) {
				$this->tbody .= "<td class='selected'><a href='$link'>".$Day->thisDay()."</a></td>\n";
			} else if ( $Day->isEmpty() ) {
				$this->tbody .= "<td class='empty'>".$Day->thisDay()."</td>\n";
			} else {
				$this->tbody .= "<td>".$Day->thisDay()."</td>\n";
			}
			
			// isLast() to find end of week
			if ( $Day->isLast() )
				$this->tbody .= "</tr>\n";
		}
	}
	
	/**
	 * This function checks if a calendar has events on the day requested.
	 * @param object Calendar_Day object
	 * @param calendar UNL_UCBCN_Calendar object
	 * @return bool true or false
	 */
	function dayHasEvents($day,$calendar = NULL)
	{
		
		if (isset($calendar)) {
			$db =& $calendar->getDatabaseConnection();
			$res =& $db->query('SELECT DISTINCT eventdatetime.id FROM event,calendar_has_event,eventdatetime ' .
									'WHERE calendar_has_event.calendar_id='.$calendar->id.' ' .
											'AND (calendar_has_event.status =\'posted\' OR calendar_has_event.status =\'archived\') '.
											'AND calendar_has_event.event_id = eventdatetime.event_id ' .
											'AND eventdatetime.starttime LIKE \''.date('Y-m-d',$day->getTimestamp()).'%\' ' .
									'ORDER BY eventdatetime.starttime ASC');
			if (!PEAR::isError($res)) {
				return $res->numRows();
			} else {
				return new UNL_UCBCN_Error($res->getMessage());
			}
		} else {
			$eventdatetime = $this->factory('eventdatetime');
			$eventdatetime->whereAdd('starttime LIKE \''.date('Y-m-d',$day->getTimestamp()).'%\'');
			return $eventdatetime->find();
		}
	}
	
}

?>