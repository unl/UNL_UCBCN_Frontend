<?php
if (isset($context->eventdatetime->location_id) && $context->eventdatetime->location_id) {
    $l = $context->eventdatetime->getLocation();
    echo ' <span class="location">';
    if (isset($l->mapurl)) {
        echo '<a class="mapurl" href="'.$savvy->dbStringtoHtml($l->mapurl).'">'.$savvy->dbStringtoHtml($l->name).'</a>';
    } else {
        echo $savvy->dbStringtoHtml($l->name);
    }
    echo '</span>';
}