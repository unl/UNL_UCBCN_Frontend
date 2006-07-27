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
	$eventdatetime = $e->getLink('id','eventdatetime','event_id');
	$row = '<tr class="vevent';
	if ($oddrow) {
		$row .= ' alt';
	}
	$row .= '">';
	$oddrow = !$oddrow;
	$row .=	'<td class="date">';
	if (isset($eventdatetime->starttime)) {
            $row .= '<abbr class="dtstart" title="'.date(DATE_ISO8601,strtotime($eventdatetime->starttime)).'">'.date('g:i a',strtotime($eventdatetime->starttime)).'</abbr>';
    } else {
            $row .= 'Unknown';
    }
    if (isset($eventdatetime->endtime)) {
    	$row .= '<abbr class="dtend" title="'.date(DATE_ISO8601,strtotime($eventdatetime->endtime)).'">'.date('g:i a',strtotime($eventdatetime->endtime)).'</abbr>';
    }
	$row .= '</td>' .
			'<td><a class="url title" href="?id='.$eventdatetime->id.'">'.$e->title.'</a>' .
					'<blockquote class="summary">'.$e->description.'</blockquote></td>' .
			'</tr>';
	echo $row;
} ?>
</tbody>
</table>