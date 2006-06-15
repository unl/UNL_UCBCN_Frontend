<?php
ini_set('display_errors',true);
require_once 'UNL/UCBCN/Frontend/Day.php';

if (isset($_GET['y'])) {
	$y = (int)$_GET['y'];
} else {
	$y = Date('Y');
}
if (isset($_GET['m'])) {
	$m = (int)$_GET['m'];
} else {
	$m = Date('m');
}
if (isset($_GET['d'])) {
	$d = (int)$_GET['d'];
} else {
	$d = date('j');
}

$front = new UNL_UCBCN_Frontend_Day(array('dsn'=>'mysqli://eventcal:eventcal@localhost/eventcal',
											'template'	=> 'default',
											'year'		=> $y,
											'month'		=> $m,
											'day'		=> $d));

UNL_UCBCN::displayRegion($front);

?>