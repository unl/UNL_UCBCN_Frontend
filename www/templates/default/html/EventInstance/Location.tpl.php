<?php
$row = "";
if (isset($context->eventdatetime->location_id) && $context->eventdatetime->location_id) {
    $l = $context->eventdatetime->getLocation();
    $row .= ' <span class="location">';
    if (isset($l->mapurl)) {
        $row .= '<a class="mapurl" href="'.$savvy->dbStringtoHtml($l->mapurl).'">'.$savvy->dbStringtoHtml($l->name).'</a>';
    } else {
        $row .= $savvy->dbStringtoHtml($l->name);
    }
    $row .= '</span>';
}
echo $row;