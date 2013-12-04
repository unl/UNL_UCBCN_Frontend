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
    /**
     * Determines the days of this month with events.
     *
     * @param Calendar_Month $month Month to find events in.
     *
     * @return an array with values representing the days with events.
     */
    public function dailyEventCount($month)
    {
        $db          =& $this->calendar->getDatabaseConnection();
        $days        = $month->fetchAll();
        $start_bound = date('Y-m-d', $days[1]->getTimestamp());
        $end_bound   = date('Y-m-d', $days[count($days)]->getTimestamp());
        $sql         = "SELECT DATE_FORMAT(eventdatetime.starttime,'%m-%d') AS day,
                               count(*) AS events
		                FROM calendar_has_event,eventdatetime
		                WHERE calendar_has_event.calendar_id={$this->calendar->id}
		                AND (calendar_has_event.status ='posted'
                             OR calendar_has_event.status ='archived')
		                AND calendar_has_event.event_id = eventdatetime.event_id
		                AND (eventdatetime.recurringtype = ''
		                     OR eventdatetime.recurringtype = 'none') 
		                AND eventdatetime.starttime >= '$start_bound 00:00:00'
						AND eventdatetime.starttime <= '$end_bound 23:59:59'
		                GROUP BY day;";
        $res         =& $db->queryCol($sql);
        return $res;
    }
    
    /**
     * This function finds ongoing events for the given month.
     *
     * @param Calendar_Month $month Month to find ongoing events for.
     *
     * @return array
     */
    public function findOngoingEvents($month)
    {
        $db      =& $this->calendar->getDatabaseConnection();
        $queries = array();
        $sql     = "CREATE TABLE IF NOT EXISTS `ongoingcheck` (`d` DATE NOT NULL DEFAULT '".date('Y-m-d')."', PRIMARY KEY ( `d` ))";
        $res     =& $db->query($sql);
        if (!PEAR::isError($res)) {
            while ( $day = $month->fetch() ) {
                $strdate = date('Y-m-d', $day->getTimestamp());
                if (!isset($firstday)) {
                    $firstday = $strdate;
                }
                $lastday = $strdate;
                $sql     = "INSERT INTO ongoingcheck VALUES ('$strdate');";
                $db->query($sql);
            }
            $sql = "SELECT DATE_FORMAT(og.d,'%m-%d') AS day, count(*) AS events
                FROM calendar_has_event,eventdatetime,ongoingcheck AS og
                WHERE calendar_has_event.calendar_id={$this->calendar->id}
                AND (calendar_has_event.status ='posted'
                     OR calendar_has_event.status ='archived')
                AND calendar_has_event.event_id = eventdatetime.event_id
                AND (eventdatetime.starttime < og.d
                     AND eventdatetime.endtime >= og.d)
                AND og.d >= '$firstday' AND og.d <= '$lastday'
                GROUP BY day;";
            $res =& $db->queryCol($sql);
            if (PEAR::isError($res)) {
                return array();
            } else {
                return $res;
            }
        } else {
            return array();
        }
    }
    
}
