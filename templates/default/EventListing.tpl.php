<table>
<thead>
<tr>
<th scope="col" class="date"><a href="<?php echo $GLOBALS['_UNL_UCBCN']['uri']; ?>?orderby=starttime">Time</a></th>
<th scope="col" class="title"><a href="<?php echo $GLOBALS['_UNL_UCBCN']['uri']; ?>?orderby=title">Event Title</a></th>
</tr>
</thead>
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
			$row .= '<abbr class="dtstart" title="'.date(DATE_ISO8601,strtotime($e->eventdatetime->starttime)).'">All day</abbr>';
		} else {
        	$row .= '<abbr class="dtstart" title="'.date(DATE_ISO8601,strtotime($e->eventdatetime->starttime)).'">'.date('g:i a',strtotime($e->eventdatetime->starttime)).'</abbr>';
		}
    } else {
        $row .= 'Unknown';
    }
    if (isset($e->eventdatetime->endtime) &&
    	($e->eventdatetime->endtime != $e->eventdatetime->starttime) &&
    	($e->eventdatetime->endtime > $e->eventdatetime->starttime)) {
    	$row .= '-<abbr class="dtend" title="'.date(DATE_ISO8601,strtotime($e->eventdatetime->endtime)).'">'.date('g:i a',strtotime($e->eventdatetime->endtime)).'</abbr>';
    }
	$row .= '</td>' .
			'<td><a class="url eventtitle" href="'.$e->getURL().'">'.UNL_UCBCN_Frontend::dbStringToHtml($e->event->title).'</a>' .
					'<blockquote class="summary">'.UNL_UCBCN_Frontend::dbStringToHtml($e->event->description).'</blockquote></td>' .
			'</tr>';
	echo $row;
} ?>
</tbody>
</table>