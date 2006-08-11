<?php
/**
 * This template file is for the icalendar and ics output formats.
 */
UNL_UCBCN::outputTemplate('UNL_UCBCN_Frontend_Day','Frontend_Day_icalendar');
ob_start();
UNL_UCBCN::displayRegion($this->output);
// Convert all line endings: line endings are windows-style, carriage-return, followed by a line feed
$out = ob_get_contents();
ob_clean();
echo str_replace("\n","\r\n",$out);
?>
