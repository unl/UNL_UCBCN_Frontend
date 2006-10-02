<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" ><!-- InstanceBegin template="/Templates/php.fixed.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $this->doctitle; ?></title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" type="text/css" media="screen" href="/ucomm/templatedependents/templatecss/layouts/main.css" />
<link rel="stylesheet" type="text/css" media="print" href="/ucomm/templatedependents/templatecss/layouts/print.css"/>
<script type="text/javascript" src="/ucomm/templatedependents/templatesharedcode/scripts/all_compressed.js"></script>

<?php require_once($GLOBALS['unl_template_dependents'].'/templatesharedcode/includes/browsersniffers/ie.html'); ?>
<?php require_once($GLOBALS['unl_template_dependents'].'/templatesharedcode/includes/comments/developersnote.html'); ?>
<?php require_once($GLOBALS['unl_template_dependents'].'/templatesharedcode/includes/metanfavico/metanfavico.html'); ?>
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->uri; ?>templates/@TEMPLATE@/frontend_main.css" />
<script type="text/javascript" src="<?php echo $this->uri; ?>templates/@TEMPLATE@/util.js"></script>
<script type="text/javascript" src="<?php echo $this->uri; ?>templates/@TEMPLATE@/ajaxCaller.js"></script>
<script type="text/javascript" src="<?php echo $this->uri; ?>templates/@TEMPLATE@/frontend.js"></script>


<link rel="alternate" type="application/rss+xml" title="<?php echo $this->calendar->name; ?> Events" href="<?php echo UNL_UCBCN_Frontend::formatURL(array('calendar'=>$this->calendar->id,'format'=>'rss')); ?>" />
<!-- InstanceEndEditable -->
</head>
<body id="fixed">
<!-- InstanceBeginEditable name="siteheader" -->
<?php require_once($GLOBALS['unl_template_dependents'].'/templatesharedcode/includes/siteheader/siteheader.shtml'); ?>
<!-- InstanceEndEditable -->
<div id="red-header">
	<div class="clear">
		<h1>University of Nebraska&ndash;Lincoln</h1>
		<div id="breadcrumbs"> <!-- InstanceBeginEditable name="breadcrumbs" -->
			<!-- WDN: see glossary item 'breadcrumbs' -->
			<ul>
				<li class="first"><a href="http://www.unl.edu/">UNL</a></li>
				<?php
				if (!empty($this->calendar->website) && ($this->calendar->id != $GLOBALS['_UNL_UCBCN']['default_calendar_id'])) {
				    echo '<li><a href="'.$this->calendar->website.'">'.$this->calendar->name.'</a></li>';
				}
			    ?>
				<li>Events</li>
			</ul><img src="<?php echo $this->uri; ?>templates/@TEMPLATE@/images/eventbeta.png" alt="Event publishing system is still in beta phase" id="badge" />
			<!-- InstanceEndEditable --> </div>
	</div>
</div>
<!-- close red-header -->
  
<?php require_once($GLOBALS['unl_template_dependents'].'/templatesharedcode/includes/shelf/shelf.shtml'); ?>

