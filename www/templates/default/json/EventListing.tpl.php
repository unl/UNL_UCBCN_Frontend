<?php
$data = array();
$data['Events'] = array();

foreach ($context as $eventInstance) {
    $data['Events'][] = $eventInstance->toJSONData();
}

echo json_encode($data);