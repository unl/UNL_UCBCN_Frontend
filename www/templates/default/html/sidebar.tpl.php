<div class="calendar">
    <?php echo $savvy->render($context->getMonthWidget()); ?>
</div>

<div id="subscribe">
    <span>Subscribe to this calendar</span>
    <ul id="droplist">
        <li id="eventrss"><a href="<?php echo $frontend->getUpcomingURL(); ?>?format=rss&amp;limit=100" title="RSS feed of upcoming events" class="eventicon-rss">RSS</a></li>
        <li id="eventical"><a href="<?php echo $frontend->getUpcomingURL(); ?>?format=ics&amp;limit=100" title="ICS format of upcoming events" class="wdn-icon-calendar">ICS</a></li>
    </ul>
</div>