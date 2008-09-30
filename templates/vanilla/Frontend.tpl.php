<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <title><?php echo $this->calendar->name; ?></title>
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->uri; ?>templates/vanilla/screen.css" />
    </head>
    <body>
        <h1><?php echo $this->calendar->name; ?></h1>
        <div>
            <a href="<?php echo $this->manageruri; ?>">Event Publishing Manager</a>
        </div>
        <ul id="frontend_view_selector" class="<?php echo $this->view; ?>">
            <li id="todayview"><a href="<?php echo UNL_UCBCN_Frontend::formatURL(array('calendar'=>$this->calendar->id)); ?>">Today's Events</a></li>
            <li id="monthview"><a href="'<?php echo UNL_UCBCN_Frontend::formatURL(array('y'=>date('Y'),
                                                                                        'm'=>date('m'),
                                                                                        'calendar'=>$this->calendar->id)); ?>">This Month</a></li>
            <li id="yearview"><a href="<?php echo UNL_UCBCN_Frontend::formatURL(array('y'=>date('Y'),
                                                                                      'calendar'=>$this->calendar->id)); ?>">This Year</a></li>
            <li id="upcomingview"><a href="<?php echo UNL_UCBCN_Frontend::formatURL(array('calendar'=>$this->calendar->id,
                                                                                          'upcoming'=>'upcoming')); ?>">Upcoming</a></li>
        </ul>
        <!-- Month Widget -->
        <?php UNL_UCBCN::displayRegion($this->right); ?>
        <!-- Main output for the view determined by determineView() and populated with run() -->
        <?php UNL_UCBCN::displayRegion($this->output); ?>
        <div>
            <ul>
                <li><a href="<?php echo UNL_UCBCN_Frontend::formatURL(array('calendar'=>$this->calendar->id,'upcoming'=>'upcoming','format'=>'rss')); ?>&amp;limit=100" title="RSS feed">Calendar RSS feed</a></li>
                <li><a href="<?php echo UNL_UCBCN_Frontend::formatURL(array('calendar'=>$this->calendar->id,'upcoming'=>'upcoming','format'=>'ics')); ?>&amp;limit=100" title=".ical format">Calendar in .ical format</a></li>
            </ul>
        </div>
        <div class="footer">
            <h3>Yeah, It's Open Source</h3>
                The University Event Publishing System is an open source project
                built by the <a href="http://www.unl.edu/">University of Nebraska&ndash;Lincoln</a>
                which implements the UC Berkeley Calendar specifications.
            <ul>
                <li><a href="http://code.google.com/p/unl-event-publisher/">UNL Event Publisher</a></li>
            </ul>
        </div>
    </body>
</html>