<?php
ini_set('display_errors',true);
require_once 'UNL/UCBCN/Frontend.php';

$view = 'day';
if (isset($_GET['y'])) {
	$y = (int)$_GET['y'];
	$view = 'year';
} else {
	$y = Date('Y');
}
if (isset($_GET['m'])) {
	$view = 'month';
	$m = (int)$_GET['m'];
} else {
	$m = Date('m');
}
if (isset($_GET['d'])) {
	$view = 'day';
	$d = (int)$_GET['d'];
} else {
	$d = date('j');
}

$front = new UNL_UCBCN_Frontend(array('dsn'=>'mysqli://eventcal:eventcal@localhost/eventcal',
											'template'	=> 'default',
											'year'		=> $y,
											'month'		=> $m,
											'day'		=> $d));

$front->run($view);
UNL_UCBCN::displayRegion($front);

?>