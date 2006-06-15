<?php
/**
 * This class is for the frontend view for an entire year.
 * 
 * It contains basically 4 rows of 3 months, for a total of 12
 * monthwidgets.
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */
class UNL_UCBCN_Frontend_Year extends UNL_UCBCN
{
	public $year;
	public $monthwidgets = array();
	
	function __construct($y)
	{
		$this->year = $y;
		$m = 1;
		for ($m=1;$m<=12;$m++) {
			$this->monthwidgets[] = new UNL_UCBCN_Frontend_MonthWidget($this->year,$m);
		}
	}
}
?>