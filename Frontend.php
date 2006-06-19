<?php
/**
 * This is the primary viewing interface for the events.
 * This would be the 'model/controller' if you follow that paradigm.
 * 
 * This file contains functions used throughout the frontend views.
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */
require_once 'UNL/UCBCN.php';
require_once 'UNL/UCBCN/EventInstance.php';
require_once 'UNL/UCBCN/Frontend/Day.php';
require_once 'UNL/UCBCN/Frontend/Month.php';
require_once 'UNL/UCBCN/Frontend/Year.php';
require_once 'Date.php';

class UNL_UCBCN_Frontend extends UNL_UCBCN
{
	/** Calendar UNL_UCBCN_Calendar Object **/
	var $calendar;
	/** Year the user is viewing. */
	var $year;
	/** Month the user is viewing. */
	var $month;
	/** Day to show events for */
	var $day;
	/** Navigation */
	public $navigation;
	/** Right column (usually the month widget) */
	public $right;
	/** Unique body ID */
	public $uniquebody;
	/** Main content of the page sent to the client. */
	public $output;
	/** Page Title */
	public $doctitle;
	/** Section Title */
	public $sectitle;
	
	function __construct($options)
	{
		parent::__construct($options);
		$this->navigation = $this->showNavigation();
	}
	
	function showNavigation()
	{
		$n = array();
		$n[] = '<ul>';
		$n[] = '<li><a href="?">Today\'s Events</a></li>';
		$n[] = '</ul>';
		return implode("\n",$n);
	}
	
	function run($view='')
	{
		switch($view) {
			case 'event':
				if (isset($_GET['id'])) {
					$id = $_GET['id'];
				}
				$this->output = $this->getEventInstance($id);
			break;
			case 'day':
				$this->output = new UNL_UCBCN_Frontend_Day(array(
											'dsn'		=> $this->dsn,
											'year'		=> $this->year,
											'month'		=> $this->month,
											'day'		=> $this->day));
			break;
			case 'month':
				$this->output = new UNL_UCBCN_Frontend_Month($this->year,$this->month);
			break;
			case 'year':
				$this->output = new UNL_UCBCN_Frontend_Year($this->year);
			break;
		}
		$this->right = new UNL_UCBCN_Frontend_MonthWidget($this->year,$this->month);
	}
	
	/**
	 * Gets the specified event instance.
	 * 
	 * @param int id
	 * @return object UNL_UCBCN_EventInstance on success UNL_UCBCN_Error on error.
	 */
	function getEventInstance($id)
	{
		return new UNL_UCBCN_EventInstance($id);
	}
}
?>