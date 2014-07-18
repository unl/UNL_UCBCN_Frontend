<?php
$starttime = $context->getStartTime();
$endtime = $context->getEndTime();
$startu = new DateTime($starttime);
$endu = new DateTime($endtime); 
?>
<span class="time-wrapper">
<?php 
    if (!$context->isAllDay()) {
        if (intval($startu->format('i')) == 0) {
            echo $startu->format('g');
        } else {
            echo $startu->format('g:i');
        }
        
        if (!empty($endtime)) {
            echo '-';
            if (intval($endu->format('i')) == 0) {
                echo $endu->format('g');
            } else {
                echo $endu->format('g:i');
            }
        }
    }
?>
</span>