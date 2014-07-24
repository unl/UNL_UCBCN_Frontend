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
namespace UNL\UCBCN\Frontend;

$config_file = __DIR__ . '/../config.sample.php';

if (file_exists(__DIR__ . '/../config.inc.php')) {
    $config_file = __DIR__ . '/../config.inc.php';
}
require_once $config_file;

require_once __DIR__ . '/../vendor/composer/autoload.php';

use RegExpRouter as RegExpRouter;

$routes = include __DIR__ . '/../data/routes.php';
$router = new RegExpRouter\Router(array('baseURL' => Controller::$url));
$router->setRoutes($routes);
if (isset($_GET['model'])) {
    // Prevent injecting a specific model through the web interface
    unset($_GET['model']);
}

// Initialize Controller, and construct everything the user requested
$frontend = new Controller($router->route($_SERVER['REQUEST_URI'], $_GET));

// Now render what the user has requested
$savvy = new OutputController($frontend);
$savvy->addGlobal('frontend', $frontend);

echo $savvy->render($frontend);
