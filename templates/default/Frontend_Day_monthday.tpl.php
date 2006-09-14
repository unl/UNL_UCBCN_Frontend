<a href="<?php echo $this->link; ?>"><?php echo $this->day; ?></a>
<?php
    UNL_UCBCN::outputTemplate('UNL_UCBCN_EventListing','EventListing_month');
	UNL_UCBCN::displayRegion($this->output);
?>