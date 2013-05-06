<div class="calendar"></div>
<div class="day_cal">
<h4 class="sec_main">
<?php
$day = $context->getDateTime();
echo date('l, F jS',$day->getTimeStamp());
?> <a class="permalink" href="<?php echo $context->getURL(); ?>">(link)</a>
</h4>
<p id="day_nav">
<?php
    echo '<a class="url prev" href="'.$frontend->getCalendarURL().date('Y/m/d', $day->getTimeStamp()-86400).'">Previous Day</a> ';
    echo '<a class="url next" href="'.$frontend->getCalendarURL().date('Y/m/d', $day->getTimeStamp()+86400).'">Next Day</a></p>';

    echo $savvy->render($context, 'EventListing.tpl.php');

    echo '<p id="feeds">
            <a id="icsformat" title="ics format for events on '.date('l, F jS',$day->getTimeStamp()).'" href="'.$context->getURL().'.ics">ics format for events on '.date('l, F jS',$day->getTimeStamp()).'</a>
            <a id="rssformat" title="rss format for events on '.date('l, F jS',$day->getTimeStamp()).'" href="'.$context->getURL().'.rss">rss format for events on '.date('l, F jS',$day->getTimeStamp()).'</a>
            </p>'; ?>
</div>