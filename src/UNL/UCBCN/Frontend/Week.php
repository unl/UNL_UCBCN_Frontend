<?php
/**
 * This class contains the information needed for viewing a month view calendar.
 * 
 * PHP version 5
 * 
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @version   CVS: $id$
 * @link      http://code.google.com/p/unl-event-publisher/
 */
namespace UNL\UCBCN\Frontend;

/**
 * Constructs a week view for the calendar.
 * 
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://code.google.com/p/unl-event-publisher/
 */
class Week extends \IteratorIterator implements RoutableInterface
{
    /**
     * Calendar to show events for UNL_UCBCN_Month object
     * 
     * @var \UNL\UCBCN\Calendar
     */
    public $calendar;
    
    public $options = array(
        'w' => null,
        'y' => null,
    );
    
    /**
     * @var \DatePeriod
     */
    public $datePeriod;
    
    /**
     * Constructs this week object.
     * 
     * @param array $options Associative array of options.
     */
    public function __construct($options)
    {
        if (!isset($options['calendar'])) {
            throw new InvalidArgumentException('A calendar must be set', 500);
        }

        $this->calendar = $options['calendar'];
        
        // Set defaults
        $this->options['w'] = date('W');
        $this->options['y'] = date('Y');
        
        $this->options = $options + $this->options;
        
        $this->datePeriod = new \DatePeriod($this->getStartDateTime(), new \DateInterval('P1D'), $this->getEndDateTime());
        parent::__construct($this->datePeriod);
    }
    public function getDateTime()
    {
        return new \DateTime($this->options['y'] . '-' . 'W' . $this->options['w']);
    }
    
    public function getStartDateTime()
    {
        $start = $this->getDateTime();
        
        if (Month::$weekday_start != $start->format('l')) {
            $start->modify('last ' . Month::$weekday_start);
        }
        
        return $start;
    }
    
    public function getEndDateTime()
    {
        return $this->getStartDateTime()->modify('+1 week');
    }
    
    function current()
    {
        /* @var $datetime \DateTime */
        $datetime = parent::current();

        $options = array(
            'm' => $datetime->format('m'),
            'y' => $datetime->format('Y'),
            'd' => $datetime->format('d'),
        ) + $this->options;

        return new Day($options);
    }
    
    public static function generateURL(Calendar $calendar, \DateTime $datetime)
    {
        return $calendar->getURL() . $datetime->format('Y/\WW/');
    }

    /**
     * Returns the permanent URL to this specific week.
     * 
     * @return string URL to this week.
     */
    public function getURL()
    {
        return self::generateURL($this->calendar, $this->getDateTime());
    }
    
    public function getNextURL()
    {
        return self::generateURL($this->calendar, $this->getDateTime()->modify('+1 week'));
    }
    
    public function getPreviousURL()
    {
        return self::generateURL($this->calendar, $this->getDateTime()->modify('-1 week'));
    }
    
    public function getYearURL()
    {
        return Year::generateURL($this->calendar, $this->getDateTime());
    }
}
