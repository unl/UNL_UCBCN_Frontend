<html>
<head>
<link rel="stylesheet" type="text/css" media="screen" href="templates/@TEMPLATE@/main.css" />
<title><?php echo $this->doctitle; ?></title>
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
<?php
	UNL_UCBCN::displayRegion($this->output);
?>
</div><!-- close main content area -->

</div><!-- close main left -->

<div id="right_area">
<?php UNL_UCBCN::displayRegion($this->right); ?>
</div><!-- close right-area -->

</div><!-- close container -->
</body>
</html>