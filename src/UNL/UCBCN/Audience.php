<?php
namespace UNL\UCBCN;

use UNL\UCBCN\ActiveRecord\Record;
/**
 * Table Definition for audience
 *
 * PHP version 5
 *
 * @category  Events
 * @package   UNL_UCBCN
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://code.google.com/p/unl-event-publisher/
 */

/**
 * ORM for a record within the database.
 *
 * @package   UNL_UCBCN
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://code.google.com/p/unl-event-publisher/
 */
class Audience extends Record
{

    public $id;                              // int(10)  not_null primary_key unsigned auto_increment
    public $name;                            // string(100)
    public $standard;                        // int(1)

    function getTable()
    {
        return 'audience';
    }

    function table()
    {
        return array(
            'id'=>129,
            'name'=>2,
            'standard'=>17,
        );
    }

    function keys()
    {
        return array(
            'id',
        );
    }
    
    function sequenceKey()
    {
        return array('id',true);
    }
    
}
