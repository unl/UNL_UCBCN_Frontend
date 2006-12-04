<div class="day_cal">
<?php
if (is_a($this->output,'UNL_UCBCN_EventListing')) {
    if ($dt = strtotime($this->query)) {
        echo '<h1 class="results">Search results for events dated '.date('F jS',$dt).'</h1>';
    } else {
        echo '<h1 class="results">Search results for "'.htmlentities($this->query).'"</h1>';
    }
    echo '<h3>'.count($this->output->events).' results</h3>';
}
UNL_UCBCN::displayRegion($this->output);

echo '<p id="feeds">
			<a id="icsformat" title="ics format for search results" href="'.UNL_UCBCN_Frontend::reformatURL($this->url,array('format'=>'ics')).'">ics format for search results</a>
			<a id="rssformat" title="rss format for search results" href="'.UNL_UCBCN_Frontend::reformatURL($this->url,array('format'=>'rss')).'">rss format for search results</a>
			</p>';

?>

</div>