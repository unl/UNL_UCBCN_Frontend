<?php
$data = array();
$data['events'] = array();

foreach ($context as $eventInstance) {
    $data['events'][] = convertEventToJsonArray($eventInstance);
}

echo json_encode($data);