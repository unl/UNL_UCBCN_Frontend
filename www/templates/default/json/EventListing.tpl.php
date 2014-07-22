<?php
$data = array();
$data['events'] = array();

foreach ($context as $eventInstance) {
    $data['events'][] = $eventInstance->toJSONData();
}

echo json_encode($data);