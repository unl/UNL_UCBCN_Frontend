<?php
namespace UNL\UCBCN\Event;

use UNL\UCBCN\ActiveRecord\Record;
use UNL\UCBCN\Event;

/**
 * Table Definition for webcast
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
class Webcast extends Record
{

    public $id;                              // int(10)  not_null primary_key unsigned auto_increment
    public $event_id;                        // int(10)  not_null unsigned
    public $title;                           // string(100)
    public $status;                          // string(100)
    public $dateavailable;                   // datetime(19)  binary
    public $playertype;                      // string(100)
    public $bandwidth;                       // string(255)
    public $additionalinfo;                  // blob(4294967295)  blob

    public static function getTable()
    {
        return 'webcast';
    }

    
    function table()
    {
        return array(
            'id'=>129,
            'event_id'=>129,
            'title'=>2,
            'status'=>2,
            'dateavailable'=>14,
            'playertype'=>2,
            'bandwidth'=>2,
            'additionalinfo'=>66,
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
    
    function links()
    {
        return array('event_id' => 'event:id');
    }

    /**
     * Get the event related to this webcast
     * 
     * @return false|Event
     */
    public function getEvent()
    {
        return Event::getById($this->event_id);
    }
    
    /**
     * Get links to this webcast
     * 
     * @return Webcast\Links
     */
    function getWebcastLinks()
    {
        return new Webcast\Links(array('webcast_id' => $this->id));
    }
}
