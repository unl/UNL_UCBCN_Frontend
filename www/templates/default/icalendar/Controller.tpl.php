<?php
/**
 * This template file is for the icalendar and ics output formats.
 */
ob_start(); ?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//UNL_UCBCN//NONSGML UNL Event Publisher//EN
X-WR-CALNAME:<?php echo $context->options['calendar']->name."\n"; ?>
CALSCALE:GREGORIAN
X-WR-TIMEZONE:America/Chicago
METHOD:PUBLISH
BEGIN:VTIMEZONE
TZID:America/Chicago
BEGIN:DAYLIGHT
TZOFFSETFROM:-0600
RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU
DTSTART:20070311T020000
TZNAME:CDT
TZOFFSETTO:-0500
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:-0500
RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU
DTSTART:20071104T020000
TZNAME:CST
TZOFFSETTO:-0600
END:STANDARD
END:VTIMEZONE
<?php echo $savvy->render($context->output); ?>
END:VCALENDAR
<?php
// Convert all line endings: line endings are windows-style, carriage-return, followed by a line feed
$out = ob_get_contents();
ob_clean();
$out = explode("\n", $out);
foreach ($out as $line) {
    if (strlen($line) < 75) {
        echo $line."\r\n";
    } else {
        $folded = '';
        while (strlen($line) > 75) {
            $folded .= substr($line, 0, 74)."\r\n";
            $line = ' '.substr($line, 74);
        }
        echo $folded.$line."\r\n";
    }
}
?>
