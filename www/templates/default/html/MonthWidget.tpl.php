<?php
$prev = $context->getPreviousMonth();
$next = $context->getNextMonth();
$year = $context->getYear();
?>
<table class="wp-calendar">
	<caption>
        <span><a href="<?php echo $prev->getURL() ?>" id="prev_month" title="View events for <?php echo $prev->getDateTime()->format('F') ?>">&lt;&lt; </a></span>
        <span class="monthvalue">
            <a href="<?php echo $context->getURL() ?>"><?php echo $context->getDateTime()->format('F') ?></a>
        </span>
        <span class="yearvalue">
            <a href="<?php echo $year->getURL() ?>"><?php echo $year->getDateTime()->format('Y') ?></a>
        </span>
        <span><a href="<?php echo $next->getURL() ?>" id="next_month" title="View events for <?php echo $next->getDateTime()->format('F') ?>"> &gt;&gt;</a></span>

    </caption>
    <thead>
    <?php
    $weekdays = array(
        'Sunday'    => 'Sun',
        'Monday'    => 'Mon',
        'Tuesday'   => 'Tue',
        'Wednesday' => 'Wed',
        'Thursday'  => 'Thu',
        'Friday'    => 'Fri',
        'Saturday'  => 'Sat',
    );
    ?>
    <tr>
        <?php foreach ($weekdays as $full=>$short): ?>
            <th abbr="<?php echo $full; ?>" scope="col" title="<?php echo $full; ?>"><?php echo $short; ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
	<tbody>
    <?php
    $first = true;
    $month = $context->getRawObject();
    foreach ($month as $day) {
        if (UNL\UCBCN\Frontend\Month::$weekday_start == $day->getDateTime()->format('l')) {
            // Start of a new week, so start a new table row
            if (!$first) {
                echo '</tr>';
                $first = false;
            }
            echo '<tr>';
        }
        $class = '';
        if ($day->options['m'] < $context->options['m']) {
            $class = 'prev';
        } elseif ($day->options['m'] > $context->options['m']) {
            $class = 'next';
        }
        echo '<td class="'.$class.'">';
        
        $d = $day->getDateTime()->format('j');
        if (count($day)) {
            echo '<a href="' . $day->getURL() . '">' . $d . '</a>';
        } else {
            echo $d;
        }

        echo '</td>';
    }
    echo '</tr>';
    ?>
	</tbody>
</table>
