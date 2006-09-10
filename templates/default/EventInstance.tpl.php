<div class="event_cal">
<div class='vcalendar'>
	<div class='vevent'>
		<h1 class='eventtitle'><?php echo UNL_UCBCN_Frontend::dbStringToHtml($this->event->title); ?></h1>
		<?php if (isset($this->event->subtitle)) echo '<h2>'.UNL_UCBCN_Frontend::dbStringToHtml($this->event->subtitle).'</h2>'; ?>
<div id="tabsG">
  <ul>
    <li><a href="#" id="event_selected" title="Event Detail"><span>Event Detail</span></a></li>

  </ul>
</div>
			<table>
				<thead>
				<tr>
<th scope="col" class="date">Event Detail</th>

</tr>
				</thead>
		<tbody>
			<tr><td class="date">Date:</td>
				<td><?php echo date('l, F jS',strtotime($this->eventdatetime->starttime)); ?></td></tr>
				
				<tr class="alt"><td class="date">Time:</td>	
					<td><?php
					if (isset($this->eventdatetime->starttime)) {
						if (strpos($this->eventdatetime->starttime,'00:00:00')) {
							echo '<abbr class="dtstart" title="'.date(DATE_ISO8601,strtotime($this->eventdatetime->starttime)).'">All day</abbr>';
						} else {
				        	echo '<abbr class="dtstart" title="'.date(DATE_ISO8601,strtotime($this->eventdatetime->starttime)).'">'.date('g:i a',strtotime($this->eventdatetime->starttime)).'</abbr>';
						}
				    } else {
				        echo 'Unknown';
				    }
				    if (isset($this->eventdatetime->endtime) &&
				    	($this->eventdatetime->endtime != $this->eventdatetime->starttime) &&
				    	($this->eventdatetime->endtime > $this->eventdatetime->starttime)) {
				    	echo '-<abbr class="dtend" title="'.date(DATE_ISO8601,strtotime($this->eventdatetime->endtime)).'">'.date('g:i a',strtotime($this->eventdatetime->endtime)).'</abbr>';
				    }
					?></td></tr>
			
			<tr><td class="date">Description:</td>	
			<td><p class='summary'><?php echo UNL_UCBCN_Frontend::dbStringToHtml($this->event->description); ?></p>
			<?php if (isset($this->event->listingcontactname) ||
						isset($this->event->listingcontactphone) ||
						isset($this->event->listingcontactemail)) { ?>
		
				Contact information:
				<?php if (isset($this->event->listingcontactname)) echo '<div class="n">'.$this->event->listingcontactname.'</div>'; ?>
				<?php if (isset($this->event->listingcontactphone)) echo '<div class="tel">'.$this->event->listingcontactphone.'</div>'; ?>
				<?php if (isset($this->event->listingcontactemail)) echo '<div class="mailto">'.$this->event->listingcontactemail.'</div>'; ?>
		
			<?php } ?></td></tr>
		
		<tr class="alt"><td class="date">Location:</td>
		<td>
			<?php
			$loc = $this->eventdatetime->getLink('location_id');
			if (!PEAR::isError($loc)) {
				echo '<div class="location">'.UNL_UCBCN_Frontend::dbStringToHtml($loc->name).'</div>';
			}
			?></td></tr>
			</tbody>

</table>
		</div>
		
	</div>
</div>