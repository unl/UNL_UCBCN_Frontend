<?php
namespace UNL\UCBCN\Frontend;

class Calendar extends \UNL\UCBCN\Calendar
{
    public function getURL()
    {
        $url = Controller::$url;
        
        if (Controller::$default_calendar_id != $this->id) {
            $url .= urlencode($this->shortname) . '/';
        }
        
        return $url;
    }
}
