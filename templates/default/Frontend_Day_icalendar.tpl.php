<?php
/**
 * This file controls a day view output for iCalendar information.
 */
UNL_UCBCN::outputTemplate('UNL_UCBCN_EventListing','EventListing_icalendar');
?>
BEGIN:VCALENDAR
CALSCALE:GREGORIAN
X-WR-TIMEZONE;VALUE=TEXT:US/Central
METHOD:PUBLISH
VERSION:2.0
<?php
	UNL_UCBCN::displayRegion($this->output);
?>
END:VCALENDAR