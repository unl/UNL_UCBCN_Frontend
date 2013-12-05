<?php
namespace UNL\UCBCN\Frontend;

class Calendar extends \UNL\UCBCN\Calendar
{
    public function getURL()
    {
        return Controller::$url . urlencode($this->shortname) . '/';
    }
}
