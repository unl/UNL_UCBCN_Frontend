<div class="location">
<?php
if (isset($context->mapurl)) {
    echo '<a class="mapurl" href="'.$savvy->dbStringtoHtml($context->mapurl).'">'.$savvy->dbStringtoHtml($context->name).'</a>';
} else {
    echo $savvy->dbStringtoHtml($context->name);
}

if (isset($context->streetaddress1)) {
    echo '<div class="adr">';
    echo '<span class="street-address">'.$savvy->dbStringtoHtml($context->streetaddress1).'<br />'.$savvy->dbStringtoHtml($context->streetaddress2).'</span>';
    if (isset($context->city)) {
        echo '<span class="locality">'.$savvy->dbStringtoHtml($context->city).'</span>';
    }
    if (isset($context->state)) {
        echo ' <span class="region">'.$savvy->dbStringtoHtml($context->state).'</span>';
    }
    if (isset($context->zip)) {
        echo ' <span class="postal-code">'.$savvy->dbStringtoHtml($context->zip).'</span>';
    }
    echo '</div>';
}
if (isset($context->directions)) {
    echo '<div class="directions">Directions: '.$savvy->dbStringtoHtml($context->directions).'</div>';
}
if (isset($context->additionalpublicinfo)) {
    echo '<div class="additionalinfo">Additional Info: '.$savvy->dbStringtoHtml($context->additionalpublicinfo).'</div>';
}
?>
</div>