<?php if (isset($context->eventdatetime->location_id) && $context->eventdatetime->location_id): ?>
<?php $l = $context->eventdatetime->getLocation(); ?>
<?php if (isset($l->mapurl) || !empty($l->name)): ?>
    <span class="location eventicon-location">
<?php if (isset($l->mapurl)): ?>
        <a class="mapurl" href="<?php echo $l->mapurl ?>"><?php echo $savvy->dbStringtoHtml($l->name) ?></a>
<?php else: ?>
        <?php echo $savvy->dbStringtoHtml($l->name); ?>
<?php endif; ?>
    </span>
<?php endif; ?>
<?php endif; ?>
