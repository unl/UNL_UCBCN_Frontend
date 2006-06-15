<table>
<thead>
<tr>
<th scope="col" class="date"><a href="?orderby=starttime">Time</a></th>
<th scope="col" class="title"><a href="?orderby=title">Event Title</a></th>
</tr>
</thead>
<tfoot></tfoot>
<tbody>
<?php
$oddrow = false;
foreach ($this->events as $e) {
	$eventdatetime = $e->getLink('id','eventdatetime','event_id');
	$row = '<tr';
	if ($oddrow) {
		$row .= ' class="alt"';
	}
	$row .= '>';
	$oddrow = !$oddrow;
	$row .=	'<td class="date">';
	if (isset($eventdatetime->starttime)) {
            $row .= date('g:i a',strtotime($eventdatetime->starttime));
    } else {
            $row .= 'Unknown';
    }
	$row .= '</td>' .
			'<td class="title">'.$e->title.'</td>' .
			'</tr>';
	echo $row;
} ?>
</tbody>
</table>