<?php
if (!isset($GLOBALS['unl_template_dependents'])) {
    $GLOBALS['unl_template_dependents'] = $_SERVER['DOCUMENT_ROOT'];
}

$view_class = str_replace('\\', '_', strtolower($context->options['model']));
?>
<!DOCTYPE html>
<!--[if IEMobile 7 ]><html class="ie iem7"><![endif]-->
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7) ]><html class="ie" lang="en"><![endif]-->
<!--[if !(IEMobile) | !(IE)]><!--><html lang="en"><!-- InstanceBegin template="/Templates/fixed.dwt" codeOutsideHTMLIsLocked="false" --><!--<![endif]-->
<head>
    <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/metanfavico.html'; ?>
    <!--
        Membership and regular participation in the UNL Web Developer Network
        is required to use the UNL templates. Visit the WDN site at
        http://wdn.unl.edu/. Click the WDN Registry link to log in and
        register your unl.edu site.
        All UNL template code is the property of the UNL Web Developer Network.
        The code seen in a source code view is not, and may not be used as, a
        template. You may not use this code, a reverse-engineered version of
        this code, or its associated visual presentation in whole or in part to
        create a derivative work.
        This message may not be removed from any pages based on the UNL site template.

        $Id: fixed.dwt | 252c2891a48c70db689be6d897d4f34768b8258a | Thu Aug 1 15:08:19 2013 -0500 | Kevin Abel  $
    -->
    <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/scriptsandstyles.html'; ?>
    <!-- InstanceBeginEditable name="doctitle" -->
    <title><?php if (!$context->getCalendar()): ?>Page Not Found - UNL Events
        <?php else: ?>UNL <?php
        if ($context->getCalendar()->id != UNL\UCBCN\Frontend\Controller::$default_calendar_id) {
            echo '| '.$context->getCalendar()->name.' ';
        }
        ?>| Events<?php endif; ?></title>
    <!-- InstanceEndEditable -->
    <!-- InstanceBeginEditable name="head" -->
    <!-- Place optional header elements here -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $frontend->getURL() ?>templates/default/html/css/events.css" />
    <?php if ($context->getCalendar()): ?>
    <link rel="alternate" type="application/rss+xml" title="<?php echo $context->getCalendar()->name; ?> Events" href="<?php echo $frontend->getCalendarURL(); ?>.rss" />
    <?php endif; ?>
    <link rel="home" href="<?php echo $context->getCalendarURL() ?>" />
    <link rel="search" href="<?php echo $frontend->getCalendarURL(); ?>search/" />
<?php if ($context->getRaw('output') instanceof UNL\UCBCN\Frontend\RoutableInterface): ?>
    <link rel="canonical" href="<?php echo $context->output->getURL() ?>" />
<?php endif; ?>
    <script id="script_main" src="<?php echo $frontend->getURL() ?>templates/default/html/js/events.min.js"></script>
    <!-- InstanceEndEditable -->
    <!-- InstanceParam name="class" type="text" value="" -->
