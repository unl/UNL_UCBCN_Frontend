<?php 
$contactInfo = array(); 
foreach (array('listingcontactname', 'listingcontactphone') as $property) {
    if (isset($context->event->$property)) {
        $contactInfo[] = $context->event->$property;
    }
}
if (isset($context->event->listingcontactemail)) {
    $contactInfo[] = '<a href="mailto:' . $context->event->listingcontactemail . '">' . $context->event->listingcontactemail . '</a>';
}
?>
<?php if (!empty($contactInfo)): ?>
<div class="contact eventicon-vcard">
    <?php echo implode(', ', $contactInfo) ?>
</div>
<?php endif; ?>
