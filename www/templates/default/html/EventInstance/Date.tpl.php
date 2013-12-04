<?php
//Convert the times to something we can use.
$startu = strtotime($context->eventdatetime->starttime);
$endu = strtotime($context->eventdatetime->endtime);

$row = "";
//get the start time
if (isset($context->eventdatetime->starttime)) {
    $row = '<abbr class="dtstart" title="'.date('c', $startu).'">';
    if ($context->isAllDay()) {
        $row .= 'All day';
    } else {
        $row .= date('g:i a', $startu);
    }
    $row .= '</abbr>';
} else {
    $row .= 'Unknown';
}

//get the end time
if (isset($context->eventdatetime->endtime) &&
    ($context->eventdatetime->endtime != $context->eventdatetime->starttime) &&
    ($context->eventdatetime->endtime > $context->eventdatetime->starttime)) {

    if ($context->isOngoing()) {
        if (strpos($context->eventdatetime->endtime,'00:00:00')) {
            $row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('M jS', $endu).'</abbr>';
        } else {
            $row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('M jS g:i a', $endu).'</abbr>';
        }
    } else {
        $row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('g:i a', $endu).'</abbr>';
    }
}
echo $row;