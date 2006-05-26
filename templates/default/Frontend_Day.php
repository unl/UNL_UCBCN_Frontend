<html>
<head>
<link rel="stylesheet" type="text/css" media="screen" href="templates/@TEMPLATE@/main.css" />
</head>
<body>

<div id="header"></div><!-- close header -->

<div id="container">

<div id="maintitle">
<h1>UNL's Event Publishing System</h1>
<h2>Plan. Publish. Share.</h2>
</div><!-- maintitle -->
	
<div id="main_left">

<div id="navigation">
<h3 id="sec_nav">Navigation</h3>
<?php echo $this->navigation; ?>
</div><!-- close navigation -->

<div id="maincontentarea">
<h3 id="sec_main">Main Screen</h3>
<?php
	UNL_UCBCN::displayRegion($this->events);
?>
</div><!-- close main content area -->

</div><!-- close main left -->
	
<div id="right_area">
<?php UNL_UCBCN::displayRegion($this->monthwidget); ?>
</div><!-- close right-area -->

</div><!-- close container -->
</body>
</html>