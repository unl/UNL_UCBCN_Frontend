<div class="calendar"></div>
<div class="day_cal">
<h4 class="sec_main">
<?php
$day = new Calendar_Day($context->year,$context->month,$context->day);
echo date('l, F jS',$day->getTimeStamp());
?> <a class="permalink" href="<?php echo $context->url; ?>">(link)</a>
</h4>
<p id="day_nav">
<?php
    $prev = $day->prevDay('object');
    echo '<a class="url prev" href="'.UNL_UCBCN_Frontend::formatURL(array(    'd'=>$prev->thisDay(),
                                                            'm'=>$prev->thisMonth(),
                                                            'y'=>$prev->thisYear(),
                                                            'calendar'=>$context->calendar->id)).'">Previous Day</a> ';
    $next = $day->nextDay('object');
    echo '<a class="url next" href="'.UNL_UCBCN_Frontend::formatURL(array(    'd'=>$next->thisDay(),
                                                            'm'=>$next->thisMonth(),
                                                            'y'=>$next->thisYear(),
                                                            'calendar'=>$context->calendar->id)).'">Next Day</a></p>';

    UNL_UCBCN::displayRegion($context->output);
    echo '<p id="feeds">
            <a id="icsformat" title="ics format for events on '.date('l, F jS',$day->getTimeStamp()).'" href="'.UNL_UCBCN_Frontend::reformatURL($context->url,array('format'=>'ics')).'">ics format for events on '.date('l, F jS',$day->getTimeStamp()).'</a>
            <a id="rssformat" title="rss format for events on '.date('l, F jS',$day->getTimeStamp()).'" href="'.UNL_UCBCN_Frontend::reformatURL($context->url,array('format'=>'rss')).'">rss format for events on '.date('l, F jS',$day->getTimeStamp()).'</a>
            </p>'; ?>
</div>