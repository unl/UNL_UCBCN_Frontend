<?php

$config_file = __DIR__ . '/../../config.sample.php';

if (file_exists(__DIR__ . '/../../config.inc.php')) {
    $config_file = __DIR__ . '/../../config.inc.php';
}
require_once $config_file;

require_once __DIR__ . '/../../vendor/composer/autoload.php';


use UNL\UCBCN\Manager\Auth as Auth;

$auth = new Auth;

$auth->authenticate();

echo 'HELLO THERE';
