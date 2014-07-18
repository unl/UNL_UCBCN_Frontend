<?php
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\Event;

class Image
{
    public $event = false;

    /**
     * Use for displaying the image for a given event.
     * $options['id'] must be set to the event.id which has the image.
     *
     * @param array $options
     * @throws UnexpectedValueException
     * @return \UNL\UCBCN\Frontend\Image
     */
    public function __construct($options = array())
    {      
        if (!isset($options['id'])) {
            throw new UnexpectedValueException('You must pass an event id', 500);
        }

        if (!$this->event = Event::getById($options['id'])) {
            throw new UnexpectedValueException('The event could not be found', 404);
        }

        if (!isset($this->event->imagedata)) {
            throw new UnexpectedValueException('No image data', 404);
        }
    }
}