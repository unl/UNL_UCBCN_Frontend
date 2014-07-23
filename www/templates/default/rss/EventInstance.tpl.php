<?php
$startu = strtotime($context->eventdatetime->starttime);
$endu = strtotime($context->eventdatetime->endtime);
?>
<item>
	<title><?php echo htmlspecialchars($savvy->dbStringtoHtml($context->event->title)); ?></title>
	<link><?php echo $context->getURL(); ?></link>
	<description>
		<?php
		echo '&lt;div&gt;'.htmlspecialchars($savvy->dbStringtoHtml(strip_tags($context->event->description))).'&lt;/div&gt;';
		if (isset($context->event->subtitle)) echo '&lt;div&gt;'.htmlspecialchars($savvy->dbStringtoHtml($context->event->subtitle)).'&lt;/div&gt;';
		echo '&lt;small&gt;'.date('l, F jS', $startu).'&lt;/small&gt;';
		
		if (isset($context->eventdatetime->starttime)) {
			if (strpos($context->eventdatetime->starttime,'00:00:00')) {
				echo ' | &lt;small&gt;&lt;abbr class="dtstart" title="'.date(DATE_ISO8601, $startu).'"&gt;All day&lt;/abbr&gt;&lt;/small&gt;';
			} else {
	        	echo ' | &lt;small&gt;&lt;abbr class="dtstart" title="'.date(DATE_ISO8601, $startu).'"&gt;'.date('g:i a', $startu).'&lt;/abbr&gt;&lt;/small&gt;';
			}
	    } else {
	        echo 'Unknown';
	    }
	    if (isset($context->eventdatetime->endtime) &&
	    	($context->eventdatetime->endtime != $context->eventdatetime->starttime) &&
	    	($context->eventdatetime->endtime > $context->eventdatetime->starttime)) {
	    	echo '-&lt;small&gt;&lt;abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'"&gt;'.date('g:i a', $endu).'&lt;/abbr&gt;&lt;/small&gt;';
	    }
		if ($context->eventdatetime->location_id) {
		    $loc = $context->eventdatetime->getLocation();
			echo ' | &lt;small&gt;'.$savvy->dbStringtoHtml($loc->name);
			if (isset($context->eventdatetime->room)) {
			    echo ' Room:'.$savvy->dbStringtoHtml($context->eventdatetime->room);
			}
			echo '&lt;/small&gt;';
		} ?>
	</description>
	<pubDate><?php echo date('r',strtotime($context->event->datecreated)); ?></pubDate>
	<guid><?php echo $context->getURL(); ?></guid>
</item>
