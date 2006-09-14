<a href="<?php echo $this->url; ?>"><?php echo $this->day; ?></a>
<?php
    if (is_a($this->output,'UNL_UCBCN_EventListing')) {
        UNL_UCBCN::outputTemplate('UNL_UCBCN_EventListing','EventListing_month');
        UNL_UCBCN::displayRegion($this->output);
    }
?>