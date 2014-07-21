<?php $formattedDate = $context->getDateTime()->format('l, F j'); ?>
<h1 class="day-heading" data-datetime="<?php echo $context->getDateTime()->format('c') ?>">
    <?php echo $formattedDate ?>
    <a class="permalink" href="<?php echo $context->getURL(); ?>" title="permalink"><span class="wdn-icon-link"></span></a>
    <a title="ics format for events on <?php echo $formattedDate ?>" href="<?php echo $context->getURL() ?>.ics"><span class="wdn-icon-calendar"></span></a>
</h1>
<p class="day-nav">
    <a class="url prev" href="<?php echo $context->getPreviousDay()->getURL(); ?>">Previous Day</a>
    <a class="url next" href="<?php echo $context->getNextDay()->getURL(); ?>">Next Day</a>
</p>
<?php echo $savvy->render($context, 'EventListing.tpl.php'); ?>
