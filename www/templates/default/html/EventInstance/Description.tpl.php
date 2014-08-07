<?php if (!empty($context->event->description)): ?>
<div class="description">
    <?php 
    $text = $savvy->dbStringtoHtml($context->getShortDescription());
    $text = $savvy->linkify($text);
    echo $text;
    ?>
</div>
<?php endif; ?>
