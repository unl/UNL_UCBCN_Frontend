<div class='vcalendar'>
	<div class='vevent'>
		<h1 class='title'><?php echo UNL_UCBCN_Frontend::dbStringToHtml($this->event->title); ?></h1>
		<?php if (isset($this->event->subtitle)) echo '<h2>'.UNL_UCBCN_Frontend::dbStringToHtml($this->event->subtitle).'</h2>'; ?>
		<div class='two_col left'>
			<div class='date'>
				<h2><?php echo date('l, F jS',strtotime($this->eventdatetime->starttime)); ?></h2>
				<h3>
					<?php
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
					?>
				</h3>
			</div>
			<p class='summary'><?php echo UNL_UCBCN_Frontend::dbStringToHtml($this->event->description); ?></p>
			<?php if (isset($this->event->listingcontactname) ||
						isset($this->event->listingcontactphone) ||
						isset($this->event->listingcontactemail)) { ?>
			<div class='organizer'>
				Contact information:
				<?php if (isset($this->event->listingcontactname)) echo '<div class="n">'.$this->event->listingcontactname.'</div>'; ?>
				<?php if (isset($this->event->listingcontactphone)) echo '<div class="tel">'.$this->event->listingcontactphone.'</div>'; ?>
				<?php if (isset($this->event->listingcontactemail)) echo '<div class="mailto">'.$this->event->listingcontactemail.'</div>'; ?>
			</div>
			<?php } ?>
		</div>
		<div class='col right'>
			Location:
			<?php
			$loc = $this->eventdatetime->getLink('location_id');
			if (!PEAR::isError($loc)) {
				echo '<div class="location">'.UNL_UCBCN_Frontend::dbStringToHtml($loc->name).'</div>';
			}
			?>
		</div>
	</div>
</div>