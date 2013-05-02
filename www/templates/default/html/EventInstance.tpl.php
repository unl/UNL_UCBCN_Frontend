<?php

$startu = strtotime($context->eventdatetime->starttime);
$endu = strtotime($context->eventdatetime->endtime);

/*
 * 
 *  //Moved here temporarily, they'll need to get into the head some time
	echo '<meta property="og:title" content="'. $context->output[0]->event->title .'"/>
          <meta property="og:site_name" content="'. $context->calendar->name .'"/> 
          <meta property="og:url" content="'. UNL_UCBCN::getBaseURL().$context->output[0]->url .'"/>
          <meta property="og:description" content="'. $context->output[0]->event->description .'" />';
 */

?>
<div class="event_cal">
<div class='vcalendar'>
	<div class='vevent'>
		<h1 class='summary'><?php echo $savvy->dbStringtoHtml($context->event->title); ?> <a class="permalink" href="<?php echo $context->url; ?>">(link)</a></h1>
		<?php if (isset($context->event->subtitle)) echo '<h2>'.$savvy->dbStringtoHtml($context->event->subtitle).'</h2>'; ?>
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
		<tr>
			<td class="date">Date:</td>
			<td><?php echo date('l, F jS',$startu); ?></td>
		</tr>
		<tr class="alt"><td class="date">Time:</td>	
			<td><?php
			if (isset($context->eventdatetime->starttime)) {
				if (strpos($context->eventdatetime->starttime,'00:00:00')) {
					echo '<abbr class="dtstart" title="'.date(DATE_ISO8601, $startu).'">All day</abbr>';
				} else {
		        	echo '<abbr class="dtstart" title="'.date(DATE_ISO8601, $startu).'">'.date('g:i a', $startu).'</abbr>';
				}
		    } else {
		        echo 'Unknown';
		    }
		    if (isset($context->eventdatetime->endtime) &&
		    	($context->eventdatetime->endtime != $context->eventdatetime->starttime) &&
		    	($context->eventdatetime->endtime > $context->eventdatetime->starttime)) {
		    	if (substr($context->eventdatetime->endtime,0,10) != substr($context->eventdatetime->starttime,0,10)) {
		    	    // Not on the same day
		    	    if (strpos($context->eventdatetime->endtime,'00:00:00')) {
		    	        echo '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('l, F jS', $endu).'</abbr>';
		    	    } else {
		    	        echo '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('l, F jS g:i a', $endu).'</abbr>';
		    	    }
		    	} else {
 				    	    echo '-<abbr class="dtend" title="'.date(DATE_ISO8601, $endu).'">'.date('g:i a', $endu).'</abbr>';
		    	}
		    }
			?></td>
		</tr>
		<tr>
			<td class="date">Description:</td>	
			<td><p class='description'>
			<?php echo $savvy->dbStringtoHtml($context->event->description); ?></p>
			<?php
			if (isset($context->eventdatetime->additionalpublicinfo)) {
                echo '<p>Additional Public Info: '.$savvy->dbStringtoHtml($context->eventdatetime->additionalpublicinfo).'</p>';
            }
			if (isset($context->event->webpageurl)) {
			    echo 'Website: <a class="url" href="'.$savvy->dbStringtoHtml($context->event->webpageurl).'">'.$savvy->dbStringtoHtml($context->event->webpageurl).'</a>';
			}
			?>
			<?php if (isset($context->event->imagedata)) { ?>
				<img class="event_description_img" src="<?php echo UNL_UCBCN_Frontend::formatURL(array()); ?>?image&amp;id=<?php echo $context->event->id; ?>" alt="image for event <?php echo $context->event->id; ?>" />
			<?php } ?>	
			</td>
		</tr>
		<tr class="alt">
			<td class="date">Location:</td>
			<td>
				<?php
				if (isset($context->eventdatetime->room)) {
				    echo 'Room: '.$savvy->dbStringtoHtml($context->eventdatetime->room);
				}
				if ($loc = $context->eventdatetime->getLocation()) {
					UNL_UCBCN::displayRegion($loc);
				}
                if (isset($context->eventdatetime->directions)) {
                    echo '<p class="directions">Directions: '.$savvy->dbStringtoHtml($context->eventdatetime->directions).'</p>';
                }
				?>
			</td>
		</tr>
		<tr>
			<td class="date">Contact:</td>
			<td>
			<?php 
			    if (isset($context->event->listingcontactname) ||
					isset($context->event->listingcontactphone) ||
					isset($context->event->listingcontactemail)) {

					if (isset($context->event->listingcontactname)) echo '<div class="n">'.$context->event->listingcontactname.'</div>';
					if (isset($context->event->listingcontactphone)) echo '<div class="tel">'.$context->event->listingcontactphone.'</div>';
					if (isset($context->event->listingcontactemail)) echo '<div class="mailto">'.$context->event->listingcontactemail.'</div>';
				} ?>
			</td>
		</tr>
		</tbody>
		</table>
        <?php
            UNL_UCBCN::displayRegion($context->facebookRSVP);
            echo $context->facebook->like($context->url,$context->calendar->id);
            echo '<p id="feeds">
			<a id="icsformat" href="'.UNL_UCBCN_Frontend::reformatURL($context->url,array('format'=>'ics')).'">ics format for '.$savvy->dbStringtoHtml($context->event->title).'</a>
			<a id="rssformat" href="'.UNL_UCBCN_Frontend::reformatURL($context->url,array('format'=>'rss')).'">rss format for '.$savvy->dbStringtoHtml($context->event->title).'</a>
			</p>'; ?>
		</div>
	</div>
</div>