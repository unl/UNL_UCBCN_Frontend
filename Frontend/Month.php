<?php

/**
 * This class contains the information needed for viewing a month view calendar.
 * 
 */

require_once 'UNL/UCBCN/Frontend.php';

class UNL_UCBCN_Frontend_Month extends UNL_UCBCN_Frontend
{
	/** Year the user is viewing. */
	var $year;
	/** Month the user is viewing. */
	var $month;
	/** array of days */
	var $days = array();
	
	
	
}

?>