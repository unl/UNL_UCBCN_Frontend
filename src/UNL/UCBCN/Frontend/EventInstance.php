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
}