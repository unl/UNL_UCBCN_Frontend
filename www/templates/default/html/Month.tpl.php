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
            
            $class = 'selected';
            $day_timestamp = $day->getDateTime()->modify('first day of this month')->format('U');
            $current_timestamp = $context->getDateTime('first day of this month')->format('U');
            if ($day_timestamp < $current_timestamp) {
                $class = 'prev';
            } elseif ($day_timestamp  > $current_timestamp) {
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