<?php

$startu = strtotime($context->getStartTime());
$endu   = strtotime($context->getEndTime());
$url    = $frontend->getCalendarURL().date('Y/m/d/', $startu).$context->eventdatetime->id;

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
		<h1 class='summary'><?php echo $savvy->dbStringtoHtml($context->event->title); ?> <a class="permalink" href="<?php echo $url; ?>">(link)</a></h1>
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
            <td><?php echo $savvy->render($context, 'EventInstance/Date.tpl.php') ?></td>
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
					echo $savvy->render($loc, 'Location.tpl.php');
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
//             echo $savvy->render($context->facebookRSVP);
//             echo $facebook->like($context->url, $context->calendar->id);
            echo '<p id="feeds">
			<a id="icsformat" href="'.$url.'.ics">ics format for '.$savvy->dbStringtoHtml($context->event->title).'</a>
			<a id="rssformat" href="'.$url.'.rss">rss format for '.$savvy->dbStringtoHtml($context->event->title).'</a>
			</p>'; ?>
		</div>
	</div>
</div>