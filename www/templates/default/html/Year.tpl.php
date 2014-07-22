<h1 class="year_main"><?php echo $context->year; ?></h1>
<div class="year_cal wdn-grid-set bp1-wdn-grid-set-halves bp2-wdn-grid-set-thirds">
<?php foreach ($context->getRaw('monthwidgets') as $widget): ?>
<div class="wdn-col">
    <?php echo $savvy->render($widget) ?>
</div>
<?php endforeach; ?>
</div>
