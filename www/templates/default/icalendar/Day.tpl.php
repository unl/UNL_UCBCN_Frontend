<?php
/**
 * This file controls a day view output for iCalendar information.
 */
UNL_UCBCN::outputTemplate('UNL_UCBCN_EventListing','EventListing_icalendar');

echo $savvy->render($context->output);
?>
