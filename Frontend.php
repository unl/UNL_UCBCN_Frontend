<?php
/**
 * This is the primary viewing interface for the events.
 * This would be the 'model' if you follow that paradigm.
 * 
 * This file contains functions used throughout the frontend views.
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */
require_once 'UNL/UCBCN.php';

class UNL_UCBCN_Frontend extends UNL_UCBCN
{
	
	var $navigation;
	var $output;
	
	function showCalendar($date='')
	{
		require 'Date.php';
		if (empty($date)) {
			$date = time();
		}
		$d = new Date_Calc();
		$savant = $this->getSavant();
		for ($i=1;$i<=$d->daysInMonth(date('n',$date));$i++) {
			$savant->days[$i] = $this->getEventList(date('Y-m-').$i);
		}
		$savant->display('showCalendar.php');
	}
	
	function showEvent($id)
	{
		$event = DB_DataObject::factory('Event');
		if ($event->get($id)) {
			$this->displayRegion($event);
		} else {
			$this->showError('The event with id of '.$id.' was not found.');
		}
	}
}
?>