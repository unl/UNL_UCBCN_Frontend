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

    /**
     * Calendar \UNL\UCBCN\Frontend\Calendar Object
     *
     * @var \UNL\UCBCN\Frontend\Calendar
     */
    public $calendar;

    function __construct($options = array())
    {
        if (!isset($options['id'])) {
            throw new Exception('No event specified', 404);
        }
        
        if (!isset($options['calendar'])) {
            throw new Exception('A calendar must be set', 500);
        }
        
        $this->calendar = $options['calendar'];
        
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
     * @return string - The absolute url for the event instance
     */
    public function getURL()
    {
        return $this->calendar->getURL() . date('Y/m/d/', strtotime($this->eventdatetime->starttime)) . $this->eventdatetime->id . '/';
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
     * Determines if this event is currently in progress.
     * 
     * @return bool
     */
    public function isInProgress()
    {
        $currentTime = time();
        
        if (strtotime($this->eventdatetime->starttime) > $currentTime) {
            //It has not started yet.
            return false;
        }

        if (strtotime($this->eventdatetime->endtime) < $currentTime) {
            //It already finished.
            return false;
        }

        return false;
    }

    /**
     * Determines if this event is an all day event.
     *
     * @return bool
     */
    public function isAllDay()
    {
        //It must start at midnight to be an all day event
        if (strpos($this->eventdatetime->starttime, '00:00:00') === false) {
            return false;
        }

        //It must end at midnight, or not have an end date.
        if (!empty($this->eventdatetime->endtime) &&
            strpos($this->eventdatetime->endtime, '00:00:00') === false) {
            return false;
        }

        return true;
    }
}