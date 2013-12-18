<?php
/**
 * icalendar output for a single vent instance.
 */

$startu = strtotime($context->eventdatetime->starttime);
$endu = strtotime($context->eventdatetime->endtime);

$out = array();
$out[] = 'BEGIN:VEVENT';
//$out[] = 'SEQUENCE:5';
if (isset($context->eventdatetime->starttime)) {
    if (strpos($context->eventdatetime->starttime,'00:00:00')) {
        $out[] = 'DTSTART;VALUE=DATE:'.date('Ymd', $startu);
    } else {
           $out[] = 'DTSTART;TZID=America/Chicago:'.date('Ymd\THis', $startu);
    }
}
$out[] = 'UID:'.$context->eventdatetime->id.'@'.$_SERVER['SERVER_NAME'];
$out[] = 'DTSTAMP:'.date('Ymd\THis',strtotime($context->event->datecreated));
$out[] = 'SUMMARY:'.strip_tags($context->event->title);
$out[] = 'DESCRIPTION:'.preg_replace("/\r\n|\n|\r/", '\n', strip_tags($context->event->description));
if (isset($context->eventdatetime->location_id) && $context->eventdatetime->location_id) {
    $l = $context->eventdatetime->getLocation();
    $loc =  'LOCATION:'.$l->name;
    if (isset($context->eventdatetime->room)) {
        $loc .=  ' Room '.$context->eventdatetime->room;
    }
    $out[] = $loc;
}
$out[] = 'URL:'.$context->getURL();
if (isset($context->eventdatetime->endtime)
    && $endu > $startu) {
    if (strpos($context->eventdatetime->endtime,'00:00:00')) {
        $out[] = 'DTEND;VALUE=DATE:'.date('Ymd', $endu);
    } else {
           $out[] = 'DTEND;TZID=America/Chicago:'.date('Ymd\THis', $endu);
    }
} elseif (isset($context->eventdatetime->starttime)) {
    if (strpos($context->eventdatetime->starttime,'00:00:00')) {
        // All-day event
        $out[] = 'DTEND;VALUE=DATE:'.date('Ymd', $startu + 86400);
    } else {
        // Event with unknown end-time
        $out[] = 'DTEND;TZID=America/Chicago:'.date('Ymd\THis', $startu);
    }
}
$out[] = 'END:VEVENT';
echo implode("\n",$out)."\n";
?>
