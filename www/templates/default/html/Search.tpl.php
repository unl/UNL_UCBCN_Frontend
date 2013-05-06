<div class="day_cal">
<?php
if (is_a($context->output,'UNL_UCBCN_EventListing')) {
    if ($dt = strtotime($context->query)) {
        echo '<h1 class="results">Search results for events dated <span>'.date('F jS',$dt).'</span><a class="permalink" href="'.$context->url.'">(link)</a></h1>';
    } else {
        echo '<h1 class="results">Search results for "<span>'.htmlentities($context->query).'</span>"<a class="permalink" href="'.$context->url.'">(link)</a></h1>';
    }
    echo '<h3>'.count($context->output->events).' results</h3>';
}
echo $savvy->render($context->output);

echo '<p id="feeds">
            <a id="icsformat" title="ics format for search results" href="'.UNL_UCBCN_Frontend::reformatURL($context->url,array('format'=>'ics')).'">ics format for search results</a>
            <a id="rssformat" title="rss format for search results" href="'.UNL_UCBCN_Frontend::reformatURL($context->url,array('format'=>'rss')).'">rss format for search results</a>
            </p>';

?>

</div>