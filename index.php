<?php
ini_set('display_errors',true);
require_once 'UNL/UCBCN/Frontend.php';

$GLOBALS['unl_template_dependents'] = $_SERVER['DOCUMENT_ROOT'].'/ucomm/templatedependents';

$view = 'day';
if (isset($_GET['y'])&&!empty($_GET['y'])) {
	$y = (int)$_GET['y'];
	$view = 'year';
} else {
	$y = Date('Y');
}
if (isset($_GET['m'])&&!empty($_GET['m'])) {
	$view = 'month';
	$m = (int)$_GET['m'];
} else {
	$m = Date('m');
}
if (isset($_GET['d'])&&!empty($_GET['d'])) {
	$view = 'day';
	$d = (int)$_GET['d'];
} else {
	$d = date('j');
}
if (isset($_GET['id'])&&!empty($_GET['id'])) {
	$view = 'event';
}

if (isset($_GET['format'])) {
	$format = $_GET['format'];
} else {
	$format = 'html';
}

$front = new UNL_UCBCN_Frontend(array('dsn'=>'mysqli://eventcal:eventcal@localhost/eventcal',
											'template'		=> 'default',
											'uri'			=> '',
											'manageruri'	=> '',
											'year'			=> $y,
											'month'			=> $m,
											'day'			=> $d));
if (isset($_GET['calendar_shortname'])&&!empty($_GET['calendar_shortname'])) {
	$front->calendar = $front->factory('calendar');
	$front->calendar->shortname = $_GET['calendar_shortname'];
	if (!$front->calendar->find()) {
		header('HTTP/1.0 404 Not Found');
		$front->output[] = new UNL_UCBCN_Error('The calendar you requested could not be found.');
	} else {
		$front->calendar->fetch();
	}
}
$front->run($view,$format);
UNL_UCBCN::displayRegion($front);

?>