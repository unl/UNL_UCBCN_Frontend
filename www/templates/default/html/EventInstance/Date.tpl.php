<?php
$classes = array('date-wrapper');
if ($context->isAllDay()) {
    $classes[] = 'all-day';
}

$starttime = $context->getStartTime();
$endtime = $context->getEndTime();
$startu = new DateTime($starttime);
$endu = new DateTime($endtime);
?>

<span class="date-wrapper">
    <?php if (!empty($starttime)): ?>
        <time class="dtstart" datetime="<?php echo $startu->format('c') ?>"><?php echo $startu->format('M. j, Y') ?></time>
    <?php endif; ?>
    <?php if (!empty($endtime) && $context->isOngoing()): ?>
        - <time class="dtend" datetime="<?php echo $endu->format('c') ?>"><?php echo $endu->format('M. j, Y')?></time>
    <?php endif; ?>
</span>
<span class="time-wrapper">
    <?php if ($context->isAllDay()): ?>
    All Day
    <?php else: ?>
        <?php echo $startu->format('g:i a')?>
        <?php if (!empty($endtime)): ?>
        - <?php echo $endu->format('g:i a')?>
        <?php endif; ?>
    <?php endif; ?>
    
</span>