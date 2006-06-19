<h3><?php echo $this->event->title; ?></h3>
<h4><?php echo date('l, F jS',strtotime($this->eventdatetime->starttime)); ?></h4>
<p><?php echo $this->event->description; ?></p>