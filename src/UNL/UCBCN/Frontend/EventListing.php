<?php
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\ActiveRecord\RecordList;

class EventListing extends RecordList
{
    /**
     * Calendar \UNL\UCBCN\Frontend\Calendar Object
     *
     * @var \UNL\UCBCN\Frontend\Calendar
     */
    public $calendar;

    /**
     * Constructor for an individual day.
     *
     * @param array $options Associative array of options to apply.
     */
    public function __construct($options)
    {
        if (!isset($options['calendar'])) {
            throw new Exception('A calendar must be set', 500);
        }

        $this->calendar = $options['calendar'];

        parent::__construct($options);
    }
    
    public function getDefaultOptions()
    {
        return array(
            'listClass' => __CLASS__,
            'itemClass' => __NAMESPACE__ . '\\EventInstance',
        );
    }

    public function current()
    {
        $options = $this->options + \LimitIterator::current();
        
        return new $this->options['itemClass']($options);
    }
}