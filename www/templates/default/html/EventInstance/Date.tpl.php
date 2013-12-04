<?php
//Convert the times to something we can use.
$startu = strtotime($context->eventdatetime->starttime);
$endu = strtotime($context->eventdatetime->endtime);

//get the start time
if (isset($context->eventdatetime->starttime)) {
    echo '<abbr class="dtstart" title="'.date('c', $startu).'">';
    if ($context->isAllDay()) {
        echo 'All day';
    } else {
        echo date('g:i a', $startu);
    }
    echo '</abbr>';
} else {
    echo 'Unknown';
}

//get the end time
if (isset($context->eventdatetime->endtime) &&
    ($context->eventdatetime->endtime != $context->eventdatetime->starttime) &&
    ($context->eventdatetime->endtime > $context->eventdatetime->starttime)) {

    echo '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">';
    if ($context->isOngoing()) {
        if (strpos($context->eventdatetime->endtime,'00:00:00')) {
            echo date('M jS', $endu);
        } else {
            echo date('M jS g:i a', $endu);
        }
    } else {
        echo date('g:i a', $endu);
    }
    echo '</abbr>';
}