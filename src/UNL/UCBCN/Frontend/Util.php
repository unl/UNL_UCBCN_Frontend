<?php
namespace UNL\UCBCN\Frontend;

class Util
{
    /**
     * Multibye safe splitting for ical as per rfc2445
     * 
     * based on code from https://gist.github.com/hugowetterberg/81747
     * 
     * @param $value - the line to split
     * @return string
     */
    public static function ical_split($value) {
        $value = trim($value);
        $value = strip_tags($value);
        $value = preg_replace('/\n+/', ' ', $value);
        $value = preg_replace('/\s{2,}/', ' ', $value);

        $preamble_len = 0;

        $lines = array();
        while (strlen($value)>(75-$preamble_len)) {
            $space = (75-$preamble_len);
            $mbcc = $space;
            while ($mbcc) {
                $line = mb_substr($value, 0, $mbcc);
                $oct = strlen($line);
                if ($oct > $space) {
                    $mbcc -= $oct-$space;
                }
                else {
                    $lines[] = $line;
                    $preamble_len = 1; // Still take the tab into account
                    $value = mb_substr($value, $mbcc);
                    break;
                }
            }
        }
        if (!empty($value)) {
            $lines[] = $value;
        }

        return join($lines, "\r\n ");
    }
}