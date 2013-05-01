<?php
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\Event;

class Image extends Event
{
    /**
     * Use for displaying the image for a given event.
     * $options['id'] must be set to the event.id which has the image.
     *
     * @return void
     */
    public function __construct($options = array())
    {
        if (!isset($options['id'])) {
            throw new Exception('You must pass an event id', 500);
        }
        $this->id = (int) $options['id'];
        $this->reload();

        if (!isset($this->imagedata)) {
            throw new Exception('No image data', 404);
        }
    }
}