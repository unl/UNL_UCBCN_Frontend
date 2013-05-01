<div class="location">
<?php
if (isset($this->mapurl)) {
    echo '<a class="mapurl" href="'.$savvy->dbStringtoHtml($this->mapurl).'">'.$savvy->dbStringtoHtml($this->name).'</a>';
} else {
    echo $savvy->dbStringtoHtml($this->name);
}

if (isset($this->streetaddress1)) {
    echo '<div class="adr">';
    echo '<span class="street-address">'.$savvy->dbStringtoHtml($this->streetaddress1).'<br />'.$savvy->dbStringtoHtml($this->streetaddress2).'</span>';
    if (isset($this->city)) {
        echo '<span class="locality">'.$savvy->dbStringtoHtml($this->city).'</span>';
    }
    if (isset($this->state)) {
        echo ' <span class="region">'.$savvy->dbStringtoHtml($this->state).'</span>';
    }
    if (isset($this->zip)) {
        echo ' <span class="postal-code">'.$savvy->dbStringtoHtml($this->zip).'</span>';
    }
    echo '</div>';
}
if (isset($this->directions)) {
    echo '<div class="directions">Directions: '.$savvy->dbStringtoHtml($this->directions).'</div>';
}
if (isset($this->additionalpublicinfo)) {
    echo '<div class="additionalinfo">Additional Info: '.$savvy->dbStringtoHtml($this->additionalpublicinfo).'</div>';
}
?>
</div>