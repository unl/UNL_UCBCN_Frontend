<table>
<thead>
<tr>
<th scope="col" class="date"><a href="?orderby=starttime">Time</a></th>
<th scope="col" class="title"><a href="?orderby=title">Event Title</a></th>
</tr>
</thead>
<tfoot></tfoot>
<tbody class="vcalendar">
<?php
$oddrow = false;
foreach ($this->events as $e) {
	$row = '<tr class="vevent';
	if ($oddrow) {
		$row .= ' alt';
	}
	$row .= '">';
	$oddrow = !$oddrow;
	$row .=	'<td class="date">';
	if (isset($e->eventdatetime->starttime)) {
		if (strpos($e->eventdatetime->starttime,'00:00:00')) {
			$row .= '<span class="dtstart">All day</span>';
		} else {
        	$row .= '<abbr class="dtstart" title="'.date(DATE_ISO8601,strtotime($e->eventdatetime->starttime)).'">'.date('g:i a',strtotime($e->eventdatetime->starttime)).'</abbr>';
		}
    } else {
        $row .= 'Unknown';
    }
    if (isset($e->eventdatetime->endtime) && ($e->eventdatetime->endtime != $e->eventdatetime->starttime)) {
    	$row .= '<abbr class="dtend" title="'.date(DATE_ISO8601,strtotime($e->eventdatetime->endtime)).'">'.date('g:i a',strtotime($e->eventdatetime->endtime)).'</abbr>';
    }
	$row .= '</td>' .
			'<td><a class="url title" href="'.$e->getURL().'">'.$e->event->title.'</a>' .
					'<blockquote class="summary">'.$e->event->description.'</blockquote></td>' .
			'</tr>';
	echo $row;
} ?>
</tbody>
</table>