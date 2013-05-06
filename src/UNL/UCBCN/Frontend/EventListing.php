<?php
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\ActiveRecord\RecordList;

class EventListing extends RecordList
{
    public function getDefaultOptions()
    {
        return array(
            'listClass' => __CLASS__,
            'itemClass' => __NAMESPACE__ . '\\EventInstance',
        );
    }
}