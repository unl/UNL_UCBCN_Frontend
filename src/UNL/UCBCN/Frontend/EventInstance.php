<?php
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\Event\Occurrence;

class EventInstance
{
    /**
     * The event date & time record
     *
     * @var \UNL\UCBCN\Event\Occurrence
     */
    public $eventdatetime;

    /**
     * The event details
     *
     * @var \UNL\UCBCN\Event
     */
    public $event;

    function __construct($options = array())
    {
        if (!isset($options['id'])) {
            throw new Exception('No event specified', 404);
        }
        
        $this->eventdatetime = Occurrence::getById($options['id']);

        if (false === $this->eventdatetime) {
            throw new Exception('No event with that id exists', 404);
        }

        $this->event = $this->eventdatetime->getEvent();
    }

    /**
     * Get an event instance
     *
     * @param int $id Primary Key for eventdatetime table
     *
     * @return \UNL\UCBCN\Frontend\EventInstance
     */
    public static function getById($id)
    {
        return new self(array('id'=>$id));
    }

    /**
     * @param $baseURL - The baseurl of the current calendar
     *
     * @return string - The absolute url for the event instance
     */
    public function getURL($baseURL)
    {
        return $baseURL . date('Y/m/d/', strtotime($this->eventdatetime->starttime)) . $this->eventdatetime->id;
    }

    /**
     * Determines if this is an ongoing event.
     *
     * An 'ongoing' event is defined as an event that spans more than one day.
     *
     * @return bool
     */
    public function isOngoing()
    {

        $start = date('m-d-Y', strtotime($this->eventdatetime->starttime));
        $end   = date('m-d-Y', strtotime($this->eventdatetime->endtime));

        //It is not an ongoing event if it starts and ends on the same day.
        if ($start == $end) {
            return false;
        }

        return true;
    }

    /**
     * Determines if this event is currently happening.
     * 
     * @return bool
     */
    public function isHappening()
    {
        if (strtotime($this->eventdatetime->starttime) > time()) {
            //It has not started yet.
            return false;
        }

        if (strtotime($this->eventdatetime->endtime) < time()) {
            //It already finished.
            return false;
        }

        return false;
    }
}