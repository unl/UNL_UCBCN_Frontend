<?php
/**
 * Sample index file for running the frontend. This is a simple file which creates
 * a new UNL_UCBCN_Frontend object and handles sending the output to the user.
 *
 * PHP version 5
 *
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://code.google.com/p/unl-event-publisher/
 */
ini_set('display_errors', false);
require_once 'UNL/UCBCN/Autoload.php';

if (file_exists(dirname(dirname(__FILE__)).'/UNL_UCBCN')) {
    // Allow to run from a checkout
    set_include_path(dirname(dirname(__FILE__)).'/UNL_UCBCN'.PATH_SEPARATOR.get_include_path());
}

$front = new UNL_UCBCN_Frontend(array_merge(array(
            'dsn'                 => 'mysqli://eventcal:eventcal@localhost/eventcal',
            'template'            => 'vanilla',
            'uri'                 => '',
            'uriformat'           => 'querystring',
            'manageruri'          => 'manager/',
            'default_calendar_id' => 1),
            UNL_UCBCN_Frontend::determineView()));
if (isset($_GET['calendar_shortname'])&&!empty($_GET['calendar_shortname'])) {
    $front->calendar            = UNL_UCBCN_Frontend::factory('calendar');
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