<div class="day_cal">
<h4 class="sec_main">
<?php
$day = new Calendar_Day($this->year,$this->month,$this->day);
echo date('l, F jS',$day->getTimeStamp());
?>
</h4>
<?php
	UNL_UCBCN::displayRegion($this->output);
?>
<?php echo('<p id="feeds"><a id="icsformat" title="ics format for events on '.date('l, F jS',$day->getTimeStamp()).'" href="'.$this->url.'format=ics">ics format for events on '.date('l, F jS',$day->getTimeStamp()).'</a></p>'); ?>
</div>