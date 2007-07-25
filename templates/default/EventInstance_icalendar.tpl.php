<?php
/**
 * icalendar output for a single vent instance.
 */

$startu = strtotime($this->eventdatetime->starttime);
$endu = strtotime($this->eventdatetime->endtime);

$out = array();
$out[] = 'BEGIN:VEVENT';
//$out[] = 'SEQUENCE:5';
if (isset($this->eventdatetime->starttime)) {
	if (strpos($this->eventdatetime->starttime,'00:00:00')) {
		$out[] = 'DTSTART;TZID=US/Central:'.date('Ymd', $startu);
	} else {
       	$out[] = 'DTSTART;TZID=US/Central:'.date('Ymd\THis', $startu);
	}
   }
   $out[] = 'UID:'.$this->eventdatetime->id;
$out[] = 'DTSTAMP:'.date('Ymd\THis',strtotime($this->event->datecreated));
$out[] = 'SUMMARY:'.strip_tags($this->event->title);
$out[] = 'DESCRIPTION:'.strip_tags($this->event->description);
if (isset($this->eventdatetime->location_id) && $this->eventdatetime->location_id) {
    $l = $this->eventdatetime->getLink('location_id');
    $loc =  'LOCATION:'.$l->name;
    if (isset($this->eventdatetime->room)) {
		$loc .=  ' Room '.$this->eventdatetime->room;
	}
    $out[] = $loc;
}
$out[] = 'URL:'.UNL_UCBCN_Frontend::reformatURL($this->url,array('format'=>'ics'));
//$out[] = 'UID:EC9439B1-FF65-11D6-9973-003065F99D04';
if (isset($this->eventdatetime->endtime)) {
	if (strpos($this->eventdatetime->endtime,'00:00:00')) {
		$out[] = 'DTEND;TZID=US/Central:'.date('Ymd', $endu);
	} else {
   		$out[] = 'DTEND;TZID=US/Central:'.date('Ymd\THis', $endu);
	}
   }
$out[] = 'END:VEVENT';
echo implode("\n",$out)."\n";
?>