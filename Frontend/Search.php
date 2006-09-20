<?php
/**
 * Search class for frontend users to search for events.
 * 
 * 
 * @package UNL_UCBCN_Frontend
 * @author Brett Bieber
 */

require_once 'UNL/UCBCN/Frontend.php';
require_once 'UNL/UCBCN/EventListing.php';

class UNL_UCBCN_Frontend_Search extends UNL_UCBCN_Frontend
{
    var $calendar;
    var $output;
    var $query;
    var $starttime;
    var $endtime;
    
    function __construct($options=array())
	{
	    $this->view = 'search';
		$this->setOptions($options);
		$this->run();
	}
    
    function run()
    {
        $this->query = trim($this->query);
        if (!empty($this->query)) {
            $mdb2 = $this->calendar->getDatabaseConnection();
            $sql = 'SELECT DISTINCT eventdatetime.id FROM event, eventdatetime, calendar_has_event WHERE ' .
						'eventdatetime.event_id = event.id AND 
						calendar_has_event.event_id = event.id AND 
						calendar_has_event.status != \'pending\' AND 
						calendar_has_event.calendar_id = '.$this->calendar->id.' AND ';
			if ($t = strtotime($this->query)) {
				// This is a time...
				$sql .= 'eventdatetime.starttime LIKE \''.date('Y-m-d',$t).'%\' ORDER BY eventdatetime.starttime';
			} else {
				// Do a textual search.
				$sql .= 'event.title LIKE \'%'.$mdb2->escape($this->query).'%\' AND '.
				        '(eventdatetime.starttime>=\''.date('Y-m-d').' 00:00:00\' OR '.
						'eventdatetime.endtime>\''.date('Y-m-d').' 00:00:00\') ORDER BY event.title';
			}
			
			$res = $mdb2->query($sql);
			$this->output = new UNL_UCBCN_EventListing();
			$this->output->type = 'search';
			while ($row = $res->fetchRow()) {
				$this->output->events[] =  new UNL_UCBCN_EventInstance($row[0]);
			}
        } else {
            $this->output = 'Enter a search string to search for events.';
        }
    }
    
}

?>