<?php
ini_set('display_errors',true);
require_once 'UNL/UCBCN/Frontend/Day.php';

$front = new UNL_UCBCN_Frontend_Day(array('dsn'=>'mysqli://eventcal:eventcal@localhost/eventcal',
											'template'=>'default',
											'year'=>2006,
											'month'=>5,
											'day'=>3));

UNL_UCBCN::displayRegion($front);

?>