<div class="wdn-grid-set">
    <section class="bp2-wdn-col-one-third">
        <h1 class="results">
            <?php
            if (($dt = strtotime($context->search_query)) && ($context->search_query != 'art')) {
                echo 'Search results for events dated <span>'.date('F jS',$dt).'</span></a>';
            } else {
                echo 'Search results for "<span>'.htmlentities($context->search_query).'</span>"';
            }
            ?>
        </h1>
        <?php echo '<span class="wdn-subhead">'.$context->count().' results.  <a class="permalink" href="'.$context->getURL().'">(link)</a></span>'; ?>

        <p id="feeds">
            <a id="icsformat" title="ics format for search results" href="<?php echo $context->getURL()?>?format=ics">ics format for search results</a>
            <a id="rssformat" title="rss format for search results" href="<?php echo $context->getURL()?>?format=rss">rss format for search results</a>
        </p>
    </section>
    <section id="updatecontent" class="day_cal bp2-wdn-col-two-thirds">
        <?php echo $savvy->render($context, 'EventListing.tpl.php'); ?>
    </section>
</div>