</head>
<body class="terminal" data-version="4.0">
<?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/skipnav.html'; ?>
<div id="wdn_wrapper">
    <input type="checkbox" id="wdn_menu_toggle" value="Show navigation menu" class="wdn-content-slide wdn-input-driver" />
    <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/noscript-padding.html'; ?>
    <header id="header" role="banner" class="wdn-content-slide wdn-band">
        <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/wdnResources.html'; ?>
        <div class="wdn-inner-wrapper">
            <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/logo.html'; ?>
            <div id="wdn_resources">
                <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/idm.html'; ?>
                <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/wdnTools.html'; ?>
            </div>
            <span id="wdn_institution_title">University of Nebraska&ndash;Lincoln</span>
        </div>
        <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/apps.html'; ?>
        <div class="wdn-inner-wrapper">
            <div id="wdn_site_title">
                    <span><!-- InstanceBeginEditable name="titlegraphic" -->
                        <?php echo $context->getCalendar() ? $context->getCalendar()->name : 'UNL'; ?> Events
                        <!-- InstanceEndEditable --></span>
            </div>
        </div>
    </header>
    <div id="wdn_navigation_bar" role="navigation" class="wdn-band">
        <nav id="breadcrumbs" class="wdn-inner-wrapper">
            <!-- WDN: see glossary item 'breadcrumbs' -->
            <h3 class="wdn_list_descriptor wdn-text-hidden">Breadcrumbs</h3>
            <!-- InstanceBeginEditable name="breadcrumbs" -->
            <!-- InstanceEndEditable -->
        </nav>
        <div id="wdn_navigation_wrapper">
            <nav id="navigation" role="navigation" class="wdn-band">
                <h3 class="wdn_list_descriptor wdn-text-hidden">Navigation</h3>
                <!-- InstanceBeginEditable name="navlinks" -->
                <!-- InstanceEndEditable -->
                <label for="wdn_menu_toggle" class="wdn-icon-menu">Menu</label>
            </nav>
        </div>
    </div>
    <!-- Navigation Trigger -->
    <div class="wdn-menu-trigger wdn-content-slide">
        <label for="wdn_menu_toggle" class="wdn-icon-menu">Menu</label>
    </div>
    <!-- End navigation trigger -->
    <div id="wdn_content_wrapper" role="main" class="wdn-content-slide">
        <div class="wdn-band">
            <div class="wdn-inner-wrapper">
                <div id="pagetitle">
                    <!-- InstanceBeginEditable name="pagetitle" -->
                    <!-- InstanceEndEditable -->
                </div>
            </div>
        </div>
        <div id="maincontent" class="wdn-main">
            <!--THIS IS THE MAIN CONTENT AREA; WDN: see glossary item 'main content area' -->
            <!-- InstanceBeginEditable name="maincontentarea" -->
            <?php if ($context->getCalendar()): ?>
            <div class="wdn-band view-<?php echo $view_class; ?> band-nav">
                <div class="wdn-inner-wrapper">
                    <div class="wdn-grid-set">
                        <div class="wdn-col-full">
                            <div class="events-nav">
                                <div class="submit-search">
                                    <a id="frontend_login" class="eventicon-plus-circled" href="<?php echo UNL\UCBCN\Frontend\Controller::$manager_url; ?>">Submit an Event</a>
                                    <form id="event_search" method="get" action="<?php echo $frontend->getCalendarURL(); ?>search/" role="search">
                                        <label for="searchinput">Search Events</label>
                                        <div class="wdn-input-group">
                                            <input type="text" name="q" id="searchinput" title="Search Query" placeholder="e.g., Monday, tomorrow" value="<?php if (isset($context->options['q'])) { echo $context->options['q']; } ?>" />
                                            <span class="wdn-input-group-btn">
                                                <button type="submit" class="wdn-icon-search" title="Search"></button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                <ul id="frontend_view_selector" class="<?php echo $view_class; ?>">
                                    <li id="todayview"><a href="<?php echo $frontend->getCurrentDayURL(); ?>">Today</a></li>
                                    <li id="weekview"><a href="<?php echo $frontend->getCurrentWeekURL(); ?>">Week</a></li>
                                    <li id="monthview"><a href="<?php echo $frontend->getCurrentMonthURL(); ?>">Month</a></li>
                                    <li id="yearview"><a href="<?php echo $frontend->getCurrentYearURL(); ?>">Year</a></li>
                                    <li id="upcomingview"><a href="<?php echo $frontend->getUpcomingURL(); ?>">Upcoming</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="wdn-band view-<?php echo $view_class; ?> band-results">
                <div class="wdn-inner-wrapper">
                    <?php
                        $template = null;
                        if ($context->output->getRawObject() instanceof Exception) {
                            $template = 'Exception.tpl.php';
                        }
                        echo $savvy->render($context->output, $template);
                    ?>
                </div>
            </div>
            <!-- InstanceEndEditable -->
            <!--THIS IS THE END OF THE MAIN CONTENT AREA.-->
        </div>
    </div>
    <div class="wdn-band wdn-content-slide" id="wdn_optional_footer">
        <div class="wdn-inner-wrapper">
            <!-- InstanceBeginEditable name="optionalfooter" -->
            <!-- InstanceEndEditable -->
        </div>
    </div>
    <footer id="footer" role="contentinfo" class="wdn-content-slide">
        <div class="wdn-band" id="wdn_footer_related">
            <div class="wdn-inner-wrapper">
                <!-- InstanceBeginEditable name="leftcollinks" -->
                <!-- InstanceEndEditable -->
            </div>
        </div>
        <div class="wdn-band">
            <div class="wdn-inner-wrapper">
                <div class="footer_col" id="wdn_footer_contact">
                    <h3>Contact Us</h3>
                    <div class="wdn-contact-wrapper">
                        <!-- InstanceBeginEditable name="contactinfo" -->
                        <!-- InstanceEndEditable -->
                    </div>
                </div>
                <div id="wdn_copyright">
                    <div class="wdn-footer-text">
                        <!-- InstanceBeginEditable name="footercontent" -->
                        Powered by <a href="http://code.google.com/p/unl-event-publisher/">UNL Event Publisher</a>. Yeah, it's open source<br />
                        &copy; <?php echo date('Y'); ?> University of Nebraska&ndash;Lincoln
                        <!-- InstanceEndEditable -->
                        <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/wdn.html'; ?>
                    </div>
                    <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/logos.html'; ?>
                </div>
            </div>
        </div>
        <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/footer_floater.html'; ?>
    </footer>
    <?php include_once $GLOBALS['unl_template_dependents'].'/wdn/templates_4.0/includes/noscript.html'; ?>
</div>
</body>
<!-- InstanceEnd --></html>