<div id="container">
	<div class="clear">
		<div id="title"> <!-- InstanceBeginEditable name="collegenavigationlist" --> <!-- InstanceEndEditable -->
			<div id="titlegraphic">
				<!-- WDN: see glossary item 'title graphics' -->
				<!-- InstanceBeginEditable name="titlegraphic" -->
				<h1><?php echo $this->calendar->name; ?> Events</h1>
				<?php if ($this->calendar->id == $GLOBALS['_UNL_UCBCN']['default_calendar_id']) { ?>
				<h2>What We Do Is Your Business</h2>
				<?php } else {
				echo '<h2></h2>';
				      } ?>
				<!-- InstanceEndEditable --></div>
			<!-- maintitle -->
		</div>
		<!-- close title -->
		
		<div id="navigation">
			<h4 id="sec_nav">Navigation</h4>
			<!-- InstanceBeginEditable name="navcontent" -->
			<div id="navlinks">
				
			</div>
			<!-- InstanceEndEditable -->
			<div id="nav_end"></div>
			<!-- InstanceBeginEditable name="leftRandomPromo" -->
			<!-- InstanceEndEditable -->
			<!-- WDN: see glossary item 'sidebar links' -->
			<div id="leftcollinks"> <!-- InstanceBeginEditable name="leftcollinks" -->
				<h3>Related Links</h3>
				<ul>
					<li><a href="<?php echo $this->manageruri; ?>">Event Publishing Manager</a></li>
				</ul>
				<!-- InstanceEndEditable --> </div>
		</div>
		<!-- close navigation -->
		
		<div id="main_right" class="mainwrapper">
			<!--THIS IS THE MAIN CONTENT AREA; WDN: see glossary item 'main content area' -->
		<div id="load"></div>
			<div id="maincontent"> 
			<?php echo $this->navigation; ?>
			<!-- InstanceBeginEditable name="maincontent" -->
			<form id="event_search" name="event_search" method="get" action="<?php echo UNL_UCBCN_Frontend::formatURL(array('calendar'=>$this->calendar->id,'search'=>'search')); ?>">
				<input type='search' name='q' id='searchinput' value="<?php if (isset($_GET['q'])) { echo htmlentities($_GET['q']); } ?>" />
				<input type='submit' name='submit' value="Search" />
				<input type='hidden' name='search' value='search' />
			<p id="search_term">Search smartly: In addition to normal keyword search, you can also search with chronological terms such as 'tomorrow', 'Monday' and etc.
			<a href="#" title="close search tip">(close message)</a>
			</p>
			
			</form>
				<?php if (isset($this->right)) { ?>
					<div class="col left">
						<?php UNL_UCBCN::displayRegion($this->right); ?>
						<div class="cal_widget">
						<h3>Have a Blackboard account?</h3>
						<ul>
						<li id="login_list"><a id="frontend_login" href="<?php echo $this->manageruri; ?>">Log in</a> </li>
						<li><a href="http://supportcenteronline.com/ics/support/default.asp?deptID=583&amp;task=knowledge&amp;questionID=2169">Get a Blackboard account</a> </li>
						<li><a href="http://www1.unl.edu/comments/">Feedback</a> </li>
						</ul></div>
						
						    
      <div id="subscribe" onmouseover="if(!g_bH){document.getElementById('droplist').style.display='block';}" onmouseout="if(!g_bH){document.getElementById('droplist').style.display='none';}">
        <span>Subscribe to UNL's events</span> 
        <ul id="droplist">
          <li id="eventrss"><a href="<?php echo UNL_UCBCN_Frontend::formatURL(array('calendar'=>$this->calendar->id,'format'=>'rss')); ?>" title="RSS feed">RSS feed</a></li>
          <li id="eventical"><a href="<?php echo UNL_UCBCN_Frontend::formatURL(array('calendar'=>$this->calendar->id,'format'=>'ics')); ?>" title=".ical format">.ical format</a></li>
          </ul>
      </div>
											
					</div>
					<div id="updatecontent" class="three_col right">
					<?php UNL_UCBCN::displayRegion($this->output); ?>
					</div>
					
				<?php } else {
					UNL_UCBCN::displayRegion($this->output);
				} ?>
				<!-- InstanceEndEditable --> </div>
			 </div>
		<!-- close main right -->
	</div>
</div>
<!-- close container -->

<div id="footer">
	<div id="footer_floater"> <!-- InstanceBeginEditable name="optionalfooter" -->
		<div class="footer_col">
			<h3>Yeah, It's Open Source</h3>
				The University Event Publishing System is an open source project
				built by the University of Nebraska&ndash;Lincoln which implements
				the UC Berkeley Calendar specifications.
				<ul>
					<li><a href="http://ucommdev.unl.edu/webdev/wiki/index.php/UNL_Calendar_Project">UNL Event Publisher</a></li>
					<li><a href ="http://www.berkeley.edu/">UC Berkeley</a></li>
					<li><a href="http://groups.sims.berkeley.edu/EventCalendar/">UC Berkeley Calendar Network</a></li>
				</ul>
		</div>
		<div class="footer_col">
			<h3>How Was This Built?</h3>
				<p>The University Event Publisher was built by the 
				<a href="http://www.unl.edu/webdevnet/">UNL Web Developer Network</a>.
				For more information see <a href="http://ucommdev.unl.edu/webdev/wiki/index.php/UNL_Calendar_Project">the project documentation.</a></p>
				<p>The UNL Event publisher is a <br />
					<a href="http://microformats.org/"><img src="<?php echo $this->uri; ?>templates/@TEMPLATE@/images/microformats.png" alt="microformats community mark" /> Microformats</a> Enabled hCalendar</p>
		</div>
		<div class="footer_col">
				<h3>Ongoing Development</h3>
				The ongoing development is handled through the UNL 
				<abbr title="PHP Extension and Application Repository">PEAR</abbr> compatible channel
				<a href="http://pear.unl.edu/">http://pear.unl.edu/</a>.
				If you find an error, or have a feature request or just want to get involved this is the place.
				</div>
		<div class="footer_col">
			<h3>Event Publishers</h3>
			Event publishers can start using the University Event Publisher immediately. Simply
			<a href="<?php echo $this->manageruri; ?>">log in</a> using your My.UNL (Blackboard) username and password.</div>
		<!-- InstanceEndEditable -->
		<div id="copyright"> <!-- InstanceBeginEditable name="footercontent" -->
			Yeah, it's open source. &copy; 2006 University of Nebraska&ndash;Lincoln
			<!-- InstanceEndEditable --> <span><a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> <a href="http://validator.w3.org/check/referer">W3C</a> <a href="http://www-1.unl.edu/feeds/">RSS</a> </span><a href="http://www.unl.edu/" title="UNL Home"><img src="/ucomm/templatedependents/templatecss/images/wordmark.png" alt="UNL's wordmark" id="wordmark" /></a></div>
	</div>
</div>

<!-- close footer -->
<!-- sifr -->
<script type="text/javascript" src="/ucomm/templatedependents/templatesharedcode/scripts/sifr_replacements.js"></script>
</body>
<!-- InstanceEnd --></html>
