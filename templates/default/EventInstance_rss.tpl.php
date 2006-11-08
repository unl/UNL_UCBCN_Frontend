<item>
	<title><?php echo UNL_UCBCN_Frontend::dbStringToHtml($this->event->title); ?></title>
	<link><?php echo $this->url; ?></link>
	<description>
		<?php
		echo '&lt;h1&gt;'.UNL_UCBCN_Frontend::dbStringToHtml($this->event->description).'&lt;/h1&gt;';
		if (isset($this->event->subtitle)) echo '&lt;h2&gt;'.UNL_UCBCN_Frontend::dbStringToHtml($this->event->subtitle).'&lt;/h2&gt;';
		echo date('l, F jS',strtotime($this->eventdatetime->starttime));
		
		if (isset($this->eventdatetime->starttime)) {
			if (strpos($this->eventdatetime->starttime,'00:00:00')) {
				echo '&lt;abbr class="dtstart" title="'.date(DATE_ISO8601,strtotime($this->eventdatetime->starttime)).'"&gt;All day&lt;/abbr&gt;';
			} else {
	        	echo '&lt;abbr class="dtstart" title="'.date(DATE_ISO8601,strtotime($this->eventdatetime->starttime)).'"&gt;'.date('g:i a',strtotime($this->eventdatetime->starttime)).'&lt;/abbr&gt;';
			}
	    } else {
	        echo 'Unknown';
	    }
	    if (isset($this->eventdatetime->endtime) &&
	    	($this->eventdatetime->endtime != $this->eventdatetime->starttime) &&
	    	($this->eventdatetime->endtime > $this->eventdatetime->starttime)) {
	    	echo '-&lt;abbr class="dtend" title="'.date(DATE_ISO8601,strtotime($this->eventdatetime->endtime)).'"&gt;'.date('g:i a',strtotime($this->eventdatetime->endtime)).'&lt;/abbr&gt;';
	    }
		$loc = $this->eventdatetime->getLink('location_id');
		if (!PEAR::isError($loc)) {
			echo '&lt;div class="location"&gt;'.UNL_UCBCN_Frontend::dbStringToHtml($loc->name);
			if (isset($this->eventdatetime->room)) {
			    echo ' Room:'.UNL_UCBCN_Frontend::dbStringToHtml($this->eventdatetime->room);
			}
			echo '&lt;/div&gt;';
		} ?>
	</description>
	<pubDate><?php echo date('r',strtotime($this->event->datecreated)); ?></pubDate>
	<guid><?php echo $this->url; ?></guid>
</item>
