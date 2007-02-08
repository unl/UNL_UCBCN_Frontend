<Events xsi:schemaLocation="urn:cde.berkeley.edu:babl:events:1.00 Events_1.9.xsd">
<?php
UNL_UCBCN::outputTemplate('UNL_UCBCN_EventInstance','EventInstance_xml');
UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend_Day','Frontend_Day_xml');
UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend_Search','Frontend_Day_xml');
UNL_UCBCN::outputTemplate('UNL_UCBCN_EventListing','EventListing_icalendar');
UNL_UCBCN::displayRegion($this->output);
?>
</Events>