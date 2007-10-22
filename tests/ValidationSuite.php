<?php

if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "ValidationSuite::main");
}


require_once 'PHPUnit/Framework.php';
require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'URIValidationTest.php';

class ValidationSuite extends PHPUnit_Framework_TestSuite
{
    function __construct($name)
    {
        
    }
    
    /**
     * Runs the test suite.
     *
     * @return unknown
     */
    public static function main()
    {
        include_once "PHPUnit/TextUI/TestRunner.php";
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    /**
     * Adds the Services_W3C_HTMLValidatorTest suite.
     *
     * @return $suite
     */
    public static function suite()
    {
        $uris_to_check = array('http://localhost/events/',                      //Index
                               'http://localhost/events/?&y=2007&m=10&',        //Month
                               'http://localhost/events/?&y=2007&',             //YEAR
                               'http://localhost/events/?&upcoming=upcoming&',  //Upcoming
                               'http://localhost/events/?&search=search&q=Th',  //Search Results
                               'http://localhost/events/?&s=1',                 //Week View
        );        
        $suite = new PHPUnit_Framework_TestSuite('ValidationSuite tests');
        /** Add testsuites, if there is. */
        $suite->addTestSuite('ValidationSuite');
        foreach ($uris_to_check as $uri) {
            if (strpos($uri, 'http://localhost/')===false) {
                $test      = new URIValidationTest('testURI');
            } else {
                $test      = new URIValidationTest('testFragment');
            }
            $test->uri = $uri;
            $suite->addTest($test);
        }

        return $suite;
    }
}

// Call Services_W3C_HTMLValidatorTest::main() if file is executed directly.
if (PHPUnit_MAIN_METHOD == "ValidationSuite::main") {
    ValidationSuite::main();
}
?>