<?php
$classes = array('date-wrapper');
if ($context->isAllDay()) {
    $classes[] = 'all-day';
}

if ($context->isInProgress()) {
    $classes[] = 'in-progress';
}

if ($context->isOnGoing()) {
    $classes[] = 'ongoing';
}
?>

<span class="<?php echo implode(' ', $classes); ?>">
    <?php
    //Convert the times to something we can use.
    $startu = strtotime($context->eventdatetime->starttime);
    $endu = strtotime($context->eventdatetime->endtime);
    
    //get the start time
    if (isset($context->eventdatetime->starttime)) {
        ?>
        <abbr class="dtstart" title="<?php echo date('c', $startu); ?>">
            <span class="month"><?php echo date('M', $startu); ?></span>
            <span class="day"><?php echo date('j', $startu); ?></span>
            <span class="year"><?php echo date('Y', $startu); ?></span>
            <span class="time">
            <?php
            if ($context->isAllDay()) {
                ?>
                All Day
                <?php
            } else {
                if (date('i', $startu) == '00') {
                    echo date('g', $startu);
                } else {
                    echo date('g:i', $startu);
                }
            }
            ?>
                <span class="am-pm"><?php echo date('a', $startu); ?></span>
            </span>
        </abbr>
        <?php
    } else {
        echo 'Unknown';
    }
    
    //get the end time
    if ((isset($context->eventdatetime->endtime) 
            && $context->eventdatetime->endtime > $context->eventdatetime->starttime)
            && (!$context->isAllDay() || $context->isOngoing())) {
        ?>
        -<abbr class="dtend" title="<?php date(DATE_ISO8601, $endu) ?>">
            <span class="month"><?php echo date('M', $endu); ?></span>
            <span class="day"><?php echo date('j', $endu); ?></span>
            <span class="year"><?php echo date('Y', $endu); ?></span>
            <span class="time">
                <?php
                if (date('i', $endu) == '00') {
                    echo date('g', $endu);
                } else {
                    echo date('g:i', $endu);
                }
                ?>
                <span class="am-pm"><?php echo date('a', $endu); ?></span>
            </span>
        </abbr>
        <?php
    }
    ?>
</span>