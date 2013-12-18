<?php
/**
 * This class defines a 30 day widget containing information for a given month.
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
 * Class defines a month widget, basically a table with 30 boxes representing the
 * days in the month. Days which have events will be selected.
 *
 * @category  Events
 * @package   UNL_UCBCN_Frontend
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://code.google.com/p/unl-event-publisher/
 */
class MonthWidget extends Month
{
    public $data = array();
    
    /**
     * Constructor for an individual day.
     *
     * @param array $options Associative array of options to apply.
     * @throws InvalidArgumentException
     */
    public function __construct($options)
    {
        parent::__construct($options);

        $this->data = $this->getEventTotals($this->datePeriod);
    }

    function current()
    {
        return $this->getInnerIterator()->current;
    }
    
    public function getDayURL()
    {
        return Day::generateURL($this->calendar, $this->current());
    }

    /**
     * This function finds ongoing events for the given month.
     *
     * @param $datePeriod
     * @internal param \UNL\UCBCN\Frontend\Calendar_Month $month Month to find ongoing events for.
     *
     * @return array
     */
    public function getEventTotals(\DatePeriod $datePeriod)
    {
        //Create a temporary table to store dates in every month.
        $db = \UNL\UCBCN\ActiveRecord\Database::getDB();
        $sql     = "CREATE TABLE IF NOT EXISTS `ongoingcheck` (`d` DATE NOT NULL DEFAULT '".date('Y-m-d')."', PRIMARY KEY ( `d` ))";
        $res     = $db->query($sql);
        
        if (!$res) {
            return array();
        }

        $values = array();
        foreach ($datePeriod as $date) {
            $strdate = $date->format('Y-m-d');
            
            $values[] = '("' . $strdate . '")';
            
            if (!isset($firstday)) {
                $firstday = $strdate;
            }
            $lastday = $strdate;
        }
        
        //Try to add this month's dates to the table.
        $sql = 'INSERT IGNORE INTO ongoingcheck VALUES ' . implode(', ', $values) . ';';
        $db->query($sql);
        
        //Using the temporary table, get the number of events for each date.
        $sql = "SELECT og.d AS day, count(*) AS events
                FROM ongoingcheck AS og
                JOIN calendar_has_event ON (calendar_has_event.calendar_id = " . (int)$this->calendar->id . ")
                JOIN eventdatetime as e ON (calendar_has_event.event_id = e.event_id)
            
                WHERE calendar_has_event.status IN ('posted', 'archived')
                AND og.d BETWEEN DATE(e.starttime) AND IF(DATE(e.endtime), DATE(e.endtime), DATE(e.starttime))
            
                AND og.d >= '$firstday' AND og.d <= '$lastday'
                GROUP BY day";
        $res = $db->query($sql);
        
        if (!$res) {
            return array();
        }
        
        $results = array();
        foreach ($res as $row) {
            $results[$row['day']] = $row['events'];
        }
        
        return $results;
    }
}
