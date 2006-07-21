<div class="day_cal">
<h2 class="sec_main">
<?php
$day = new Calendar_Day($this->year,$this->month,$this->day);
echo date('l, F jS',$day->getTimeStamp());
?>
</h2>
<?php
	UNL_UCBCN::displayRegion($this->output);
?>
</div>