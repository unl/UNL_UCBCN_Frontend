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
foreach ($context as $occurrence) {
    
    $startu = strtotime($occurrence->starttime);
    $endu = strtotime($occurrence->endtime);
    
    $row = '<tr class="vevent';
    if ($oddrow) {
        $row .= ' alt';
    }
    $row .= '">';
    $oddrow = !$oddrow;
    $row .=    '<td class="date">';
    if (isset($occurrence->starttime)) {
        if (strpos($occurrence->starttime,'00:00:00')) {
            $row .= '<abbr class="dtstart" title="'.date('c', $startu).'">All day</abbr>';
        } else {
            $row .= '<abbr class="dtstart" title="'.date('c', $startu).'">'.date('g:i a', $startu).'</abbr>';
        }
    } else {
        $row .= 'Unknown';
    }
    if (isset($occurrence->endtime) &&
        ($occurrence->endtime != $occurrence->starttime) &&
        ($occurrence->endtime > $occurrence->starttime)) {
        if (substr($occurrence->endtime,0,10) != substr($occurrence->starttime,0,10)) {
            // Not on the same day
            if (strpos($occurrence->endtime,'00:00:00')) {
                $row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('M jS', $endu).'</abbr>';
            } else {
                $row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('M jS g:i a', $endu).'</abbr>';
            }
        } else {
            $row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('g:i a', $endu).'</abbr>';
        }
    }
    $row .= '</td>' .
            '<td><a class="url summary" href="'.$savvy->dbStringtoHtml($occurrence->getURL()).'">'.$savvy->dbStringtoHtml($occurrence->getEvent()->title).'</a>';
    if (isset($occurrence->location_id) && $occurrence->location_id) {
        $l = $occurrence->getLocation();
        $row .= ' <span class="location">';
        if (isset($l->mapurl)) {
            $row .= '<a class="mapurl" href="'.$savvy->dbStringtoHtml($l->mapurl).'">'.$savvy->dbStringtoHtml($l->name).'</a>';
        } else {
            $row .= $savvy->dbStringtoHtml($l->name);
        }
        $row .= '</span>';
    }
    $row .=    '<blockquote class="description">'.$savvy->dbStringtoHtml($occurrence->getEvent()->description).'</blockquote>';
//     $facebook = new \UNL\UCBCN\Facebook\Instance($occurrence->id);
//     $row .= $facebook->like($occurrence->getURL(), $parent->context->getCalendar()->id);
    $row .= '</td></tr>';
    
    echo $row;
}

 ?>

</tbody>
</table>

