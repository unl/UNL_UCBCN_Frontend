<?php if (!empty($context->event->description)): ?>
<div class="description">
    <?php echo $savvy->dbStringtoHtml($context->getShortDescription()) ?>
</div>
<?php endif; ?>
