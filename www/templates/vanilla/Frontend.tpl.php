<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <title><?php echo $this->calendar->name; ?></title>
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->uri; ?>templates/vanilla/screen.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->uri; ?>templates/vanilla/css/fullcalendar.css" />
        <?php 
        if (!isset($this->calendar->theme)) {
            $this->calendar->theme = "base";
        }
        ?>
        <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/<?php echo $this->calendar->theme ?>/jquery-ui.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
        <script src="<?php echo $this->uri; ?>templates/vanilla/javascript/fullcalendar.min.js"></script>
    </head>
    <body>
        <h1><?php echo $this->calendar->name; ?></h1>
        <div>
            <a href="<?php echo $this->manageruri; ?>">Event Publishing Manager</a>
        </div>

        <?php UNL_UCBCN::displayRegion($this->output); ?>

<script type='text/javascript'> 
$(document).ready(function() {
    $('.calendar').fullCalendar({
        theme: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        defaultView: 'agendaDay',
        events: '?fullcal&format=fullcal_json',
        date:  <?php echo $this->day; ?>,
        month: <?php echo $this->month-1; ?>,
        year:  <?php echo $this->year; ?>
    });
});
</script>

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