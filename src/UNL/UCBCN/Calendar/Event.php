<?php
namespace UNL\UCBCN\Calendar;

use UNL\UCBCN\ActiveRecord\Record;
/**
 * Table definition, and processing functions for calendar_has_event
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
 * @category  Events
 * @package   UNL_UCBCN
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://code.google.com/p/unl-event-publisher/
 */
class Event extends Record
{

    public $id;                              // int(10)  not_null primary_key unsigned auto_increment
    public $calendar_id;                     // int(10)  not_null multiple_key unsigned
    public $event_id;                        // int(10)  not_null multiple_key unsigned
    public $status;                          // string(100)  multiple_key
    public $source;                          // string(100)
    public $datecreated;                     // datetime(19)  binary
    public $uidcreated;                      // string(100)
    public $datelastupdated;                 // datetime(19)  binary
    public $uidlastupdated;                  // string(100)

    public static function getTable()
    {
        return 'calendar_has_event';
    }

    function table()
    {
        return array(
            'id'=>129,
            'calendar_id'=>129,
            'event_id'=>129,
            'status'=>2,
            'source'=>2,
            'datecreated'=>14,
            'uidcreated'=>2,
            'datelastupdated'=>14,
            'uidlastupdated'=>2,
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
        return array('event_id'       => 'event:id',
                     'calendar_id'    => 'calendar:id',
                     'uidcreated'     => 'users:uid',
                     'uidlastupdated' => 'users:uid');
    }
    
    
    /**
     * Performs an insert of a calendar_has_event record, and updates any subscribed
     * calenars.
     *
     * @return int ID of the inserted record.
     */
    public function insert()
    {
        $this->datecreated     = date('Y-m-d H:i:s');
        $this->datelastupdated = date('Y-m-d H:i:s');
        if (isset($_SESSION['_authsession'])) {
            $this->uidcreated     = $_SESSION['_authsession']['username'];
            $this->uidlastupdated = $_SESSION['_authsession']['username'];
        }
        $r = parent::insert();
        if ($r) {
            // Clean the cache on successful insert.
            UNL_UCBCN::cleanCache();
            if (self::processSubscriptions() && $this->status != 'pending') {
                $event = $this->getLink('event_id');
                if ($event->approvedforcirculation) {
                    Subscription::updateSubscribedCalendars($this->calendar_id, $this->event_id);
                }
            }
            //loop though all eventdatetimes for this event, creating facebook events.
            $eventdatetimes = UNL_UCBCN::factory('eventdatetime');
            $eventdatetimes->event_id = $this->event_id;
            $rows = $eventdatetimes->find();
            while ($eventdatetimes->fetch()) {
                $facebook = new \UNL\UCBCN\Facebook\Instance($eventdatetimes->id);
                $facebook->updateEvent();
            }
        }
        return $r;
    }
    
    /**
     * sets or gets the current status of processing subscriptions. This is used to
     * prevent other calendars from processing additional subscriptions while one is
     * in progress - a poor man's lock on the database.
     *
     * @param bool $status true or false
     *
     * @return bool The status of processing subscriptions.
     */
    public function processSubscriptions($status = null)
    {
        global $_UNL_UCBCN;
        if (isset($status)) {
            $_UNL_UCBCN['process_subscriptions'] = (bool) $status;
        } else {
            if (isset($_UNL_UCBCN['process_subscriptions'])) {
                return $_UNL_UCBCN['process_subscriptions'];
            } else {
                $_UNL_UCBCN['process_subscriptions'] = true;
            }
        }
        return $_UNL_UCBCN['process_subscriptions'];
    }
    
    /**
     * Performs an update on this calendar_has_event record.
     *
     * @return bool True on sucess
     */
    public function update()
    {
        $this->datelastupdated = date('Y-m-d H:i:s');
        if (isset($_SESSION['_authsession'])) {
            $this->uidlastupdated = $_SESSION['_authsession']['username'];
        }
        $r = parent::update();
        if ($r) {
            // Clean the cache on successful update.
            UNL_UCBCN::cleanCache();
            if ($this->status != 'pending' && $this->status != 'archived') {
                $event = $this->getLink('event_id');
                if ($event->approvedforcirculation) {
                    Subscription::updateSubscribedCalendars($this->calendar_id, $this->event_id);
                }
            }
        }
        //loop though all eventdatetimes for this event, updating facebook events.
        $eventdatetimes = UNL_UCBCN::factory('eventdatetime');
        $eventdatetimes->event_id = $this->event_id;
        $rows = $eventdatetimes->find();
        while ($eventdatetimes->fetch()) {
            $facebook = new \UNL\UCBCN\Facebook\Instance($eventdatetimes->id);
            $facebook->updateEvent();
        }
        return $r;
    }

    /**
     * Returns bool false if the calendar does not have the event,
     * otherwise returns status.
     *
     * @param UNL\UCBCN\Calendar $calendar Calendar to check.
     * @param UNL\UCBCN\Event    $event    Event to check.
     *
     * @return string status, or bool false
     */
    public static function getById($calendar_id, $event_id)
    {

        return self::getByAnyField(__CLASS__, 'calendar_id', $calendar_id, ' AND event_id = '.(int)$event_id);

    }

    /**
     * Removes this record - effectively removing this event from the calendar.
     *
     * @return bool true on success.
     */
    public function delete()
    {
        $r = parent::delete();
        if ($r) {
            // Clean the cache on successful delete.
            UNL_UCBCN::cleanCache();
        }
        return $r;
    }
}
