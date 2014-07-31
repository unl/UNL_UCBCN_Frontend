<?php

namespace UNL\UCBCN\Frontend;

class DayIterator extends \IteratorIterator
{
    protected $calendar;
    
     public function __construct(\DatePeriod $iterator, Calendar $calendar) {
         $this->calendar = $calendar;
         parent::__construct($iterator);
     }
     
     public function current()
     {
         /* @var $datetime \DateTime */
         $datetime = parent::current();
         
         $options = array(
             'm' => $datetime->format('m'),
             'y' => $datetime->format('Y'),
             'd' => $datetime->format('d'),
             'calendar' => $this->calendar,
         );
         
         return new Day($options);
     }
}
