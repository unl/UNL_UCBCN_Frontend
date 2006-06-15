
<h3 id="sec_main">
<?php
$day = new Calendar_Day($this->year,$this->month,$this->day);
echo date('l, F jS',$day->getTimeStamp());
?>
</h3>
<?php
	UNL_UCBCN::displayRegion($this->output);
?>
