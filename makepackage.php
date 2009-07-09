<?php
/**
 * This file creates a package.xml which describes the pear package to be built.
 * 
 * It provides the package.xml from which you can run pear package and create a 
 * distributable Package.tgz installable through the PEAR installer.
 * 
 * <code>
 * php makepackage.php make && pear package && pear install _______.tgz
 * </code>
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

ini_set('display_errors', true);
require_once 'PEAR/PackageFileManager2.php';
require_once 'PEAR/PackageFileManager/File.php';
require_once 'PEAR/Task/Postinstallscript/rw.php';
require_once 'PEAR/Config.php';
require_once 'PEAR/Frontend.php';

/**
 * @var PEAR_PackageFileManager
 */
PEAR::setErrorHandling(PEAR_ERROR_DIE);
chdir(dirname(__FILE__));
$pfm = PEAR_PackageFileManager2::importOptions('package.xml', array(
//$pfm = new PEAR_PackageFileManager2();
//$pfm->setOptions(array(
    'packagedirectory' => dirname(__FILE__),
    'baseinstalldir' => '/',
    'filelistgenerator' => 'svn',
    'ignore' => array(  'package.xml',
                        '.project',
                        '*.tgz',
                        '*.sh',
                        '*.svg',
                        'makepackage.php',
                        '*CVS/*',
                        '.cache',
                        'install.sh',
                        '*tests*'),
    'simpleoutput' => true,
    'roles'=>array('php'=>'data'),
    'exceptions'=>array('UNL/UCBCN/Frontend_setup.php'=>'php',
                        'UNL/UCBCN/Frontend.php'=>'php',
                        'UNL/UCBCN/Frontend/Month.php'=>'php',
                        'UNL/UCBCN/Frontend/Day.php'=>'php',
                        'UNL/UCBCN/Frontend/MonthWidget.php'=>'php',
                        'UNL/UCBCN/Frontend/NoEvents.php'=>'php',
                        'UNL/UCBCN/Frontend/Year.php'=>'php',
                        'UNL/UCBCN/Frontend/Search.php'=>'php',
                        'UNL/UCBCN/Frontend/Upcoming.php'=>'php',
                        'UNL/UCBCN/Frontend/Week.php'=>'php')
));
$pfm->setPackage('UNL_UCBCN_Frontend');
$pfm->setPackageType('php'); // this is a PEAR-style php script package
$pfm->setSummary('A public frontend for a University Event Publishing system.');
$pfm->setDescription('This class extends the UNL UCBCN backend system to create
            a client frontend. It allows users to view the calendar in a list view, thirty
            day view.');
$pfm->setChannel('pear.unl.edu');
$pfm->setAPIStability('beta');
$pfm->setReleaseStability('beta');
$pfm->setAPIVersion('0.8.0');
$pfm->setReleaseVersion('0.8.0');
$pfm->setNotes('
0.8.0 Changes:
* Rearrange SVN so frontend can be run from checkout.
* Default to vanilla template.
* Always call the factory statically.
* Support searching by event types.

Template Changes:
* Allow scrolling through the monthwidget with mouse scroll wheel
* Different coloring for month widget days on the next and previous months
* New sample of a mobile template.

Fixes:
* Ongoing events were not showing up on the their last day within the monthwidget.
* Call UNL_UCBCN_Frontend::factory() method statically - users should update their index.php files.

');

//$pfm->addMaintainer('lead','saltybeagle','Brett Bieber','brett.bieber@gmail.com');
//$pfm->addMaintainer('developer','alvinwoon','Alvin Woon','alvinwoon@gmail.com');
$pfm->setLicense('BSD License', 'http://www1.unl.edu/wdn/wiki/Software_License');
$pfm->clearDeps();
$pfm->setPhpDep('5.1.2');
$pfm->setPearinstallerDep('1.5.4');
$pfm->addPackageDepWithChannel('required', 'UNL_UCBCN', 'pear.unl.edu', '0.8.0');
$pfm->addPackageDepWithChannel('required', 'Calendar', 'pear.php.net', '0.5.3');
foreach (array('UNL/UCBCN/Frontend.php','UNL/UCBCN/Frontend_setup.php','index.php') as $file) {
    $pfm->addReplacement($file, 'pear-config', '@PHP_BIN@', 'php_bin');
    $pfm->addReplacement($file, 'pear-config', '@PHP_DIR@', 'php_dir');
    $pfm->addReplacement($file, 'pear-config', '@DATA_DIR@', 'data_dir');
    $pfm->addReplacement($file, 'pear-config', '@DOC_DIR@', 'doc_dir');
}

$config = PEAR_Config::singleton();
$log    = PEAR_Frontend::singleton();
$task   = new PEAR_Task_Postinstallscript_rw($pfm, $config, $log,
    array('name' => 'UNL/UCBCN/Frontend_setup.php', 'role' => 'php'));
$task->addParamGroup('questionCreate', array(
    $task->getParam('createtemplate', 'Create/Upgrade default templates?', 'string', 'yes'),
    $task->getParam('createindex', 'Create/Upgrade sample index page?', 'string', 'yes'),
    ));
$task->addParamGroup('fileSetup', array(
    $task->getParam('docroot', 'Path to root of webserver', 'string', '/Library/WebServer/Documents/events'),
    $task->getParam('template', 'Template style to use', 'string', 'vanilla')
    ));

$pfm->addPostinstallTask($task, 'UNL/UCBCN/Frontend_setup.php');
$pfm->generateContents();
if (isset($_SERVER['argv']) && $_SERVER['argv'][1] == 'make') {
    $pfm->writePackageFile();
} else {
    $pfm->debugPackageFile();
}
?>