<?php
$data = array();
$data['Events'] = array();

foreach ($context as $day) {
    foreach ($day as $eventInstance) {
        $data['Events'][] = $eventInstance->toJSONData();
    }
}

echo json_encode($data);
