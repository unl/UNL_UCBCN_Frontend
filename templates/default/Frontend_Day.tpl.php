<div class="day_cal">
<h4 class="sec_main">
<?php
$day = new Calendar_Day($this->year,$this->month,$this->day);
echo date('l, F jS',$day->getTimeStamp());
?>
</h4>
<?php
	UNL_UCBCN::displayRegion($this->output);
	echo '<p id="feeds">
			<a id="icsformat" title="ics format for events on '.date('l, F jS',$day->getTimeStamp()).'" href="'.UNL_UCBCN_Frontend::reformatURL($this->url,array('format'=>'ics')).'">ics format for events on '.date('l, F jS',$day->getTimeStamp()).'</a>
			<a id="rssformat" title="rss format for events on '.date('l, F jS',$day->getTimeStamp()).'" href="'.UNL_UCBCN_Frontend::reformatURL($this->url,array('format'=>'rss')).'">rss format for events on '.date('l, F jS',$day->getTimeStamp()).'</a>
			</p>'; ?>
</div>