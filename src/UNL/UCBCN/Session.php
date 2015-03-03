<?php
namespace UNL\UCBCN;

use UNL\UCBCN\ActiveRecord\Record;
/**
 * Table Definition for session
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
class Session extends Record
{

    public $user_uid;                        // string(255)  not_null primary_key
    public $lastaction;                      // datetime(19)  not_null binary
    public $data;                            // blob(4294967295)  blob

    public static function getTable()
    {
        return 'session';
    }

    function table()
    {
        return array(
            'user_uid'=>130,
            'lastaction'=>142,
            'data'=>66,
        );
    }

    function keys()
    {
        return array(
            'user_uid',
        );
    }
    
    function sequenceKey()
    {
        return array(false, false);
    }
    
    function links()
    {
        return array('user_uid' => 'user:uid');
    }
    
}
