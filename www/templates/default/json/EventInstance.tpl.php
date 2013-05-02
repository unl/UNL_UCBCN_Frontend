,
{
        "id":<?php echo $this->event->id; ?>,
        "title":"<?php echo htmlspecialchars($this->event->title); ?>",
        "start":<?php echo strtotime($this->eventdatetime->starttime); ?>,
        "end":<?php echo strtotime($this->eventdatetime->endtime); ?>,
        "url":"<?php echo htmlspecialchars_decode($this->url); ?>",
        "allDay":false
}

