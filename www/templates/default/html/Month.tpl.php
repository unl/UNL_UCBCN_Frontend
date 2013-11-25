<div class="month_cal" id="month_viewcal">
<table class="wp-calendar">
	<caption><?php echo $context->getDateTime()->format('F, Y'); ?></caption>
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
            echo $savvy->render($day, 'EventListing/Month.tpl.php');
            echo '</td>';
	    }
        echo '</tr>';
		?>
	</tbody>
</table>
<a href="#" id="monthfullview" onclick="fullview()">View all events</a>
</div>