<?php
    /**
     * This sets up the format for XML
     */
    UNL_UCBCN::outputTemplate('UNL_UCBCN_EventListing','EventListing_icalendar');
    echo $savvy->render($context->output); ?>