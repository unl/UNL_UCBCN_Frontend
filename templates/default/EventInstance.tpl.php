<h1><?php echo $this->event->title; ?></h1>
<h2><?php echo date('l, F jS',strtotime($this->eventdatetime->starttime)); ?></h2>
<p><?php echo $this->event->description; ?></p>