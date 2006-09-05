<form method="get" action="<?php echo UNL_UCBCN_Frontend::formatURL(); ?>">
<input type='search' name='q' />
<input type='submit' name='submit' />
</form>
<?php
UNL_UCBCN::displayRegion($this->output);
?>