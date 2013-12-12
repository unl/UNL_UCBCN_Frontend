<?php
/**
 * This class is for the frontend view for an entire year.
 * 
 * It contains basically 4 rows of 3 months, for a total of 12
 * monthwidgets.
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
 * Generates a year view for the public frontend.
 *
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License 
 * @link      http://code.google.com/p/unl-event-publisher/ 
 */
class Year
{
    /**
     * Year to show events for.
     *
     * @var int
     */
    public $year;
    
    /**
     * Array of month widgets - UNL_UCBCN_Frontend_MonthWidget
     *
     * @var array
     */
    public $monthwidgets = array();
    
    /**
     * Calendar to display year for.
     *
     * @var \UNL\UCBCN\Calendar
     */
    public $calendar;
    
    public $options = array(
        'y' => null
    );
    
    /**
     * Constructor for a year calendar.
     *
     * @param array $options Array of options
     */
    public function __construct($options = array())
    {
        if (!isset($options['calendar'])) {
            throw new InvalidArgumentException('A calendar must be set', 500);
        }

        $this->calendar = $options['calendar'];
        
        $this->options = $options + $this->options;

        $this->year = $this->options['y'];

        $options = $this->options;
        for ($m=1;$m<=12;$m++) {
            $options['m'] = $m;
            $this->monthwidgets[] = new MonthWidget($options);
        }
    }

    /**
     * Get a permalink URL specific to this specific year
     *
     * @return string
     */
    public function getURL()
    {
        return self::generateURL($this->calendar, $this->getDateTime());
    }

    /**
     * Generate a Day URL for a specific calendar and date
     *
     * @param Calendar $calendar
     * @param \DateTime $datetime
     * @return string
     */
    public static function generateURL(Calendar $calendar, \DateTime $datetime)
    {
        return $calendar->getURL() . $datetime->format('Y') . '/';
    }


    /**
     * Get the date for this month
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return new \DateTime(
            $this->options['y'].'-01-01'
        );
    }
}
