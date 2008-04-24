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
 * @copyright 2007 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://pear.unl.edu/
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
    'baseinstalldir' => 'UNL/UCBCN',
    'filelistgenerator' => 'cvs',
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
    'roles'=>array('php'=>'data'    ),
    'exceptions'=>array('UNL_UCBCN_Frontend_setup.php'=>'php',
                        'Frontend.php'=>'php',
                        'Frontend/Month.php'=>'php',
                        'Frontend/Day.php'=>'php',
                        'Frontend/MonthWidget.php'=>'php',
                        'Frontend/NoEvents.php'=>'php',
                        'Frontend/Year.php'=>'php',
                        'Frontend/Search.php'=>'php',
                        'Frontend/Upcoming.php'=>'php',
                        'Frontend/Week.php'=>'php')
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
$pfm->setAPIVersion('0.5.0');
$pfm->setReleaseVersion('0.5.7');
$pfm->setNotes('
Bugfix Release:
* Events which were not \'all-day events\' and start on the last day displayed in the month widget were not showing up. - bsteere
* Fix searches for the word \'art\' - ART is a timezone identifier for Argentina, and would simply return the current time offset by a few hours. Fix provided by Mark Kornblum at Cornish.
* Fix mismatched variable name in getURL, pass through an ongoing event boolean when each day is constructed.

Template Updates:
UNL template -
* Compatibility updates for the icalendar format - 75 char limit etc.
* Ensure special chars are encoded in the XML output.
* Add additional public info and directions to the event instance output.
* Minor CSS tweaks.
* Add class to upcoming events header to allow styling.
* When you try to go back to today from event instance page on another month, return to today icon breaks.
* Increase default calendar subscription links to 100 upcoming items.

NEW Vanilla Template -
* Vanilla template can be used for frontend output - not dependent on the UNL templates.
To use the vanilla template, just enter \'vanilla\' when prompted for which template to use.
');

//$pfm->addMaintainer('lead','saltybeagle','Brett Bieber','brett.bieber@gmail.com');
//$pfm->addMaintainer('developer','alvinwoon','Alvin Woon','alvinwoon@gmail.com');
$pfm->setLicense('BSD License', 'http://www1.unl.edu/wdn/wiki/Software_License');
$pfm->clearDeps();
$pfm->setPhpDep('5.0.0');
$pfm->setPearinstallerDep('1.4.3');
$pfm->addPackageDepWithChannel('required', 'UNL_UCBCN', 'pear.unl.edu', '0.5.0');
$pfm->addPackageDepWithChannel('required', 'Calendar', 'pear.php.net', '0.5.3');
foreach (array('Frontend.php','UNL_UCBCN_Frontend_setup.php','index.php') as $file) {
    $pfm->addReplacement($file, 'pear-config', '@PHP_BIN@', 'php_bin');
    $pfm->addReplacement($file, 'pear-config', '@PHP_DIR@', 'php_dir');
    $pfm->addReplacement($file, 'pear-config', '@DATA_DIR@', 'data_dir');
    $pfm->addReplacement($file, 'pear-config', '@DOC_DIR@', 'doc_dir');
}

$config = PEAR_Config::singleton();
$log    = PEAR_Frontend::singleton();
$task   = new PEAR_Task_Postinstallscript_rw($pfm, $config, $log,
    array('name' => 'UNL_UCBCN_Frontend_setup.php', 'role' => 'php'));
$task->addParamGroup('questionCreate', array(
    $task->getParam('createtemplate', 'Create/Upgrade default templates?', 'string', 'yes'),
    $task->getParam('createindex', 'Create/Upgrade sample index page?', 'string', 'yes'),
    ));
$task->addParamGroup('fileSetup', array(
    $task->getParam('docroot', 'Path to root of webserver', 'string', '/Library/WebServer/Documents/events'),
    $task->getParam('template', 'Template style to use, default (UNL) or vanilla', 'string', 'default')
    ));

$pfm->addPostinstallTask($task, 'UNL_UCBCN_Frontend_setup.php');
$pfm->generateContents();
if (isset($_SERVER['argv']) && $_SERVER['argv'][1] == 'make') {
    $pfm->writePackageFile();
} else {
    $pfm->debugPackageFile();
}
?>