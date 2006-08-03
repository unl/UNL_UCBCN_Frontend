<?php
/**
 * This is the output for an event listing in icalendar format.
 * @package UNL_UCBCN_Frontend
 */
foreach ($this->events as $e) {
	$eventdatetime = $e->getLink('id','eventdatetime','event_id');
	$out = array();
	$out[] = 'BEGIN:VEVENT';
	//$out[] = 'SEQUENCE:5';
	if (isset($eventdatetime->starttime)) {
        $out[] = 'DTSTART;TZID=US/Central:'.date('Ymd\THis',strtotime($eventdatetime->starttime));
    }
	//$out[] = 'DTSTAMP:20021028T011706Z';
	$out[] = 'SUMMARY:'.$e->title;
	$out[] = 'DESCRIPTION:'.$e->description;
	//$out[] = 'URL:http://abc.com/pub/calendars/jsmith/mytime.ics';
	//$out[] = 'UID:EC9439B1-FF65-11D6-9973-003065F99D04';
	if (isset($eventdatetime->endtime)) {
    	$out[] = 'DTEND;TZID=US/Central:'.date('Ymd\THis',strtotime($eventdatetime->endtime));
    }
	$out[] = 'END:VEVENT';
	echo implode("\n",$out);
} ?>