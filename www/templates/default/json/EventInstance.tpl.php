,
{
        "id":<?php echo $context->event->id; ?>,
        "title":"<?php echo htmlspecialchars($context->event->title); ?>",
        "start":<?php echo strtotime($context->eventdatetime->starttime); ?>,
        "end":<?php echo strtotime($context->eventdatetime->endtime); ?>,
        "url":"<?php echo htmlspecialchars_decode($context->url); ?>",
        "allDay":false
}

