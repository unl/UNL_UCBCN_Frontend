<?php

/**
 * This class defines a 30 day widget containing information for a given month.
 * 
 * 
 * @package UNL_UCBCN_Frontend
 * @author bbieber
 */

require_once 'UNL/UCBCN.php';
require_once 'UNL/UCBCN/Frontend.php';
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
		$this->year = intval($y);
		$this->month = intval($m);
		$this->calendar = $calendar;
	}
	
	/**
	 * Returns a string identifying this month widget.
	 *
	 * @return string A string of the form monthwidget_2006-05_1
	 */
	function getCacheKey()
	{
	    $str = 'monthwidget_'.$this->year.'-'.$this->month;
	    if (isset($this->calendar)) {
	        $str .= '_'.$this->calendar->id;
	    }
	    return $str;
	}
	
	function preRun($cache_hit)
	{
	    // Do stuff here if needed.
	}
	
	/**
	 * This function populates the month widget... checks for each 
	 * day of this month whether the day has events.
	 *
	 */
	function run()
	{
	    $Month = new Calendar_Month_Weekdays($this->year, $this->month, 0);
		$PMonth = $Month->prevMonth('object'); // Get previous month as object
		$prev = UNL_UCBCN_Frontend::formatURL(array(	'y'=>$PMonth->thisYear(),
														'm'=>$PMonth->thisMonth(),
														'calendar'=>$this->calendar->id));
		$NMonth = $Month->nextMonth('object');
		$next = UNL_UCBCN_Frontend::formatURL(array(	'y'=>$NMonth->thisYear(),
														'm'=>$NMonth->thisMonth(),
														'calendar'=>$this->calendar->id));
		
		$this->caption = '
		<span><a href="'.$prev.'" id="prev_month" title="View events for '.Calendar_Util_Textual::thisMonthName($PMonth).' '.$PMonth->thisYear().'">&lt;&lt; </a></span>
		<span class="monthvalue" id="'.Calendar_Util_Textual::thisMonthName($Month).'"><a href="'.
						UNL_UCBCN_Frontend::formatURL(array(	'y'=>$Month->thisYear(),
																'm'=>$Month->thisMonth(),
																'calendar'=>$this->calendar->id)).'">'.Calendar_Util_Textual::thisMonthName($Month).'</a></span>
		<span class="yearvalue"><a href="'.
						UNL_UCBCN_Frontend::formatURL(array(	'y'=>$Month->thisYear(),
																'calendar'=>$this->calendar->id)).'">'.$Month->thisYear().'</a></span>
		<span><a href="'.$next.'" id="next_month" title="View events for '.Calendar_Util_Textual::thisMonthName($NMonth).' '.$NMonth->thisYear().'"> &gt;&gt;</a></span>
		';

		//Determine selected days
		$selectedDays = array();
		$Month->build($selectedDays);
		
		while ( $Day = $Month->fetch() ) {
	
	    	// Build a link string for each day
			$link = UNL_UCBCN_Frontend::formatURL(array(	'y'=>$Day->thisYear(),
															'm'=>$Day->thisMonth(),
															'd'=>$Day->thisDay(),
															'calendar'=>$this->calendar->id));
			
			$class = '';
		    if ($Day->thisMonth('timestamp')<$Month->getTimestamp()) {
		        $class = 'prev';
		    } elseif ($Day->thisMonth('timestamp')>$Month->getTimestamp()) {
		        $class = 'next';
		    }
			
			// isFirst() to find start of week
			if ( $Day->isFirst() )
				$this->tbody .= "<tr>\n";
			if ( UNL_UCBCN_Frontend::dayHasEvents($Day->getTimestamp(),$this->calendar) ) {
				$this->tbody .= "<td class='selected {$class}'><a href='$link'>".$Day->thisDay()."</a></td>\n";
			} else if ( $Day->isEmpty() ) {
				$this->tbody .= "<td class='{$class}'>".$Day->thisDay()."</td>\n";
			} else {
				$this->tbody .= "<td class='{$class}'>".$Day->thisDay()."</td>\n";
			}
			
			// isLast() to find end of week
			if ( $Day->isLast() )
				$this->tbody .= "</tr>\n";
		}
	}
	
}

?>