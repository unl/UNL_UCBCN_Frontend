<h1 class="upcoming-heading">
    Upcoming Events
    <a title="ics format for upcoming events" href="<?php echo $frontend->getCalendarURL(); ?>upcoming/.ics"><span class="wdn-icon-calendar"></span></a>
</h1>

<?php echo $savvy->render($context, 'EventListing.tpl.php');?>
