<?php if ($this->type == 'ongoing') {
    echo '<h4 class="'.$this->type.'">Ongoing Events:</h4>';
} ?>
<table class='<?php echo $this->type; ?>'>
<thead>
<tr>
<th scope="col" class="date">Time</th>
<th scope="col" class="title">Event Title</th>
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
	if ($this->type == 'ongoing') {
	    $row .= '<abbr class="dtstart" title="'.date('c',strtotime($e->eventdatetime->starttime)).'">'.date('M jS',strtotime($e->eventdatetime->starttime)).'</abbr>';
	    $row .= '-<abbr class="dtend" title="'.date('c',strtotime($e->eventdatetime->endtime)).'">'.date('M jS',strtotime($e->eventdatetime->endtime)).'</abbr>';
	} elseif ($this->type == 'upcoming' || $this->type == 'search') {
		if (strpos($e->eventdatetime->starttime,'00:00:00')) {
			$row .= '<abbr class="dtstart" title="'.date('c',strtotime($e->eventdatetime->starttime)).'">'.date('M jS',strtotime($e->eventdatetime->starttime)).'</abbr>';
		} else {
        	$row .= '<abbr class="dtstart" title="'.date('c',strtotime($e->eventdatetime->starttime)).'">'.date('g:i a M jS',strtotime($e->eventdatetime->starttime)).'</abbr>';
		}
	} else {
		if (isset($e->eventdatetime->starttime)) {
			if (strpos($e->eventdatetime->starttime,'00:00:00')) {
				$row .= '<abbr class="dtstart" title="'.date('c',strtotime($e->eventdatetime->starttime)).'">All day</abbr>';
			} else {
	        	$row .= '<abbr class="dtstart" title="'.date('c',strtotime($e->eventdatetime->starttime)).'">'.date('g:i a',strtotime($e->eventdatetime->starttime)).'</abbr>';
			}
	    } else {
	        $row .= 'Unknown';
	    }
	    if (isset($e->eventdatetime->endtime) &&
	    	($e->eventdatetime->endtime != $e->eventdatetime->starttime) &&
	    	($e->eventdatetime->endtime > $e->eventdatetime->starttime)) {
	    	$row .= '-<abbr class="dtend" title="'.date('c',strtotime($e->eventdatetime->endtime)).'">'.date('g:i a',strtotime($e->eventdatetime->endtime)).'</abbr>';
	    }
	}
	$row .= '</td>' .
			'<td><a class="url summary" href="'.$e->url.'">'.UNL_UCBCN_Frontend::dbStringToHtml($e->event->title).'</a>';
	if (isset($e->eventdatetime->location_id)) {
	    $l = $e->eventdatetime->getLink('location_id');
	    $row .= ' <span class="location">'.$l->name.'</span>';
	}
	if ($this->type != 'ongoing') {
	    $row .=	'<blockquote class="description">'.UNL_UCBCN_Frontend::dbStringToHtml($e->event->description).'</blockquote>';
	}
	$row .= '</td></tr>';
	
	echo $row;
}

 ?>

</tbody>
</table>

