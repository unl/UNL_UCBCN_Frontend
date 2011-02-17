<?php 
foreach ($this->events as $event) {
?>,
{
    "id":<?php echo $event->event->id; ?>,
    "title":"<?php echo htmlspecialchars($event->event->title); ?>",
    "start":<?php echo strtotime($event->eventdatetime->starttime); ?>,
    "end":<?php echo strtotime($event->eventdatetime->endtime); ?>,
    "url":"<?php echo htmlspecialchars_decode($event->url); ?>",
    "allDay":false
}
<?php
}
?>