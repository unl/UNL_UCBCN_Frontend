<?php
/**
 * This file parses the configuration and connection details for the catalog database.
 * 
 * @package UNL_UCBCN
 * @author bbieber
 */

function autoload($class)
{
    $class = str_replace(array('_', '\\'), '/', $class);
    include $class . '.php';
}

spl_autoload_register('autoload');

set_include_path(
    __DIR__ . '/src' . PATH_SEPARATOR
  . __DIR__ . '/backend/src' . PATH_SEPARATOR
  . __DIR__ . '/vendor/php'
);

ini_set('display_errors', true);
error_reporting(E_ALL);


UNL\UCBCN\Frontend\Controller::$url = '/workspace/UNL_UCBCN_Frontend/www/';

UNL\UCBCN\ActiveRecord\Database::setDbSettings(
    array(
    'host'     => 'localhost',
    'user'     => 'events',
    'password' => 'events',
    'dbname'   => 'events',
));
