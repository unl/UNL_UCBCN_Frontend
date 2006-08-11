<?php
/**
 * This is the output for an event listing in icalendar format.
 * @package UNL_UCBCN_Frontend
 */
foreach ($this->events as $e) {
	$out = array();
	$out[] = 'BEGIN:VEVENT';
	//$out[] = 'SEQUENCE:5';
	if (isset($e->eventdatetime->starttime)) {
		if (strpos($e->eventdatetime->starttime,'00:00:00')) {
			$out[] = 'DTSTART;TZID=US/Central:'.date('Ymd',strtotime($e->eventdatetime->starttime));
		} else {
        	$out[] = 'DTSTART;TZID=US/Central:'.date('Ymd\THis',strtotime($e->eventdatetime->starttime));
		}
    }
    $out[] = 'UID:'.$e->eventdatetime->id;
	$out[] = 'DTSTAMP:'.date('Ymd\THis',strtotime($e->event->datecreated));
	$out[] = 'SUMMARY:'.strip_tags($e->event->title);
	$out[] = 'DESCRIPTION:'.strip_tags($e->event->description);
	//$out[] = 'URL:http://abc.com/pub/calendars/jsmith/mytime.ics';
	//$out[] = 'UID:EC9439B1-FF65-11D6-9973-003065F99D04';
	if (isset($eventdatetime->endtime)) {
		if (strpos($e->eventdatetime->endtime,'00:00:00')) {
			$out[] = 'DTEND;TZID=US/Central:'.date('Ymd',strtotime($e->eventdatetime->endtime));
		} else {
    		$out[] = 'DTEND;TZID=US/Central:'.date('Ymd\THis',strtotime($e->eventdatetime->endtime));
		}
    }
	$out[] = 'END:VEVENT';
	echo implode("\n",$out)."\n";
} ?>