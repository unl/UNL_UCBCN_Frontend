<rss version="2.0">
    <channel>
        <title><?php echo $context->calendar->name; ?> Events</title>
        <link><?php echo UNL_UCBCN_Frontend::formatURL(array('calendar'=>$context->calendar->id)); ?></link>
        <description>Events for <?php echo $context->calendar->name; ?></description>
        <language>en-us</language>
        <generator>UNL_UCBCN_Frontend-3.0</generator>
        <lastBuildDate><?php echo date('r'); ?></lastBuildDate>
        <?php
        UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend_Day','Frontend_Day_rss');
        UNL_UCBCN::outputTemplate('UNL_UCBCN_EventListing','EventListing_rss');
        UNL_UCBCN::outputTemplate('UNL_UCBCN_EventInstance','EventInstance_rss');
        UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend_Upcoming','Frontend_hcalendar');
        UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend_Search','Frontend_Day_rss');
        echo $savvy->render($context->output); ?>
    </channel>
</rss>