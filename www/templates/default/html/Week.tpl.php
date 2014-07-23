<?php
$prev = $context->getDateTime()->modify('-1 week');
$next = $context->getDateTime()->modify('+1 week');
?>
<div class="week_cal" id="month_viewcal">
    <table class="wp-calendar">
        <caption>
            <span><a href="<?php echo $context->getPreviousURL(); ?>" id="prev_week" title="View events for week <?php echo $prev->format('W'); ?>" class="eventicon-angle-circled-left"></a></span>
            <span class="monthvalue">
                <a href="<?php echo $context->getURL(); ?>">Week <?php echo $context->getDateTime()->format('W'); ?>: <?php echo $context->getDateTime()->format('F'); ?></a>
            </span>
            <span class="yearvalue">
                <a href="<?php echo $context->getYearURL(); ?>"><?php echo $context->getDateTime()->format('Y'); ?></a>
            </span>
            <span><a href="<?php echo $context->getNextURL(); ?>" id="next_week" title="View events for week <?php echo $next->format('W'); ?>" class="eventicon-angle-circled-right"></a></span>
        </caption>
        <thead>
        <?php
        $weekdays = array(
            'Sunday' => 'Sun',
            'Monday' => 'Mon',
            'Tuesday' => 'Tue',
            'Wednesday' => 'Wed',
            'Thursday' => 'Thu',
            'Friday' => 'Fri',
            'Saturday' => 'Sat',
        );
        ?>
        <tr>
            <?php foreach ($weekdays as $full => $short): ?>
                <th scope="col" title="<?php echo $full; ?>"><?php echo $short; ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <tr>
        <?php
        $week = $context->getRawObject();
        foreach ($week as $day): 
        ?>
            <td>
                <?php echo $savvy->render($day, 'EventListing/Month.tpl.php'); ?>
            </td>
        <?php endforeach; ?>
        </tr>
        </tbody>
    </table>
</div>
