<a href="<?php echo $context->url; ?>"><?php echo $context->day; ?></a><span class="monthvalue_ID"><?php echo $context->month; ?></span>
<?php
    UNL_UCBCN::outputTemplate('UNL_UCBCN_EventListing','EventListing_month');
    UNL_UCBCN::displayRegion($context->output);
?>