<table>
<thead>
<tr>
<th scope="col" class="date">Time</th>
<th scope="col" class="title">Event Title</th>
</tr>
</thead>
<tbody class="vcalendar">
<?php
$oddrow = false;
foreach ($context as $eventinstance) {
    //Convert the times to something we can use.
    $startu = strtotime($eventinstance->eventdatetime->starttime);
    $endu = strtotime($eventinstance->eventdatetime->endtime);

    //Start building an array of row classes
    $row_classes = array('vevent');

    if ($oddrow) {
        //Add an alt class to odd rows
        $row_classes[] = 'alt';
    }

    //Invert oddrow
    $oddrow = !$oddrow;
    
    $row = '<tr class="' . implode(' ', $row_classes) . '">';
    
    $row .= '<td class="date">';
    
    //get the start time
    if (isset($eventinstance->eventdatetime->starttime)) {
        $row .= '<abbr class="dtstart" title="'.date('c', $startu).'">';
        if ($eventinstance->isAllDay()) {
            $row .= 'All day';
        } else {
            $row .= date('g:i a', $startu);
        }
        $row .= '</abbr>';
    } else {
        $row .= 'Unknown';
    }
    
    //get the end time
    if (isset($eventinstance->eventdatetime->endtime) &&
        ($eventinstance->eventdatetime->endtime != $eventinstance->eventdatetime->starttime) &&
        ($eventinstance->eventdatetime->endtime > $eventinstance->eventdatetime->starttime)) {
        
        if ($eventinstance->isOngoing()) {
            if (strpos($eventinstance->eventdatetime->endtime,'00:00:00')) {
                $row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('M jS', $endu).'</abbr>';
            } else {
                $row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('M jS g:i a', $endu).'</abbr>';
            }
        } else {
            $row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('g:i a', $endu).'</abbr>';
        }
    }
    
    $row .= '</td>' .
            '<td><a class="url summary" href="'.$frontend->getEventURL($eventinstance->getRawObject()).'">'.$savvy->dbStringtoHtml($eventinstance->event->title).'</a>';
    if (isset($eventinstance->eventdatetime->location_id) && $eventinstance->eventdatetime->location_id) {
        $l = $eventinstance->eventdatetime->getLocation();
        $row .= ' <span class="location">';
        if (isset($l->mapurl)) {
            $row .= '<a class="mapurl" href="'.$savvy->dbStringtoHtml($l->mapurl).'">'.$savvy->dbStringtoHtml($l->name).'</a>';
        } else {
            $row .= $savvy->dbStringtoHtml($l->name);
        }
        $row .= '</span>';
    }
    $row .=    '<blockquote class="description">'.$savvy->dbStringtoHtml($eventinstance->event->description).'</blockquote>';

    $row .= '</td></tr>';
    
    echo $row;
}

 ?>
</tbody>
</table>

