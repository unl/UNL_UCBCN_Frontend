<div class="wdn-grid-set">
    <section class="bp2-wdn-col-one-third">
        <h1 class="results">
            <?php
            if ($dt = $context->getSearchTimestamp()) {
                echo 'Search results for events dated <span>'.date('F jS',$dt).'</span></a>';
            } else {
                echo 'Search results for "<span>'.htmlentities($context->search_query).'</span>"';
            }
            ?>
        </h1>
        <?php echo '<span class="wdn-subhead">'.$context->count().' results.  <a class="permalink" href="'.$context->getURL().'">(link)</a></span>'; ?>

        <div id="subscribe">
            <span>Subscribe to this search</span>
            <ul id="droplist">
                <li id="eventrss"><a href="<?php echo $context->getURL()?>?format=rss" title="RSS feed of upcoming events" class="eventicon-rss">RSS</a></li>
                <li id="eventical"><a href="<?php echo $context->getURL()?>?format=ics" title="ICS format of upcoming events" class="wdn-icon-calendar">ICS</a></li>
            </ul>
        </div>
    </section>
    <section id="updatecontent" class="day_cal bp2-wdn-col-two-thirds">
        <?php echo $savvy->render($context, 'EventListing.tpl.php'); ?>
    </section>
</div>
