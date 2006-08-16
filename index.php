<?php
ini_set('display_errors',true);
require_once 'UNL/UCBCN/Frontend.php';

$GLOBALS['unl_template_dependents'] = $_SERVER['DOCUMENT_ROOT'].'/ucomm/templatedependents';

$front = new UNL_UCBCN_Frontend(array_merge(array('dsn'=>'mysqli://eventcal:eventcal@localhost/eventcal',
											'template'		=> 'default',
											'uri'			=> '',
											'uriformat'		=> 'querystring',
											'manageruri'	=> '',
											'default_calendar_id' => 1),
											UNL_UCBCN_Frontend::determineView()));
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
UNL_UCBCN::displayRegion($front);

?>